<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template\Action;


final class ActionPostbackDto extends ActionBaseDto
{
    public string $type = 'postback';
    public function __construct(
        public readonly string $label,
        public readonly string $data,
    ) {}
}
