<?php

namespace Jsadways\DataApi\Tests\Feature\DataControllerTest;

use Tests\TestCase;

class DataControllerTest extends TestCase
{
    const API = '/api/data_api';

    public function setUp(): void
    {
        parent::setUp();
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

    public function test_missing_system():void
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

    public function test_missing_repository():void
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
