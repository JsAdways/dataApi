<?php

namespace Jsadways\DataApi\Services\Extra;

use Jsadways\DataApi\Core\Services\Extra\Contracts\ExtraContract;
use Jsadways\DataApi\Core\Services\Extra\Contracts\FunctionContract;

class ExtraService implements ExtraContract
{
    protected mixed $target_data = false;
    public function __construct(
        protected FunctionContract $function,
        protected array $data,
        protected string $key,
    ){}

    public function _find_extra_data(): static
    {
        if (array_key_exists($this->key, $this->data['extra']))
        {
            $this->target_data = $this->data['extra'][$this->key];
        }
        else{
            $this->target_data = false;
        }

        return $this;
    }

    public function execute(): array | null
    {
        return $this->_find_extra_data()->function->execute($this->target_data);
    }
}
