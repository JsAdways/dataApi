<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks\Elements;

use Jsadways\DataApi\Core\Parameter\Notification\Enums\Slack\ButtonStyle;

final class SlackButtonElementDto extends SlackElementDto
{
    public string $type = 'button';
    public function __construct(
        public readonly SlackTextElementDto $text,
        public readonly string $value,
        public readonly string $action_id,
        public readonly ButtonStyle $style,
    ) {}
}
