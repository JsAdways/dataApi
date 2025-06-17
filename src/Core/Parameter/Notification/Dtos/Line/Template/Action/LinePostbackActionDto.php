<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template\Action;


use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\LineTemplateActionContract;

final class LinePostbackActionDto extends Dto implements LineTemplateActionContract
{
    public string $type = 'postback';
    public function __construct(
        public readonly string $label,
        public readonly string $data,
    ) {}
}
