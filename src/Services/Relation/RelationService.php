<?php

namespace Jsadways\DataApi\Services\Relation;
use Exception;
use Jsadways\DataApi\Core\Services\Relation\Contracts\RelationContract;
use Jsadways\DataApi\Traits\UseRepository;
use Throwable;

class RelationService implements RelationContract
{
    use UseRepository;

    public function __construct(
        protected string $repository_name,
    ){}

    /**
     * @throws Exception
     */
    public function find(string $relation_name): array | null
    {
        try{
            $target_repository = $this->repository($this->repository_name);
            if(property_exists($target_repository,$relation_name)){
                return $target_repository->$relation_name;
            }
        }catch (Throwable $throwable){

        }

        return null;
    }
}
