<?php

namespace Koders\EstimationModule\Geocode;

use Illuminate\Support\Facades\Http;

abstract class ReverseGeocode
{
    const MAPBOX_URL = "https://api.mapbox.com/geocoding/v5/mapbox.places/";
    public static function run(string $address)
    {
        $response = Http::get(ReverseGeocode::MAPBOX_URL . urlencode($address) . ".json", [
            'access_token' => config("estimation-module.mapbox_access_token")
        ])->json();

        return $response;
    }
}
