<?php

namespace Koders\EstimationModule\Services;

use Koders\EstimationModule\Models\EstimationResult;

class EstimationResultService
{

    const TERRAIN = [1, 2, 3, 4, 5, 6, 7, 8];
    public function run(int $estimation_id, array $data)
    {
        $data['estimation_id'] = $estimation_id;
        $data['disposition_id'] = $data['id'];
        unset($data['id']);
        $result = new EstimationResult($data);
        $result->save();
    }
}
