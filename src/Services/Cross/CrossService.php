<?php

namespace Jsadways\DataApi\Services\Cross;

use Exception;
use Jsadways\DataApi\Core\Services\Cross\Contracts\CrossContract;
use Jsadways\DataApi\Core\Services\Cross\Contracts\PayloadContract;
use Jsadways\DataApi\Core\Services\Data\Contracts\DataStreamContract;
use Jsadways\DataApi\Services\Cross\DataStream\DataStreamManager;
use Jsadways\DataApi\Services\SystemHost\SystemHostService;
use ReflectionException;

class CrossService implements CrossContract
{
    protected PayloadContract $payload;
    protected string $system_host;
    protected DataStreamContract $dataStreamService;
    protected DataStreamManager $dataStreamManager;

    public function __construct(){
        $this->dataStreamManager = new DataStreamManager();
    }

    /**
     * 取得資料
     *
     * @param PayloadContract $payload
     * @return array
     * @throws Exception
     */
    public function fetch(PayloadContract $payload): array
    {
        return $this->_set_payload($payload)
            ->_fetch_system_host()
            ->_prepare_data_stream()
            ->_send();
    }

    /**
     * 初始化 payload 資料
     *
     * @param PayloadContract $payload
     * @return static
     */
    protected function _set_payload(PayloadContract $payload): static
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

    /**
     * @throws ReflectionException
     */
    protected function _prepare_data_stream(): static
    {
        $this->dataStreamService = $this->dataStreamManager->get($this->system_host,$this->payload);

        return $this;
    }

    /**
     * 取得目標系統資料
     *
     * @return array
     */
    protected function _send(): array
    {
        return $this->dataStreamService->fetch();
    }
}
