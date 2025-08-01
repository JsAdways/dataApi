<?php

namespace Jsadways\DataApi\Services\Extra\Function;
use Exception;
use Jsadways\DataApi\Core\Services\Extra\Dtos\FunctionPayloadDto;
use Jsadways\DataApi\Core\Services\Extra\Contracts\FunctionContract;
use Jsadways\DataApi\Traits\UseRepository;

class RelationFunction implements FunctionContract
{
    use UseRepository;

    public function __construct(
        protected FunctionPayloadDto $_payload
    )
    {
    }

    /**
     * @throws Exception
     */
    public function execute(mixed $data): array | null
    {
        $payload = $this->_payload->get();
        $repository = $this->repository($payload['repository_name']);
        if($this->_is_relation_exist($repository,'__'.$data.'_relations__')){
            return $repository->{'__'.$data.'_relations__'};
        }

        return null;
    }

    protected function _is_relation_exist(object $repository,string $relation_name): bool
    {
        return property_exists($repository,$relation_name);
    }
}
