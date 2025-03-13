<?php

namespace Jsadways\DataApi\Core\Services\Cross\Contracts;

use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossDto;

interface CrossContract
{
    public function fetch(CrossDto $payload): array;
}
