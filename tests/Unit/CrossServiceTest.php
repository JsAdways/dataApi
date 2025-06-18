<?php

namespace Jsadways\DataApi\Tests\Unit\CrossTest;

use Exception;
use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\Jandi\JandiConnectInfoDto;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\JandiPayloadDto;
use Jsadways\DataApi\Core\Parameter\Notification\Enums\Platform;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossDataDto;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossNotificationDto;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossProcessDto;
use Jsadways\DataApi\Services\Cross\CrossService;
use Tests\TestCase;

class CrossServiceTest extends TestCase
{
    const AUTH_PATH = "http://172.16.1.8/js_crm/api/js_auth/login";
    const LOGIN_PAYLOAD = [
        "account" => "js_superuser",
        "password" => "au4a83serveme"
    ];
    protected string $token;

    public function setUp(): void
    {
        parent::setUp();
        $this->_login();
    }

    private function _login():void
    {
        $login_result = Http::asForm()->post(self::AUTH_PATH, self::LOGIN_PAYLOAD);
        if($login_result->successful()){
            $this->token = $login_result->json()["token"];
        }
    }

    /**
     * @throws Exception
     */
    public function test_happy_path_fetch_data():void
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

    /**
     * @throws Exception
     */
    public function test_happy_path_fetch_process():void
    {
        $payload = [
            'system' => 'CRM',
            'api' => 'company_verify',
            'token' => $this->token,
            'payload' => [
                'id_number' => '27743336',
                'name' => '傑思愛德威媒體股份有限公司'
            ]
        ];

        $result = (new CrossService())->fetch(new CrossProcessDto(...$payload));

        $this->assertIsArray($result);
    }

    public function test_happy_path_fetch_notification():void
    {
        $payload = [
            'system' => 'n8n',
            'token' => $this->token,
            'platform' => Platform::Jandi,
            'payload' => (new JandiPayloadDto(
                body: "test message from CrossServiceTest",
                connectColor: "#FFF5567",
                connectInfo: [
                    new JandiConnectInfoDto(
                        title: "test title message from CrossServiceTest",
                        description: "test description message from CrossServiceTest",
                    )
                ]
            ))->get()
        ];

        $result = (new CrossService())->fetch(new CrossNotificationDto(...$payload));

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
