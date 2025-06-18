<?php

namespace Jsadways\DataApi\Tests\Unit\DataTest;

use Exception;
use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Services\Data\Dtos\ProcessApiDto;
use Jsadways\DataApi\Services\Cross\DataStream\API\ProcessAPIService;
use Tests\TestCase;

class ProcessAPIServiceTest extends TestCase
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
    public function test_happy_path_fetch():void
    {
        $payload = [
            'system_host' => 'http://172.16.1.8/js_crm',
            'api' => 'company_verify',
            'token' => $this->token,
            'payload' => [
                "id_number" => "27743336",
                "name" => "傑思愛德威媒體股份有限公司"
            ]
        ];

        $process_api_service = new ProcessAPIService(new ProcessApiDto(...$payload));
        $result = $process_api_service->fetch();
        $this->assertIsArray($result);
    }

    public function test_missing_token()
    {
        $payload = [
            'system_host' => 'http://172.16.1.8/js_crm',
            'api' => 'company_verify',
            'token' => "Bearer ",
            'payload' => [
                "id_number" => "27743336",
                "name" => "傑思愛德威媒體股份有限公司"
            ]
        ];

        $this->assertThrows(
            function () use ($payload) {
                (new ProcessAPIService(new ProcessApiDto(...$payload)))->fetch();
            },
            Exception::class,
            "Unauthorized"
        );
    }
}
