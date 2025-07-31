<?php

namespace Jsadways\DataApi\Core\Services\Extra\Contracts;

use Jsadways\LaravelSDK\Core\ReadListParamsDto;

interface ExtraContract
{
    public function execute(): array | null;
}
