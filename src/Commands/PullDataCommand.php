<?php

namespace Koders\EstimationModule\Commands;

use Illuminate\Console\Command;
use Koders\EstimationModule\API\DispositionApi;
use Koders\EstimationModule\Models\EstimationResult;
use Illuminate\Support\Facades\Log;
use App\Models\Estimation;
use Koders\EstimationModule\Services\ApplyCharacteristicService;

class PullDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'koders:pull-data {estimation_id} {--estate=} {--estate-estimation=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull data inside the estimation_modules and calculate the estimation';

    public function handle()
    {
        $estimationId = $this->argument('estimation_id');
        $estate = $this->option('estate');
        $estimationEstateType = $this->option('estate-estimation');

        $estimation = Estimation::where('id', $estimationId)->first();

        $perPage = 10;
        $page = 1;

        $results = EstimationResult::query()
            ->where('estimation_id', $estimationId)
            ->orderBy('id')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();


        $dispositions = [];
        $local_types = ['maison', 'appartement'];
        $criteria = json_decode($estimation->details_bien, true);

        while ($results->isNotEmpty()) {
            foreach ($results as $result) {
                $disposition = DispositionApi::getOne($result['disposition_id'], $estate);

                if (in_array($estimationEstateType, $local_types)) {

                    $parcelles = $disposition['parcelles'];

                    $parcelleLocal = array_filter($parcelles, function ($parcelle) use ($criteria, $estimation) {

                        $parcelleWithLocal = (array_filter(
                            $parcelle['locaux'],
                            function ($loc) use ($criteria, $estimation) {
                                $tenPercentSurface = 10;
                                return $loc['majic_nb_pieces_principales'] == $criteria['nb_pieces'] && $loc['majic_surface_reelle_bati'] <= ($criteria['surface_habitable'] + $tenPercentSurface) && $loc['majic_surface_reelle_bati'] >= ($criteria['surface_habitable'] - $tenPercentSurface) && $loc["l_majic_code_type_local"] == $estimation->bien;
                            }
                        ));


                        return !empty($parcelleWithLocal);
                    });

                    if (!empty($parcelleLocal))
                        $dispositions[] = $disposition;
                }
            }

            $page++;

            $results = EstimationResult::query()
                ->where('estimation_id', $estimationId)
                ->orderBy('id')
                ->skip(($page - 1) * $perPage)
                ->take($perPage)
                ->get();
        }

        $estimationValue = count($dispositions) > 0 ? (array_reduce($dispositions, fn($carry, $item) => $carry += $item['fidji_valeur_fonciere'], 0) / count($dispositions)) : 0;

        if ($estimationValue == 0)
            $estimation->estimation_value = $estimationValue;
        else {
            $estimationValue = ApplyCharacteristicService::run($estimation, $estimationValue);
            $estimation->estimation_value = $estimationValue;
        }
        $estimation->dispositions = ($dispositions);
        $estimation->save();
    }
}
