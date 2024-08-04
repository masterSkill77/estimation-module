<?php

namespace Koders\EstimationModule\DTO;

use stdClass;

final class PolygonDto
{

    /**
     * Funciton construct
     * @param array $coordinates
     * @param string $type
     * @param array $features
     */

    public function __construct(array $coordinates, public array $features = [], public readonly string $type = "FeatureCollection")
    {
        $this->features = [
            new FeatureDto($coordinates)
        ];
    }
}
