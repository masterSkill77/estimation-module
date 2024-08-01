<?php

/**
 * You can configure the module here
 *
 */


return [
    'api_key' => env('SOGEFI_API_KEY', 'you api key'),
    'disposition_max_result' => 50,
    'mapbox_access_token' => env("MAPBOX_ACCESS_TOKEN")
];
