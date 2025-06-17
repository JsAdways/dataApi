<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template\TemplateDto;

final class LineTemplatePayloadDto extends Dto
{
    public string $type = 'template';
    public function __construct(
        public readonly string $altText,
        public readonly TemplateDto $template,
    ) {}
}
