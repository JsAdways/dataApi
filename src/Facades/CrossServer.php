<?php

namespace Jsadways\DataApi\Facades;

use Illuminate\Support\Facades\Facade;
use Jsadways\DataApi\Services\Cross\CrossService;

class CrossServer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return CrossService::class;
    }
}
