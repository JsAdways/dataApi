<?php

namespace Jsadways\DataApi\Core\Services\Data\Contracts;

use Jsadways\DataApi\Core\Services\Data\Dtos\DataDto;

interface DataContract
{
    public function fetch(DataDto $payload): array;
}
