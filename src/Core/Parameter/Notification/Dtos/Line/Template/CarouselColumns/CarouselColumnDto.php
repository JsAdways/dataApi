<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template\CarouselColumns;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\LineTemplateActionContract;

final class CarouselColumnDto extends Dto
{
    /**
     * @param string $thumbnailImageUrl
     * @param string $imageBackgroundColor
     * @param string $title
     * @param string $text
     * @param LineTemplateActionContract[] $actions
     */
    public function __construct(
        public readonly string $thumbnailImageUrl,
        public readonly string $imageBackgroundColor,
        public readonly string $title,
        public readonly string $text,
        public readonly array $actions,
    ) {}
}
