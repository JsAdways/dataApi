<?php

namespace Jsadways\DataApi\Tests\Unit\DataTest;

use App\Exceptions\ServiceException;
use Jsadways\DataApi\Services\Data\DataDto;
use Jsadways\DataApi\Services\Data\DataService;
use Tests\TestCase;

class DataTest extends TestCase
{
    public function test_happy_path_fetch():void
    {
        $payload = [
            'api_url' => 'http://172.16.1.8/js_finance/api/data_api/get',
            'repository' => 'SettingReceiptDollarType',
            'condition' => '{"filter":{"status_eq":1},"per_page":"0"}'
        ];

        $data_service = new DataService();
        $result = $data_service->fetch(new DataDto(...$payload));
        $this->assertIsArray($result);
        $this->assertJsonStringEqualsJsonString('["status_code","data"]',json_encode(array_keys($result)));
        $this->assertEquals(200,$result['status_code']);
    }

    public function test_missing_repository()
    {
        try {
            $payload = [
                'api_url' => 'http://172.16.1.8/js_finance/api/data_api/get',
                'repository' => 'SettingReceiptDollarType1',
                'condition' => '{"filter":{"status_eq":1},"per_page":"0"}'
            ];

            $data_service = new DataService();
            $data_service->fetch(new DataDto(...$payload));

        }catch (ServiceException $e){
            $this->assertEquals('Class not found.',$e->getMessage());
        }
    }

    public function test_missing_api_url()
    {
        $payload = [
            'api_url' => 'http://172.16.1.8/js_finance/api/data_api/gets',
            'repository' => 'SettingReceiptDollarType',
            'condition' => '{"filter":{"status_eq":1},"per_page":"0"}'
        ];

        $data_service = new DataService();
        $result = $data_service->fetch(new DataDto(...$payload));

        $this->assertArrayHasKey('message',$result);
        $this->assertEquals('發生無法定義之異常，請盡快聯絡IT部。',$result['message']);
    }
}
