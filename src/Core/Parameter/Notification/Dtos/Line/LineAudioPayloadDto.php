<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line;

use Jsadways\DataApi\Core\Common\Dto;

final class LineAudioPayloadDto extends Dto
{
    public string $type = 'audio';
    public function __construct(
        public readonly string $originalContentUrl,
        public readonly string $duration,
    ) {}
}
