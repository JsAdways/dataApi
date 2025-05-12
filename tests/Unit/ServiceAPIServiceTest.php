<?php

namespace Jsadways\DataApi\Tests\Unit\DataTest;

use Exception;
use Jsadways\DataApi\Core\Services\Data\Dtos\ServiceApiDto;
use Jsadways\DataApi\Services\Data\ServiceAPIService;
use Tests\TestCase;

class ServiceAPIServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_happy_path_fetch():void
    {
        $payload = [
            'api_url' => 'http://172.16.1.8/js_crm/api/service_api/company_verify',
            'token' => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTcyLjE2LjEuOC9qc19lbXBsb3llZS9zZXJ2aWNlL2FwaS9sb2dpbiIsImlhdCI6MTc0NzAxMzc3MywiZXhwIjoxNzQ3MDE3MzczLCJuYmYiOjE3NDcwMTM3NzMsImp0aSI6IlYxOFVPU3ZVM2JSVkxNTmIiLCJzdWIiOiIxIiwicHJ2IjoiMTZlNGNkYTM1OGRiNGY3MjQxZTI4NzcxNjBmYjE4MmU1MGNhNmRmZSJ9.bjP3SuCGyyM8ZT3VB-APdOuexR9LaDl7yxJlv3Mtvpo",
            'payload' => [
                "id_number" => "27743336",
                "name" => "傑思愛德威媒體股份有限公司"
            ]
        ];

        $service_api_service = new ServiceAPIService(new ServiceApiDto(...$payload));
        $result = $service_api_service->fetch();
        $this->assertIsArray($result);
    }

    public function test_missing_token()
    {
        $payload = [
            'api_url' => 'http://172.16.1.8/js_crm/api/service_api/company_verify',
            'token' => "Bearer ",
            'payload' => [
                "id_number" => "27743336",
                "name" => "傑思愛德威媒體股份有限公司"
            ]
        ];

        $this->assertThrows(
            function () use ($payload) {
                (new ServiceAPIService(new ServiceApiDto(...$payload)))->fetch();
            },
            Exception::class,
            "Unauthorized"
        );
    }
}
