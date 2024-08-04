<?php

namespace Koders\EstimationModule\DTO;

final class GeometryDto
{
    public function __construct(public array $coordinates, public readonly string $type = "Polygon")
    {
        $this->coordinates = [$this->coordinates];
    }
}
