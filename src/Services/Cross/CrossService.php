<?php

namespace Jsadways\DataApi\Services\Cross;

use App\Exceptions\ServiceException;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Service\Cross\Contracts\CrossContract;
use Jsadways\DataApi\Services\Data\DataDto;
use Jsadways\DataApi\Services\Data\DataService;
use Jsadways\DataApi\Services\SystemHost\SystemHostService;
use Throwable;

class CrossService implements CrossContract
{
    /**
     * @throws ServiceException
     * @throws Exception
     */
    public function fetch(Request|CrossDto $payload): array
    {
        // TODO: Implement fetch() method.
        try {
            //準備以及驗證資料
            $payload = $this->_prepare($payload);

            //取得全系統URL，比對系統API URL
            $system_host = new SystemHostService();
            $api_url = $system_host->list()->get_api_url($payload['system']);

            //取得資料
            unset($payload['system']);
            $payload['api_url'] = $api_url;

            $data_service = new DataService();
            return $data_service->fetch(new DataDto(...$payload));
        }
        catch (Throwable $throwable){
            $status_code = (isset($throwable->error_code)) ? $throwable->error_code : 503;
            $content = $throwable->getMessage();
            return ['status_code' => $status_code, 'data' => $content];
        }
    }

    protected function _prepare(Request|CrossDto $payload):array
    {
        //傳入值為Request形態才需要做資料驗證
        if($payload instanceof Request){
            $payload = $this->_validate($payload);
        }else{
            $payload = $payload->get();
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
