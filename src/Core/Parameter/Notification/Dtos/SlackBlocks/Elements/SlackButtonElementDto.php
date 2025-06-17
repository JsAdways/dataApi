<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks\Elements;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\SlackElementContract;
use Jsadways\DataApi\Core\Parameter\Notification\Enums\Slack\ButtonStyle;

final class SlackButtonElementDto extends Dto implements SlackElementContract
{
    public string $type = 'button';
    public function __construct(
        public readonly SlackTextElementDto $text,
        public readonly string $value,
        public readonly string $action_id,
        public readonly ButtonStyle $style,
    ) {}
}
