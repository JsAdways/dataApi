<?php

namespace Jsadways\DataApi\Services\Data;

use App\Exceptions\ServiceException;
use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Service\Data\Contracts\DataContract;

class DataService implements DataContract
{

    /**
     * @throws ServiceException
     */
    public function fetch(DataDto $payload): array
    {
        // TODO: Implement fetch() method.
        $payload = $payload->get();
        $api_url = $payload['api_url'];
        unset($payload['system']);
        $result = Http::get($api_url, $payload)->json();
        if (empty($result) || (isset($result['status_code']) && $result['status_code'] !== 200)) {
            $message = (empty($result)) ? 'Undefined Error' : $result['data'];
            throw new ServiceException($message);
        }

        return $result;
    }
}
