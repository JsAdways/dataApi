<?php

namespace Jsadways\DataApi\Core\Services\Cross\Contracts;

interface CrossContract
{
    public function fetch(PayloadContract $payload): array;
}
