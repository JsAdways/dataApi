<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\LineTemplateContract;

final class LineTemplatePayloadDto extends Dto
{
    public string $type = 'template';
    public function __construct(
        public readonly string             $altText,
        public readonly LineTemplateContract $template,
    ) {}
}
