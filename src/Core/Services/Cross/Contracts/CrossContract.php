<?php

namespace Jsadways\DataApi\Core\Services\Cross\Contracts;

use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossDataDto;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossServiceDto;

interface CrossContract
{
    public function fetch(CrossDataDto $payload): array;
    public function service(CrossServiceDto $payload): array;
}
