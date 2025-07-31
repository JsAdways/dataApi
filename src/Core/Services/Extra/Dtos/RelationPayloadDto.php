<?php

namespace Jsadways\DataApi\Core\Services\Extra\Dtos;
final class RelationPayloadDto extends FunctionPayloadDto
{
    public function __construct(
        public readonly string $repository_name
    ) {}
}
