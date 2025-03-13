<?php

namespace Jsadways\DataApi\Core\Services\Cross\Dtos;

use Jsadways\DataApi\Core\Common\Dto;

final class CrossDto extends Dto
{
    public function __construct(
        public readonly string $system,
        public readonly string $repository,
        public readonly ?array $condition = null,
    ) {}
}
