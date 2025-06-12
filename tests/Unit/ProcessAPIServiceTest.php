<?php

namespace Jsadways\DataApi\Tests\Unit\DataTest;

use Exception;
use Jsadways\DataApi\Core\Services\Data\Dtos\ProcessApiDto;
use Jsadways\DataApi\Services\Cross\DataStream\API\ProcessAPIService;
use Tests\TestCase;

class ProcessAPIServiceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_happy_path_fetch():void
    {
        $payload = [
            'system_host' => 'http://172.16.1.8/js_crm',
            'api' => 'company_verify',
            'token' => "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMTcyLjE2LjEuOC9qc19lbXBsb3llZS9zZXJ2aWNlL2FwaS9sb2dpbiIsImlhdCI6MTc0OTcxOTAxMywiZXhwIjoxNzQ5NzIyNjEzLCJuYmYiOjE3NDk3MTkwMTMsImp0aSI6IkUzcWZsbUY3M0tNSE9vWlIiLCJzdWIiOiIxIiwicHJ2IjoiMTZlNGNkYTM1OGRiNGY3MjQxZTI4NzcxNjBmYjE4MmU1MGNhNmRmZSJ9.iP6eMIzoocYkdOQwAoDngAa0t62rO3Us0FNVxYq345Q",
            'payload' => [
                "id_number" => "27743336",
                "name" => "傑思愛德威媒體股份有限公司"
            ]
        ];

        $process_api_service = new ProcessAPIService(new ProcessApiDto(...$payload));
        $result = $process_api_service->fetch();
        $this->assertIsArray($result);
    }

    public function test_missing_token()
    {
        $payload = [
            'api_url' => 'http://172.16.1.8/js_crm/api/process_api/company_verify',
            'token' => "Bearer ",
            'payload' => [
                "id_number" => "27743336",
                "name" => "傑思愛德威媒體股份有限公司"
            ]
        ];

        $this->assertThrows(
            function () use ($payload) {
                (new ProcessAPIService(new ProcessApiDto(...$payload)))->fetch();
            },
            Exception::class,
            "Unauthorized"
        );
    }
}
