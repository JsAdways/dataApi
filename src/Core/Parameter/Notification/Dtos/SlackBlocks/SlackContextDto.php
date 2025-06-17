<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\SlackBlocksContract;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\SlackContextElementContract;

final class SlackContextDto extends Dto implements SlackBlocksContract
{
    public string $type = 'context';
    /**
     * @param SlackContextElementContract[] $elements
     */
    public function __construct(
        public readonly array $elements
    ) {}
}
