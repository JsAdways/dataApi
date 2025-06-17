<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos;

use Jsadways\DataApi\Core\Common\Dto;

final class SlackJsonPayloadDto extends Dto
{
    public function __construct(
        public readonly string $json,
    ) {}
}
