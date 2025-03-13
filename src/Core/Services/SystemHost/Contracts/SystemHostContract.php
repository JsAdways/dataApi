<?php

namespace Jsadways\DataApi\Core\Services\SystemHost\Contracts;

interface SystemHostContract
{
    public function list(): SystemHostContract;
    public function get_api_url(string $name): string;
}
