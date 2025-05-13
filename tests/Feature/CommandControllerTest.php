<?php

namespace Jsadways\DataApi\Tests\Feature;

use Tests\TestCase;

class CommandControllerTest extends TestCase
{
    const API = '/api/data_api';

    public function setUp(): void
    {
        parent::setUp();
    }

    public function test_happy_path_service_list():void
    {
        $payload = [];
        $response = $this->withoutMiddleware()->post(self::API . '/command/service_list', $payload);

        $response->assertStatus(200)
            ->assertJsonStructure([]);

        $resp_data = $response->json();
        $this->assertIsArray($resp_data);
    }
}
