<?php

namespace Koders\EstimationModule\DTO;

final class LonLatDto
{
    public function __construct(public readonly int | float $longitude, public readonly int | float $latitude)
    {
    }
}
