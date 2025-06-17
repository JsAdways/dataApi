<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos\Jandi;

use Jsadways\DataApi\Core\Common\Dto;

final class ConnectInfoDto extends Dto
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly ?string $imageUrl=null
    ) {}
}
