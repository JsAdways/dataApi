<?php

namespace Jsadways\DataApi\Services\Data;

use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Services\Data\Contracts\DataContract;
use Illuminate\Support\Facades\Config;
use Jsadways\DataApi\Core\Services\Data\Dtos\DataDto;
use Exception;

class DataService implements DataContract
{
    /**
     * @throws ServiceException
     */
    public function fetch(DataDto $payload): array
    {
        $condition = $payload->condition ?? json_encode([
            'filter' => [],
            'per_page' => 0,
        ]);

        $api_end_point = $payload->api_url.Config::get('data_api.get_api_url');

        $response = Http::get($api_end_point, [
            'repository' => $payload->repository,
            'condition' => $condition 
        ]);

        $response_result = $response->json();
        if ($response->failed()) {
            $message = (empty($response_result)) ? 'Undefined Error' : $response_result['data'];
            throw new Exception($message);
        }

        return $response_result['data'];
    }
}
