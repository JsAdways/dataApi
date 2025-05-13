<?php

namespace Jsadways\DataApi\Core\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD | Attribute::IS_REPEATABLE)]
class ServiceAPI
{
    public function __construct(
        protected string $name,
        protected string $type,
        protected bool $required,
        protected string $description,
    )
    {
    }
}
