<?php

namespace Jsadways\DataApi\Services\Cross;

use Jsadways\DataApi\Services\Common\Dto;

final class CrossDto extends Dto
{
    public function __construct(
        public readonly string $system,
        public readonly string $repository,
        public readonly string $condition,
    ) {}
}
