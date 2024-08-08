<?php

namespace Koders\EstimationModule\Services;

use Illuminate\Support\Facades\Log;
use Koders\EstimationModule\Models\EstimationResult;

class EstimationResultService
{

    public function run(int $estimation_id, array $data)
    {
        $data['estimation_id'] = $estimation_id;
        $estimationResult = new EstimationResult($data);
        $estimationResult->save();
    }
}
