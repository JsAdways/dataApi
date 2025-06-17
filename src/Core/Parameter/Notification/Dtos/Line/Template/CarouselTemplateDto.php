<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\LineTemplateContract;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template\CarouselColumns\CarouselColumnDto;

final class CarouselTemplateDto extends Dto implements LineTemplateContract
{
    public string $type = "carousel";

    /**
     * @param CarouselColumnDto[] $columns
     */
    public function __construct(
        public readonly array $columns
    ) {}
}
