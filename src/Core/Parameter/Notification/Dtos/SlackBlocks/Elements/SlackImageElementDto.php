<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks\Elements;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\SlackContextElementContract;
use Jsadways\DataApi\Core\Parameter\Notification\Contracts\SlackElementContract;

class SlackImageElementDto  extends Dto implements SlackElementContract,SlackContextElementContract
{
    public string $type = 'image';
    public function __construct(
        public readonly string $image_url,
        public readonly string $alt_text
    ) {}
}
