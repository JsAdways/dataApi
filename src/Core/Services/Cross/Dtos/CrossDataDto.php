<?php

namespace Jsadways\DataApi\Core\Services\Cross\Dtos;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Services\Cross\Contracts\PayloadContract;

final class CrossDataDto extends Dto implements PayloadContract
{
    public function __construct(
        public readonly string $system,
        public readonly string $repository,
        public readonly ?array $condition = null,
    ) {}
}
