<?php

namespace Jsadways\DataApi\Services\Cross;

use Exception;
use Jsadways\DataApi\Core\Services\Data\Contracts\DataContract;
use Jsadways\DataApi\Core\Services\Data\Dtos\ServiceApiDto;
use Jsadways\DataApi\Services\Data\DataAPIService;
use Jsadways\DataApi\Services\Data\ServiceAPIService;
use Jsadways\DataApi\Services\SystemHost\SystemHostService;
use Jsadways\DataApi\Core\Services\Cross\Contracts\CrossContract;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossDataDto;
use Jsadways\DataApi\Core\Services\Data\Dtos\DataApiDto;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossServiceDto;

class CrossService implements CrossContract
{
    protected CrossDataDto| CrossServiceDto $payload;
    protected string $system_host;
    protected DataContract $dataService;

    /**
     * 取得資料
     *
     * @param CrossDataDto $payload
     * @return array
     * @throws Exception
     */
    public function fetch(CrossDataDto $payload): array
    {
        return $this->_set_payload($payload)
            ->_fetch_system_host()
            ->_prepare_data_api_Service()
            ->_send();
    }

    /**
     * 呼叫service api
     * @throws Exception
     */
    public function service(CrossServiceDto $payload): array
    {
        return $this->_set_payload($payload)
            ->_fetch_system_host()
            ->_prepare_service_api_Service()
            ->_send();
    }

    /**
     * 初始化 payload 資料
     *
     * @param CrossDataDto|CrossServiceDto $payload
     * @return static
     */
    protected function _set_payload(CrossDataDto | CrossServiceDto $payload): static
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * 取得目標系統網址
     *
     * @return static
     * @throws Exception
     */
    protected function _fetch_system_host(): static
    {
        $this->system_host = (new SystemHostService())->list()->get_api_url($this->payload->system);

        return $this;
    }

    protected function _prepare_data_api_Service(): static
    {
        $this->dataService =  new DataAPIService(new DataApiDto(
            api_url: $this->system_host,
            repository: $this->payload->repository,
            condition: $this->payload->condition
        ));

        return $this;
    }

    protected function _prepare_service_api_Service(): static
    {
        $this->dataService =  new ServiceAPIService(new ServiceApiDto(
            api_url: $this->system_host.'/api/service_api/'.$this->payload->api,
            token: $this->payload->token,
            payload: $this->payload->payload
        ));

        return $this;
    }

    /**
     * 取得目標系統資料
     *
     * @return array
     */
    protected function _send(): array
    {
        return $this->dataService->fetch();
    }
}
