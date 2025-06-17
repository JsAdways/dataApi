<?php

namespace Jsadways\DataApi\Core\Services\Data\Dtos;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Enums\Platform;

final class NotificationApiDto extends Dto
{
    public function __construct(
        public readonly string $system_host,
        public readonly string $token,
        public readonly Platform $platform,
        public readonly ?array $payload = null,
    ) {}
}
