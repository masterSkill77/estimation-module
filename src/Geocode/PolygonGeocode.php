<?php

namespace Koders\EstimationModule\Geocode;

use Koders\EstimationModule\DTO\LonLatDto;
use Koders\EstimationModule\DTO\PolygonDto;
use stdClass;

final class PolygonGeocode
{
    const NUM_POINTS = 100;

    // Approximation: 1 degree ~ 111 km
    const APPROXIMATION = 111;


    /**
     * Transforms coordinates into GeoJSON buffer
     * @param \Koders\EstimationModule\DTO\LonLatDto $lonLatDto The coordinate of the point
     * @return \Koders\EstimationModule\DTO\PolygonDto
     *
     */
    public static function generateCirclePolygon(LonLatDto $lonLatDto, int $radiusKm): PolygonDto
    {
        $coords = [];

        $radiusDeg = $radiusKm / PolygonGeocode::APPROXIMATION;

        for ($i = 0; $i <= PolygonGeocode::NUM_POINTS; $i++) {
            $angle = 2 * M_PI * $i / PolygonGeocode::NUM_POINTS;
            $dx = $radiusDeg * cos($angle);
            $dy = $radiusDeg * sin($angle);

            $pointLat = $lonLatDto->latitude + $dy;
            $pointLng = $lonLatDto->longitude + $dx;

            $coords[] = [$pointLng, $pointLat];
        }

        return new PolygonDto($coords);
    }
}
