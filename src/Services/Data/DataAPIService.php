<?php

namespace Jsadways\DataApi\Services\Data;

use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Services\Data\Contracts\DataContract;
use Illuminate\Support\Facades\Config;
use Jsadways\DataApi\Core\Services\Data\Dtos\DataDto;
use Exception;

class DataAPIService implements DataContract
{
    public function __construct(
        protected DataDto $_payload
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

        $api_end_point = $this->_payload->api_url.Config::get('data_api.get_api_url');

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
