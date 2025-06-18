<?php

namespace Jsadways\DataApi\Core\Services\Data\Contracts;

interface DataStreamContract
{
    public function fetch(): array;
}
