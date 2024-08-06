<?php

namespace Koders\EstimationModule\API;

use Exception;
use Illuminate\Support\Facades\Http;

abstract class BaseAPI
{
    /**
     * @var array
     */
    const ALLOWED_ENDPOINT = [
        '/dispositions/all',
        '/geocode/',
        '/dispositions/intersects',
        '/dispositions/'
    ];

    /**
     * @var string baseUrl
     */

    const BASE_URL = "https://api.sogefi-sig.com/";

    /**
     * @var string
     */
    const ALL_DISPOSITION_ENDPOINT = '/dispositions/all';

    /**
     * @var string
     */
    const UNIQUE_DISPOSITION_ENDPOINT = '/dispositions/';


    /**
     * @var string
     */
    const INTERSECTS_ENDPOINT = '/dispositions/intersects';

    /**
     * For all get methods in the API Request
     */

    public static function get(string $endpoint, array $query = [], ?bool $withParams = false)
    {
        $endpointToValidate = $withParams ? "/" . explode("/", $endpoint)[1] . "/" : $endpoint;
        if (BaseAPI::validateRoute($endpointToValidate)) {
            $endpoint = BaseAPI::generateUrl($endpoint);
            try {
                return Http::get($endpoint, $query);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode());
            }
        }
        throw new Exception("The endpoint {$endpoint} is not allowed");
    }


    /**
     * For all get methods in the API Request
     */
    public static function post(string $endpoint, array $body = [], array $query = [], ?bool $withParams = false)
    {
        $endpointToValidate = $withParams ? "/" . explode("/", $endpoint)[1] . "/" : $endpoint;
        if (BaseAPI::validateRoute($endpointToValidate)) {
            $endpoint = BaseAPI::generateUrl($endpoint);
            try {
                return Http::withHeaders($query)->post($endpoint, $body);
            } catch (Exception $e) {
                throw new Exception($e->getMessage(), $e->getCode());
            }
        }
        throw new Exception("The endpoint {$endpoint} is not allowed");
    }


    /**
     * Validate the routes to be in the allowed endpoint
     * @param string $endpoint
     * @return bool true if allowed,  false otherwise
     */

    private static function validateRoute(string $endpoint): bool
    {
        return in_array($endpoint, BaseAPI::ALLOWED_ENDPOINT);
    }

    /**
     * Concatenate the baseURL and the endpoint
     * @param string $endpoint
     * @return string
     */
    private static function generateUrl(string $endpoint): string
    {
        return BaseAPI::BASE_URL . config('estimation-module.api_key') . "/dvf/v2" . $endpoint;
    }
}
