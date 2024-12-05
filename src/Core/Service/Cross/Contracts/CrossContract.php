<?php

namespace Jsadways\DataApi\Core\Service\Cross\Contracts;

use Illuminate\Http\Request;
use Jsadways\DataApi\Services\Cross\CrossDto;

interface CrossContract
{
    public function fetch(Request|CrossDto $payload): array;
}
