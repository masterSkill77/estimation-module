<?php

namespace Koders\EstimationModule\Geocode;

use Illuminate\Support\Facades\Http;
use Koders\EstimationModule\DTO\LonLatDto;

abstract class ReverseGeocode
{
    const MAPBOX_URL = "https://api.mapbox.com/geocoding/v5/mapbox.places/";
    public static function run(string $address): LonLatDto
    {
        $response = Http::get(ReverseGeocode::MAPBOX_URL . urlencode($address) . ".json", [
            'access_token' => config("estimation-module.mapbox_access_token")
        ])->json();

        $address = $response['features'][0];
        $coordinates = ($address["geometry"]["coordinates"]);

        return new LonLatDto($coordinates[0], $coordinates[1]);
    }
}
