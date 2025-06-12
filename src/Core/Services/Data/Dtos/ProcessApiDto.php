<?php

namespace Jsadways\DataApi\Core\Services\Data\Dtos;

use Jsadways\DataApi\Core\Common\Dto;

final class ProcessApiDto extends Dto
{
    public function __construct(
        public readonly string $system_host,
        public readonly string $api,
        public readonly string $token,
        public readonly ?array $payload = null,
    ) {}
}
