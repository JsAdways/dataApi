<?php

namespace Jsadways\DataApi\Core\Services\Extra\Contracts;

interface FunctionContract
{
    public function execute(mixed $data): array | null;
}
