<?php

namespace Jsadways\DataApi\Services\Extra;

use Jsadways\DataApi\Core\Services\Extra\Contracts\ExtraContract;
use Jsadways\DataApi\Core\Services\Extra\Contracts\FunctionContract;
use Jsadways\LaravelSDK\Core\ReadListParamsDto;

class ExtraService implements ExtraContract
{
    protected mixed $target_data = false;
    public function __construct(
        protected FunctionContract $function,
        protected ReadListParamsDto $dto,
        protected string $key,
    ){}

    public function _find_extra_data(): static
    {
        $this->target_data = $this->dto->from_extra_get($this->key, false);
        return $this;
    }

    public function execute(): array | null
    {
        return $this->_find_extra_data()->function->execute($this->target_data);
    }
}
