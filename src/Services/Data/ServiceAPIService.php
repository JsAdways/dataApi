<?php

namespace Jsadways\DataApi\Services\Data;

use Exception;
use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Services\Data\Contracts\DataContract;
use Jsadways\DataApi\Core\Services\Data\Dtos\ServiceApiDto;

class ServiceAPIService implements DataContract
{
    public function __construct(
        protected ServiceApiDto $_payload
    )
    {
    }

    /**
     * @throws Exception
     */
    public function fetch(): array
    {
        // TODO: Implement fetch() method.
        $token = $this->_payload->token;
        $response = Http::withToken($token)->post($this->_payload->api_url,[...$this->_payload->payload]);

        $response_result = $response->json();
        if ($response->failed()) {
            $message = (empty($response_result)) ? 'Undefined Error' : $response_result['message'];
            throw new Exception($message);
        }

        return $response_result;
    }
}
