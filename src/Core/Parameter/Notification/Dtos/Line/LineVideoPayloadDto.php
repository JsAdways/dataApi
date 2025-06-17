<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line;

use Jsadways\DataApi\Core\Common\Dto;

final class LineVideoPayloadDto extends Dto
{
    public string $type = 'video';
    public function __construct(
        public readonly string $originalContentUrl,
        public readonly string $previewImageUrl,
    ) {}
}
