<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks\Elements;

use Jsadways\DataApi\Core\Parameter\Notification\Enums\Slack\TextType;

final class SlackTextElementDto extends SlackElementDto
{
    public function __construct(
        public readonly TextType $type,
        public readonly string $text,
    ) {}
}
