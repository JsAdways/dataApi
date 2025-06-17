<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line;

use Jsadways\DataApi\Core\Common\Dto;

final class LineTextPayloadDto extends Dto
{
    public string $type = 'text';
    public function __construct(
        public readonly string $text
    ) {}
}
