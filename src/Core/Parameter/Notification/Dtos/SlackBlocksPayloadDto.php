<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\SlackBlocksContract;

final class SlackBlocksPayloadDto extends Dto
{
    /**
     * @param SlackBlocksContract[] $blocks
     */
    public function __construct(
        public readonly array $blocks
    ) {}
}
