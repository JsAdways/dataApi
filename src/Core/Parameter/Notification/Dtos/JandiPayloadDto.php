<?php

namespace Jsadways\DataApi\Core\Parameter\Notification\Dtos;

use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Parameter\Notification\Dtos\Jandi\JandiConnectInfoDto;

final class JandiPayloadDto extends Dto
{
    /**
     * @param string $body
     * @param string|null $connectColor
     * @param JandiConnectInfoDto[] $connectInfo
     */
    public function __construct(
        public readonly string $body,
        public readonly ?string $connectColor = null,
        public readonly ?array $connectInfo = null
    ) {}
}
