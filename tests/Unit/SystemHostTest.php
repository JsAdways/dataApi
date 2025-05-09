<?php

namespace Jsadways\DataApi\Tests\Unit\SystemHostTest;

use Exception;
use Jsadways\DataApi\Services\SystemHost\SystemHostService;
use Tests\TestCase;

class SystemHostTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_happy_path():void
    {
        $service = new SystemHostService();
        $system_host = $service->list()->get_api_url('財務系統');
        $this->assertStringStartsWith('http',$system_host);
    }

    public function test_missing_name():void
    {
        $this->assertThrows(
            function () {
                (new SystemHostService())->list()->get_api_url('貝才務系統');
            },
            Exception::class,
            "Data Api URL not found"
        );
    }
}
