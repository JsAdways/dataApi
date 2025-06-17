<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line;

use Jsadways\DataApi\Core\Common\Dto;

final class LineImagePayloadDto extends Dto
{
    public string $type = 'image';
    public function __construct(
        public readonly string $originalContentUrl,
        public readonly string $previewImageUrl,
    ) {}
}
