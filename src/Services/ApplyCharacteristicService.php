<?php

namespace Koders\EstimationModule\Services;

use App\Models\Estimation;
use Illuminate\Support\Facades\Log;

class ApplyCharacteristicService
{
    public static function run(Estimation $estimation, float $estimationValue): float
    {
        $estimationDetails = json_decode($estimation->details_bien, true);

        $estimationValue = isset($estimationDetails['exposition']) ? $estimationValue + (($estimationValue * self::characteristicsWithPercent()['exposition'][$estimationDetails['exposition']]) / 100) : $estimationValue;
        $estimationValue = isset($estimationDetails['etat_general']) ? $estimationValue + (($estimationValue * self::characteristicsWithPercent()['etat_general'][$estimationDetails['etat_general']]) / 100) : $estimationValue;
        $estimationValue = $estimationValue + (($estimationValue * self::characteristicsWithPercent()['indice_dpe'][$estimationDetails['indice_dpe']]) / 100);
        $estimationValue = $estimationValue + (($estimationValue * self::characteristicsWithPercent()['vue'][$estimationDetails['vue']]) / 100);

        if (isset($estimationDetails['equipements'])) {
            foreach ($estimationDetails['equipements'] as $key => $value) {
                if ($value == true) {
                    $estimationValue = $estimationValue + (($estimationValue * self::characteristicsWithPercent()['equipements'][$estimationDetails['equipements'][$key]]) / 100);
                }
            }
        }

        if ($estimation->bien == 'maison') {
            $estimationValue =
                $estimationDetails['etage'] <= 0 ?
                $estimationValue + (($estimationValue * self::characteristicsWithPercent()['etage']['maison']['none']) / 100) :
                $estimationValue + (($estimationValue * self::characteristicsWithPercent()['etage']['maison']['one_plus']) / 100);
        } else if ($estimation->bien == 'appartement') {
            $estimationValue =
                $estimationDetails['etage'] <= 0 ?
                $estimationValue + (($estimationValue * self::characteristicsWithPercent()['etage']['etage']['maison']['none']) / 100) :
                $estimationValue + (($estimationValue * self::characteristicsWithPercent()['etage']['etage']['maison']['one_plus']) / 100);
        }

        return $estimationValue;
    }


    protected static function characteristicsWithPercent(): array
    {
        return [
            'exposition' => [
                'nord' => -2,
                'nord_est' => 0,
                'est' => 0,
                'sud_est' => 2,
                'sud' => 2,
                'sud_ouest' => 2,
                'ouest' => 0,
                'est_ouest' => 5
            ],
            'etat_general' => [
                'important' => -30,
                'renovation' => -9,
                'standard' => 0,
                'refait' => 11
            ],
            'indice_dpe' => [
                'A' => 12,
                'B' => 12,
                'C' => 7,
                'D' => 0,
                'E' => -4,
                'F' => -10,
            ],
            'vue' => [
                'vis_a_vis' => -8,
                'degage' => 12,
                'exceptionnelle' => 35
            ],
            'equipements' => [
                'balcon' => 10,
                'terrasse' => 5,
                'jardin' => 10,
                'parking' => 3,
                'garage' => 6,
                'cave' => 2,
                'piscine' => 17
            ],
            'etage' => [
                'maison' => [
                    'none' => 10,
                    'one_plus' => 0
                ],
                'appartement_sans_ascenseur' => [
                    'none' => -8,
                    'one' => -2,
                    'two' => 0,
                    'three' => 3,
                    'four' => 3.5,
                    'five' => 0,
                    'six_plus' => 4.5
                ],
                'appartement_avec_ascenseur' => [
                    'none' => -11,
                    'one' => -3,
                    'two' => 3.5,
                    'three' => 3.5,
                    'four' => 4.5,
                    'five' => 4.5,
                    'six_plus' => 11
                ]
            ]
        ];
    }
}
