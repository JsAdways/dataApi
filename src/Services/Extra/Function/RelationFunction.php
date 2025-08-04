<?php

namespace Jsadways\DataApi\Services\Extra\Function;
use Exception;
use Jsadways\DataApi\Core\Services\Extra\Dtos\FunctionPayloadDto;
use Jsadways\DataApi\Core\Services\Extra\Contracts\FunctionContract;
use Jsadways\DataApi\Services\Relation\RelationService;
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

        if(is_array($data)){
            return $data;
        }else{
            $relation_service = new RelationService(repository_name:$payload['repository_name']);
            return $relation_service->find('__'.$data.'_relations__');
        }
    }
}
