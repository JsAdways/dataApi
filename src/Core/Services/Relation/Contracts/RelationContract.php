<?php

namespace Jsadways\DataApi\Core\Services\Relation\Contracts;

interface RelationContract
{
    public function find(string $relation_name): array | null;
}
