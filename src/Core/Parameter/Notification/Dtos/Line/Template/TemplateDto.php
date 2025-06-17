<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template\Action\ActionBaseDto;

final class TemplateDto extends Dto
{
    /**
     * @param string $type
     * @param string $thumbnailImageUrl
     * @param string $imageAspectRatio
     * @param string $imageSize
     * @param string $imageBackgroundColor
     * @param string $title
     * @param string $text
     * @param ActionBaseDto $defaultAction
     * @param ActionBaseDto[] $actions
     */
    public function __construct(
        public readonly string $type,
        public readonly string $thumbnailImageUrl,
        public readonly string $imageAspectRatio,
        public readonly string $imageSize,
        public readonly string $imageBackgroundColor,
        public readonly string $title,
        public readonly string $text,
        public readonly ActionBaseDto $defaultAction,
        public readonly array $actions,
    ) {}
}
