<?php

namespace Jsadways\DataApi\Core\Services\Cross\Dtos;

use Jsadways\DataApi\Core\Common\PayloadDto;

final class CrossDataDto extends PayloadDto
{
    public function __construct(
        public readonly string $system,
        public readonly string $repository,
        public readonly ?array $condition = null,
    ) {}
}
