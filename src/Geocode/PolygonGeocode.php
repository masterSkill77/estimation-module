<?php

namespace Koders\EstimationModule\Geocode;

use stdClass;

final class PolygonGeocode
{
    const NUM_POINTS = 100;

    // Approximation: 1 degree ~ 111 km
    const APPROXIMATION = 111;


    /**
     * Transforms coordinates into GeoJSON buffer
     * @param int | float $latitude The latitude of the point
     * @param int | float $longitude The longitude of the point
     * @return string
     *
     */
    public static function generateCirclePolygon(int | float $latitude, int | float $longitude, int $radiusKm): string
    {
        $coords = [];

        $radiusDeg = $radiusKm / PolygonGeocode::APPROXIMATION;

        for ($i = 0; $i <= PolygonGeocode::NUM_POINTS; $i++) {
            $angle = 2 * M_PI * $i / PolygonGeocode::NUM_POINTS;
            $dx = $radiusDeg * cos($angle);
            $dy = $radiusDeg * sin($angle);

            $pointLat = $latitude + $dy;
            $pointLng = $longitude + $dx;

            $coords[] = [$pointLng, $pointLat];
        }

        $geojson = [
            "type" => "FeatureCollection",
            "features" => [
                [
                    "type" => "Feature",
                    "properties" => new stdClass(),
                    "geometry" => [
                        "type" => "Polygon",
                        "coordinates" => [$coords]
                    ]
                ]
            ]
        ];

        return json_encode($geojson, JSON_PRETTY_PRINT);
    }
}
