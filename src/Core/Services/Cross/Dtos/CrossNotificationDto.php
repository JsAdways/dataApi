<?php

namespace Jsadways\DataApi\Core\Services\Cross\Dtos;

use Jsadways\DataApi\Core\Common\PayloadDto;
use Jsadways\DataApi\Core\Parameter\Notification\Enums\Platform;

final class CrossNotificationDto extends PayloadDto
{
    public function __construct(
        public readonly string $system,
        public readonly string $token,
        public readonly Platform $platform,
        public readonly ?array $payload = null,
    ) {}
}
