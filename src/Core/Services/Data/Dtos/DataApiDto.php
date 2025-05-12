<?php

namespace Jsadways\DataApi\Core\Services\Data\Dtos;

use Jsadways\DataApi\Core\Common\Dto;

final class DataApiDto extends Dto
{
    public function __construct(
        public readonly string $api_url,
        public readonly string $repository,
        public readonly ?array $condition = null,
    ) {}
}
