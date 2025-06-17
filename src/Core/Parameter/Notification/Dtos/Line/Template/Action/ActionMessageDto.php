<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template\Action;


final class ActionMessageDto extends ActionBaseDto
{
    public string $type = 'message';
    public function __construct(
        public readonly string $label,
        public readonly string $text,
    ) {}
}
