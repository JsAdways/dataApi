<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks\Elements;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\SlackContextElementContract;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\SlackElementContract;
use Jsadways\DataApi\Core\Parameter\Notification\Enums\Slack\TextType;

final class SlackTextElementDto  extends Dto implements SlackElementContract,SlackContextElementContract
{
    public function __construct(
        public readonly TextType $type,
        public readonly string $text,
    ) {}
}
