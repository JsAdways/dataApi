<?php

namespace Jsadways\DataApi\Services\Cross;

use App\Exceptions\ServiceException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Service\Cross\Contracts\CrossContract;
use Jsadways\DataApi\Services\SystemHost\SystemHostService;

class CrossService implements CrossContract
{
    /**
     * @throws ServiceException
     * @throws Exception
     */
    public function fetch(Request|CrossDto $payload): array
    {
        // TODO: Implement fetch() method.

        //準備以及驗證資料
        $request = $this->_prepare($payload);
        $payload = $this->_validate($request);

        //取得全系統URL，比對系統API URL
        $system_host = new SystemHostService();
        $api_url = $system_host->list()->get_api_url($payload['system']);

        //取得資料
        unset($payload['system']);
        $result = Http::get($api_url,$payload)->json();
        if(empty($result) || $result['status_code'] !== 200){
            $message = (empty($result)) ? 'Undefined Error' : $result['data'];
            throw new ServiceException($message);
        }

        return $result;
    }

    protected function _prepare(Request|CrossDto $payload):Request
    {
        if($payload instanceof CrossDto){
            $request = new Request();
            $request->replace($payload->get());

            return $request;
        }
        return $payload;
    }

    protected function _validate(Request $request): array
    {
        return $request->validate(
            [
                'system' => 'string|required',
                'repository' => 'string|required',
                'condition' => 'json|required',
            ]
        );
    }
}
