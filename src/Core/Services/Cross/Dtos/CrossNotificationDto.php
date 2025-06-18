<?php

namespace Jsadways\DataApi\Core\Services\Cross\Dtos;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Enums\Platform;
use Jsadways\DataApi\Core\Services\Cross\Contracts\PayloadContract;

final class CrossNotificationDto extends Dto implements PayloadContract
{
    public function __construct(
        public readonly string $system,
        public readonly string $token,
        public readonly Platform $platform,
        public readonly ?array $payload = null,
    ) {}
}
