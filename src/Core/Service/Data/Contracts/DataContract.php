<?php

namespace Jsadways\DataApi\Core\Service\Data\Contracts;

use Jsadways\DataApi\Services\Data\DataDto;

interface DataContract
{
    public function fetch(DataDto $payload): array;
}
