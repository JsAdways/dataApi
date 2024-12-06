<?php

namespace Jsadways\DataApi\Services\Data;

use Jsadways\DataApi\Services\Common\Dto;

final class DataDto extends Dto
{
    public function __construct(
        public readonly string $api_url,
        public readonly string $repository,
        public readonly string $condition,
    ) {}
}
