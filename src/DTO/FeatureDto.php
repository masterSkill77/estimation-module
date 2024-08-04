<?php

namespace Koders\EstimationModule\DTO;

use stdClass;

final class FeatureDto
{
    public function __construct(array $coordinates, public readonly string $type = "Feature", public readonly stdClass $properties = new stdClass, public object $geometry =  new stdClass)
    {
        $this->geometry = new GeometryDto($coordinates);
    }
}
