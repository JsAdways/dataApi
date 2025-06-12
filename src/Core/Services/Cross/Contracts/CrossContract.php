<?php

namespace Jsadways\DataApi\Core\Services\Cross\Contracts;

use Jsadways\DataApi\Core\Common\PayloadDto;

interface CrossContract
{
    public function fetch(PayloadDto $payload): array;
}
