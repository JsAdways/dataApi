<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Line\Template\Action;

final class ActionUriDto extends ActionBaseDto
{
    public string $type = 'uri';
    public function __construct(
        public readonly string $label,
        public readonly string $uri,
    ) {}
}
