<?php

namespace Jsadways\DataApi\Tests\Unit\CrossTest;

use Exception;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossDataDto;
use Jsadways\DataApi\Services\Cross\CrossService;
use Tests\TestCase;

class CrossServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_happy_path_fetch():void
    {
        $payload = [
            'system' => '財務系統',
            'repository' => 'SettingReceiptDollarType',
            'condition' => [
                "filter" => [
                    "status_eq" => 1
                ],
                "per_page" => 0
            ]
        ];

        $result = (new CrossService())->fetch(new CrossDataDto(...$payload));

        $this->assertIsArray($result);
    }

    public function test_missing_system_fetch()
    {
        $payload = [
            'system' => '人員系統',
            'repository' => 'SettingReceiptDollarType',
            'condition' => [
                "filter" => [
                    "status_eq" => 1
                ],
                "per_page" => 0
            ]
        ];


        $this->assertThrows(
            function () use ($payload) {
                (new CrossService())->fetch(new CrossDataDto(...$payload));
            },
            Exception::class,
            "Data Api URL not found"
        );
    }

    public function test_missing_repository_fetch()
    {
        $payload = [
            'system' => '財務系統',
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
                $result = (new CrossService())->fetch(new CrossDataDto(...$payload));
            },
            Exception::class,
            "發生無法定義之異常，請盡快聯絡IT部。"
        );
    }
}
