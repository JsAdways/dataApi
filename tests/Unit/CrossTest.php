<?php

namespace Jsadways\DataApi\Tests\Unit\CrossTest;

use Jsadways\DataApi\Services\Cross\CrossDto;
use Jsadways\DataApi\Services\Cross\CrossService;
use Tests\TestCase;

class CrossTest extends TestCase
{
    public function test_happy_path_fetch():void
    {
        $payload = [
            'system' => '財務系統',
            'repository' => 'SettingReceiptDollarType',
            'condition' => '{"filter":{"status_eq":1},"per_page":"0"}'
        ];

        $result = (new CrossService())->fetch(new CrossDto(...$payload));

        $this->assertIsArray($result);
        $this->assertJsonStringEqualsJsonString('["status_code","data"]',json_encode(array_keys($result)));
        $this->assertEquals(200,$result['status_code']);
    }

    public function test_missing_system()
    {
        $payload = [
            'system' => '人員系統',
            'repository' => 'SettingReceiptDollarType',
            'condition' => '{"filter":{"status_eq":1},"per_page":"0"}'
        ];
        $result = (new CrossService())->fetch(new CrossDto(...$payload));

        $this->assertIsArray($result);
        $this->assertJsonStringEqualsJsonString('["status_code","data"]',json_encode(array_keys($result)));
        $this->assertEquals(42000,$result['status_code']);
        $this->assertEquals('Data Api URL not found',$result['data']);
    }

    public function test_missing_repository()
    {
        $payload = [
            'system' => '財務系統',
            'repository' => 'SettingReceiptDollarType1',
            'condition' => '{"filter":{"status_eq":1},"per_page":"0"}'
        ];
        $result = (new CrossService())->fetch(new CrossDto(...$payload));

        $this->assertIsArray($result);
        $this->assertJsonStringEqualsJsonString('["status_code","data"]',json_encode(array_keys($result)));
        $this->assertEquals(42000,$result['status_code']);
        $this->assertEquals('Class not found.',$result['data']);
    }
}
