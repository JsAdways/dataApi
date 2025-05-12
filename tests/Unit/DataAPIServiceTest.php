<?php

namespace Jsadways\DataApi\Tests\Unit\DataTest;

use Exception;
use Jsadways\DataApi\Core\Services\Data\Dtos\DataApiDto;
use Jsadways\DataApi\Services\Data\DataAPIService;
use Tests\TestCase;

class DataAPIServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_happy_path_fetch():void
    {
        $payload = [
            'api_url' => 'http://172.16.1.8/js_finance',
            'repository' => 'SettingReceiptDollarType',
            'condition' => [
                "filter" => [
                    "status_eq" => 1
                ],
                "per_page" => 0
            ]
        ];

        $data_service = new DataAPIService(new DataApiDto(...$payload));
        $result = $data_service->fetch();
        $this->assertIsArray($result);
    }

    public function test_missing_repository()
    {
        $payload = [
            'api_url' => 'http://172.16.1.8/js_finance',
            'repository' => 'SettingReceiptDollarType1',
            'condition' => [
                "filter" => [
                    "status_eq" => 1
                ],
                "per_page" => 0
            ]
        ];

        $this->assertThrows(
            function () use ($payload) {
                (new DataAPIService(new DataApiDto(...$payload)))->fetch();
            },
            Exception::class,
            "發生無法定義之異常，請盡快聯絡IT部。"
        );
    }
}
