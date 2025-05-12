<?php

namespace Jsadways\DataApi\Core\Services\Cross\Dtos;

use Jsadways\DataApi\Core\Common\Dto;

final class CrossServiceDto extends Dto
{
    public function __construct(
        public readonly string $system,
        public readonly string $api,
        public readonly string $token,
        public readonly ?array $payload = null,
    ) {}
}
