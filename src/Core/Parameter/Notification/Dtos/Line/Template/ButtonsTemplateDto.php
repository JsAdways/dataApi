<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\LineTemplateActionContract;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\LineTemplateContract;

final class ButtonsTemplateDto extends Dto implements LineTemplateContract
{
    public string $type = "buttons";

    /**
     * @param string $thumbnailImageUrl
     * @param string $imageAspectRatio
     * @param string $imageSize
     * @param string $imageBackgroundColor
     * @param string $title
     * @param string $text
     * @param LineTemplateActionContract[] $actions
     */
    public function __construct(
        public readonly string $thumbnailImageUrl,
        public readonly string $imageAspectRatio,
        public readonly string $imageSize,
        public readonly string $imageBackgroundColor,
        public readonly string $title,
        public readonly string $text,
        public readonly array $actions,
    ) {}
}
