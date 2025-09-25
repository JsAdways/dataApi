<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos;

use Jsadways\DataApi\Core\Common\Dto;

final class EmailPayloadDto extends Dto
{
    public function __construct(
        public readonly array $receiver,
        public readonly string $title,
        public readonly string $content,
        public readonly ?array $cc = [],
        public readonly ?array $bcc = [],
        public readonly ?array $attach_file = null
    ) {}
}
