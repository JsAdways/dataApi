<?php

namespace Jsadways\DataApi\Services\Cross\DataStream\API;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Services\Data\Contracts\DataStreamContract;
use Jsadways\DataApi\Core\Services\Data\Dtos\DataApiDto;

class DataAPIService implements DataStreamContract
{
    public function __construct(
        protected DataApiDto $_payload
    )
    {
    }
    /**
     * @throws Exception
     */
    public function fetch(): array
    {
        $condition = $this->_payload->condition ?? [
            'filter' => [],
            'per_page' => 0,
        ];

        $api_end_point = $this->_payload->system_host.Config::get('data_api.get_api_url');

        $response = Http::get($api_end_point, [
            'repository' => $this->_payload->repository,
            'condition' => json_encode($condition)
        ]);

        $response_result = $response->json();
        if ($response->failed()) {
            $message = (empty($response_result)) ? 'Undefined Error' : $response_result['message'];
            throw new Exception($message);
        }

        return $response_result['data'];
    }
}
