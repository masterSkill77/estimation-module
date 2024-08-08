<?php

namespace Koders\EstimationModule\API;

use Koders\EstimationModule\DTO\GeometryDto;
use Symfony\Component\HttpFoundation\JsonResponse;

class DispositionApi extends BaseAPI
{
    /**
     * Get all disposition on the plateform
     * @param int $offset The offset of the data to take from
     * @param int $limit The limit of the result
     * @return array | null
     */
    public static function getAll(int $offset = 0, int $limit = 50): ?array
    {
        return parent::get(BaseAPI::ALL_DISPOSITION_ENDPOINT, ['from' => $offset, 'to' => $limit])->json();
    }

    /**
     * Get one specific disposition
     * @param int $disposition_id The ID of the disposition
     * @return array | null
     */
    public static function getOne(int $disposition_id): ?array
    {
        return parent::get(BaseAPI::UNIQUE_DISPOSITION_ENDPOINT . $disposition_id, ['fields' => '_full_'], true)->json();
    }


    /**
     * Get all disposition intersecting the geoJSON passed in
     */

    public static function getIntersects(GeometryDto $geometry, int $limit = 50)
    {
        $body = [
            'geojson' => $geometry,
            "limit" => $limit,
            "fields" => "_full_"
        ];

        return parent::post(BaseAPI::INTERSECTS_ENDPOINT, $body)->json();
    }
}
