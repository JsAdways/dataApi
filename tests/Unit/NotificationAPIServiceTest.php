<?php

namespace Jsadways\DataApi\Tests\Unit\DataTest;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\Jandi\JandiConnectInfoDto;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\JandiPayloadDto;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\LineImagePayloadDto;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks\SlackImageDto;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocksPayloadDto;
use Jsadways\DataApi\Core\Parameter\Notification\Enums\Platform;
use Jsadways\DataApi\Core\Services\Data\Dtos\NotificationApiDto;
use Jsadways\DataApi\Core\Services\Data\Dtos\ProcessApiDto;
use Jsadways\DataApi\Services\Cross\DataStream\API\NotificationAPIService;
use Jsadways\DataApi\Services\Cross\DataStream\API\ProcessAPIService;
use Tests\TestCase;

class NotificationAPIServiceTest extends TestCase
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
    public function test_happy_path_jandi_message():void
    {
        $payload = [
            'system_host' => Config::get('data_api.fix_host.n8n'),
            'token' => $this->token,
            'platform' => Platform::Jandi,
            'payload' => (new JandiPayloadDto(
                body: "test message from NotificationApiTest",
                connectColor: "#FFF5567",
                connectInfo: [
                    new JandiConnectInfoDto(
                        title: "test title message from NotificationApiTest",
                        description: "test description message from NotificationApiTest",
                    )
                ]
            ))->get()
        ];

        $process_api_service = new NotificationAPIService(new NotificationApiDto(...$payload));
        $result = $process_api_service->fetch();
        $this->assertIsArray($result);
    }

    public function test_happy_path_slack_message():void
    {
        $payload = [
            'system_host' => Config::get('data_api.fix_host.n8n'),
            'token' => $this->token,
            'platform' => Platform::Slack,
            'payload' => (new SlackBlocksPayloadDto(
                blocks: [
                    new SlackImageDto(
                        image_url: "https://plus.unsplash.com/premium_photo-1669324357471-e33e71e3f3d8?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                        alt_text: "form NotificationApiTest message"
                    )
                ]
            ))->get()
        ];

        $process_api_service = new NotificationAPIService(new NotificationApiDto(...$payload));
        $result = $process_api_service->fetch();
        $this->assertIsArray($result);
    }

    public function test_happy_path_line_message():void
    {
        $payload = [
            'system_host' => Config::get('data_api.fix_host.n8n'),
            'token' => $this->token,
            'platform' => Platform::Line,
            'payload' => (new LineImagePayloadDto(
                originalContentUrl: "https://images.unsplash.com/photo-1605496036006-fa36378ca4ab?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                previewImageUrl: "https://images.unsplash.com/photo-1605496036006-fa36378ca4ab?fm=jpg&q=60&w=3000&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            ))->get()
        ];

        $process_api_service = new NotificationAPIService(new NotificationApiDto(...$payload));
        $result = $process_api_service->fetch();
        $this->assertIsArray($result);
    }
}
