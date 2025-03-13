<?php

namespace Jsadways\DataApi\Services\Cross;

use Jsadways\DataApi\Services\Data\DataService;
use Jsadways\DataApi\Services\SystemHost\SystemHostService;
use Jsadways\DataApi\Core\Services\Cross\Contracts\CrossContract;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossDto;
use Jsadways\DataApi\Core\Services\Data\Dtos\DataDto;

class CrossService implements CrossContract
{
    protected CrossDto $payload;
    protected string $system_host;

    /**
     * 取得資料
     *
     * @param CrossDto $payload
     * @return array
     */
    public function fetch(CrossDto $payload): array
    {
        return $this->set_payload($payload)
        ->fetch_system_host()
        ->fetch_system_data();
    }

    /**
     * 初始化 payload 資料
     *
     * @param CrossDto $payload
     * @return static
     */
    protected function set_payload(CrossDto $payload): static
    { 
        $this->payload = $payload;

        return $this;
    }

    /**
     * 取得目標系統網址
     *
     * @return static
     */
    protected function fetch_system_host(): static
    {
        $this->system_host = (new SystemHostService())->list()->get_api_url($this->payload->system);

        return $this;
    }

    /**
     * 取得目標系統資料
     *
     * @return array
     */
    protected function fetch_system_data(): array
    {
        return (new DataService())->fetch(new DataDto(
            api_url: $this->system_host,
            repository: $this->payload->repository,
            condition: $this->payload->condition
        ));
    }
}
