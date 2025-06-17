<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\SlackBlocksContract;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\SlackElementContract;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks\Elements\SlackTextElementDto;

final class SlackSectionDto extends Dto implements SlackBlocksContract
{
    public string $type = 'section';
    public function __construct(
        public readonly SlackTextElementDto $text,
        public readonly SlackElementContract $accessory
    ) {}
}
