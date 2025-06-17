<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\SlackBlocksContract;

final class SlackDividerDto extends Dto implements SlackBlocksContract
{
    public string $type = 'divider';
    public function __construct(
    ) {}
}
