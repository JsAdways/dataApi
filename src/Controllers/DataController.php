<?php

namespace Jsadways\DataApi\Controllers;

use Exception;
use Illuminate\Validation\Rule;
use Jsadways\DataApi\Core\Services\Extra\Dtos\RelationPayloadDto;
use Jsadways\DataApi\Core\Parameter\Notification\Enums\Platform;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossNotificationDto;
use Jsadways\DataApi\Services\Extra\ExtraService;
use Jsadways\DataApi\Services\Extra\Function\RelationFunction;
use App\Core\Repository\ReadListParamsDto as ReadListParamsDtoOLD;
use Jsadways\DataApi\Services\Relation\RelationService;
use Jsadways\DataApi\Traits\UseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Jsadways\DataApi\Services\Cross\CrossService;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossDataDto;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossProcessDto;
use Throwable;

class DataController
{
    use UseRepository;

    public function __construct(
        protected CrossService $CrossService
    ) {}

    /**
     * @throws Exception
     */
    public function fetch(Request $request): array
    {
        $payload = $request->validate(
            [
                'system' => 'required|string',
                'repository' => 'required|string',
                'condition' => 'nullable|array',
                'condition.filter' => 'nullable|array',
                'condition.sort_by' => 'nullable|string|',
                'condition.sort_order' => 'nullable|string|in:asc,desc',
                'condition.per_page' => 'nullable|integer',
                'extra' => 'nullable|json',
            ]
        );

        return $this->CrossService->fetch(new CrossDataDto(...$payload));
    }

    /**
     * @throws Exception
     */
    public function process(Request $request): array
    {
        $payload = $request->validate(
            [
                'system' => 'required|string',
                'api' => 'required|string',
                'token' => 'required|string',
                'payload' => 'nullable|array'
            ]
        );

        return $this->CrossService->fetch(new CrossProcessDto(...$payload));
    }

    /**
     * @throws Exception
     */
    public function notification(Request $request): array
    {
        $payload = $request->validate(
            [
                'system' => 'required|string',
                'token' => 'required|string',
                'platform' => ['required', Rule::enum(Platform::class)],
                'payload' => 'nullable|array'
            ]
        );

        return $this->CrossService->fetch(new CrossNotificationDto(...$payload));
    }

    /**
     * @throws Exception
     */
    public function get(Request $request): array
    {
        $payload = $request->validate(
            [
                'repository' => 'string|required',
                'condition' => 'json|required',
                'condition.filter' => 'json|nullable',
                'condition.sort_by' => 'string|nullable',
                'condition.sort_order' => 'string|in:asc,desc|nullable',
                'condition.per_page' => 'integer|nullable',
                'extra' => 'nullable|json',
            ]
        );
        $condition = json_decode($payload['condition'], true);
        $condition['extra'] = (isset($payload['extra'])) ? json_decode($payload['extra'],true) : [];
        $condition['filter'] = $condition['filter'] ?? [];
        $condition['sort_by'] = $condition['sort_by'] ?? 'id';
        $condition['sort_order'] = $condition['sort_order'] ?? 'asc';
        $condition['per_page'] = $condition['per_page'] ?? 30;

        $repository_version = intval(config::get('data_api.repository_version'));
        if($repository_version === 0){
            $data = $this->repository($payload['repository'])->read_models(new ReadListParamsDtoOLD(...$condition));
        }else{
            $repository_name = $payload['repository'];

            //handle read relations
            $relation_service = new RelationService(repository_name:$repository_name);
            $read_relations = $relation_service->find('__read_relations__');

            //handle extra data
            $relation_payload = new RelationPayloadDto(repository_name:$repository_name);
            $extra_service = new ExtraService(
                function: new RelationFunction($relation_payload),
                data: $condition,
                key: 'relation'
            );
            $assigned_relation = $extra_service->execute();

            $relations = $assigned_relation !== Null ? $assigned_relation : $read_relations;
            try{
                $model = new ("App\\Models\\".$repository_name);
                $query = $model
                    ->query()
                    ->select(['*'])
                    ->with($relations)
                    ->filter($condition['filter'])
                    ->orderBy($condition['sort_by'], $condition['sort_order']);
                $data =  ($condition['per_page'] > 0) ? $query->paginate($condition['per_page'], ['*'], 'page') : $query->get();
            } catch (Throwable $throwable) {
                throw new Exception("{$repository_name}查詢錯誤: {$throwable->getMessage()}");
            }
        }

        return ['data' => $data];
    }
}
