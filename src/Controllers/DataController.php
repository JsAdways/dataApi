<?php

namespace Jsadways\DataApi\Controllers;

use Exception;
use Illuminate\Validation\Rule;
use Jsadways\DataApi\Core\Parameter\Notification\Enums\Platform;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossNotificationDto;
use Jsadways\LaravelSDK\Core\ReadListParamsDto;
use App\Core\Repository\ReadListParamsDto as ReadListParamsDtoOLD;
use Jsadways\DataApi\Traits\UseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Jsadways\DataApi\Services\Cross\CrossService;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossDataDto;
use Jsadways\DataApi\Core\Services\Cross\Dtos\CrossProcessDto;

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
                'condition.extra' => 'nullable|json',
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
            ]
        );
        $condition = json_decode($payload['condition'], true);
        $condition['filter'] = json_encode($condition['filter']);

        $repository_version = intval(config::get('data_api.repository_version'));
        if($repository_version === 0){
            $data = $this->repository($payload['repository'])->read_models(new ReadListParamsDtoOLD(...$condition));
        }else{
            $data = $this->repository($payload['repository'])->read_models(new ReadListParamsDto(...$condition));
        }

        return ['data' => $data];
    }
}
