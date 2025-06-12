<?php

namespace Jsadways\DataApi\Tests\Feature;

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

    public function test_happy_path_process():void
    {
        $payload = [
            'system' => 'CRM',
            'api' => 'company_verify',
            'token' => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTcyLjE2LjEuOC9qc19lbXBsb3llZS9zZXJ2aWNlL2FwaS9sb2dpbiIsImlhdCI6MTc0NzAxMzc3MywiZXhwIjoxNzQ3MDE3MzczLCJuYmYiOjE3NDcwMTM3NzMsImp0aSI6IlYxOFVPU3ZVM2JSVkxNTmIiLCJzdWIiOiIxIiwicHJ2IjoiMTZlNGNkYTM1OGRiNGY3MjQxZTI4NzcxNjBmYjE4MmU1MGNhNmRmZSJ9.bjP3SuCGyyM8ZT3VB-APdOuexR9LaDl7yxJlv3Mtvpo",
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
