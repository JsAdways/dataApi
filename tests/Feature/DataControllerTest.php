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
            'condition' => '{"filter":{"status_eq":1},"per_page":"0"}'
        ];
        $response = $this->withoutMiddleware()->post(self::API.'/fetch', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure(['status_code', 'data']);

        $resp_data = $response->json();
        $this->assertEquals(200,$resp_data['status_code']);
    }

    public function test_missing_system():void
    {
        $payload = [
            'system' => '貝才務系統',
            'repository' => 'SettingReceiptDollarType',
            'condition' => '{"filter":{"status_eq":1},"per_page":"0"}'
        ];
        $response = $this->withoutMiddleware()->post(self::API.'/fetch', $payload);
        $response->assertStatus(200)
            ->assertJsonStructure(['status_code', 'data']);

        $resp_data = $response->json();
        $this->assertEquals(42000,$resp_data['status_code']);
        $this->assertEquals('Data Api URL not found',$resp_data['data']);
    }

    public function test_missing_repository():void
    {
        $payload = [
            'system' => '財務系統',
            'repository' => 'SettingReceiptDollarType1',
            'condition' => '{"filter":{"status_eq":1},"per_page":"0"}'
        ];
        $response = $this->withoutMiddleware()->post(self::API.'/fetch', $payload);
        $response->assertStatus(200)
            ->assertJsonStructure(['status_code', 'data']);

        $resp_data = $response->json();
        $this->assertEquals(42000,$resp_data['status_code']);
        $this->assertEquals('Class not found.',$resp_data['data']);
    }


}
