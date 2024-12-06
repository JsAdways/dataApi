<?php

namespace Jsadways\DataApi\Tests\Unit\SystemHostTest;

use App\Exceptions\ServiceException;
use Jsadways\DataApi\Services\SystemHost\SystemHostService;
use Tests\TestCase;

class SystemHostTest extends TestCase
{
    public function test_happy_path():void
    {
        $service = new SystemHostService();
        $system_host = $service->list()->get_api_url('財務系統');
        $this->assertStringStartsWith('http',$system_host);
    }

    public function test_missing_name():void
    {
        try{
            $service = new SystemHostService();
            $service->list()->get_api_url('貝才務系統');
        }catch (ServiceException $e){
            $this->assertEquals('Data Api URL not found',$e->getMessage());
        }
    }
}
