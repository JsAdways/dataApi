<?php

namespace Jsadways\DataApi\Tests\Feature;

use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks\Elements\SlackTextElementDto;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks\SlackImageDto;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks\SlackSectionDto;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocksPayloadDto;
use Jsadways\DataApi\Core\Parameter\Notification\Enums\Platform;
use Jsadways\DataApi\Core\Parameter\Notification\Enums\Slack\TextType;
use Tests\TestCase;

class DataControllerTest extends TestCase
{
    const API = '/api/data_api';
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
        $response = $this->withoutMiddleware()->post(self::API.'/fetch', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([]);

        $resp_data = $response->json();
        $this->assertIsArray($resp_data);
    }

    public function test_happy_path_process():void
    {
        $payload = [
            'system' => 'CRM',
            'api' => 'company_verify',
            'token' => $this->token,
            'payload' => [
                "id_number" => "27743336",
                "name" => "傑思愛德威媒體股份有限公司"
            ]
        ];
        $response = $this->withoutMiddleware()->post(self::API.'/process', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([]);

        $resp_data = $response->json();
        $this->assertIsArray($resp_data);
    }

    public function test_happy_path_notification():void
    {
        $payload = [
            'system' => 'n8n',
            'token' => $this->token,
            'platform' => Platform::Slack,
            'payload' => (new SlackBlocksPayloadDto(
                blocks: [
                    new SlackImageDto(
                        image_url: "https://plus.unsplash.com/premium_photo-1669324357471-e33e71e3f3d8?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                        alt_text: "form test message"
                    )
                ]
            ))->get()
        ];
        $response = $this->withoutMiddleware()->post(self::API.'/notification', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([]);

        $resp_data = $response->json();
        $this->assertIsArray($resp_data);
    }

    public function test_missing_system_fetch():void
    {
        $payload = [
            'system' => '貝才務系統',
            'repository' => 'SettingReceiptDollarType',
            'condition' => [
                "filter" => [
                    "status_eq" => 1
                ],
                "per_page" => 0
            ]
        ];
        $response = $this->withoutMiddleware()->post(self::API.'/fetch', $payload);
        $response->assertStatus(400)
            ->assertJsonStructure(['message']);

        $resp_data = $response->json();
        $this->assertEquals('發生無法定義之異常，請盡快聯絡IT部。',$resp_data['message']);
    }

    public function test_missing_repository_fetch():void
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
        $response = $this->withoutMiddleware()->post(self::API.'/fetch', $payload);
        $response->assertStatus(400)
            ->assertJsonStructure(['message']);

        $resp_data = $response->json();
        $this->assertEquals('發生無法定義之異常，請盡快聯絡IT部。',$resp_data['message']);
    }
}
