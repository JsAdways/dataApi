<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\LineTemplateContract;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template\Action\LineMessageActionDto;

final class ConfirmTemplateDto extends Dto implements LineTemplateContract
{
    public string $type = "confirm";

    /**
     * @param string $text
     * @param LineMessageActionDto[] $actions
     */
    public function __construct(
        public readonly string $text,
        public readonly array $actions
    ) {}
}
