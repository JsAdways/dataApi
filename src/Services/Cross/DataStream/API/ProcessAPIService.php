<?php

namespace Jsadways\DataApi\Services\Cross\DataStream\API;

use Exception;
use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Services\Data\Contracts\DataStreamContract;
use Jsadways\DataApi\Core\Services\Data\Dtos\ProcessApiDto;

class ProcessAPIService implements DataStreamContract
{
    public function __construct(
        protected ProcessApiDto $_payload
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
        $response = Http::withToken($token)->post($this->_payload->system_host.'/api/process_api/'.$this->_payload->api,[...$this->_payload->payload]);

        $response_result = $response->json();
        if ($response->failed()) {
            $message = (empty($response_result)) ? 'Undefined Error' : $response_result['message'];
            throw new Exception($message);
        }

        return $response_result;
    }
}
