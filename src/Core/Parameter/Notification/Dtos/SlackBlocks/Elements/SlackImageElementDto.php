<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\SlackBlocks\Elements;

class SlackImageElementDto extends SlackElementDto
{
    public string $type = 'image';
    public function __construct(
        public readonly string $image_url,
        public readonly string $alt_text
    ) {}
}
