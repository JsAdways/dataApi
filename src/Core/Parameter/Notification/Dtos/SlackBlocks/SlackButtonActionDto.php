<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\SlackBlocksContract;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks\Elements\SlackButtonElementDto;

final class SlackButtonActionDto extends Dto implements SlackBlocksContract
{
    public string $type = 'actions';
    /**
     * @param SlackButtonElementDto[] $elements
     */
    public function __construct(
        public readonly array $elements
    ) {}
}
