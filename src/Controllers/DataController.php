<?php

namespace Jsadways\DataApi\Controllers;

use App\Core\Repository\ReadListParamsDto;
use App\Exceptions\ServiceException;
use Jsadways\DataApi\Traits\UseRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Throwable;
use Jsadways\DataApi\Services\SystemHost\SystemHostService;
use App\Repositories\RepositoryManager;

class DataController
{
    use UseRepository;
    public function fetch(Request $request): array
    {
        try {
            //驗證
            $payload = $request->validate(
                [
                    'system' => 'string|required',
                    'repository' => 'string|required',
                    'condition' => 'json|required',
                ]
            );
            //取得全系統URL，比對系統API URL
            $system_host = new SystemHostService();
            $api_url = $system_host->list()->get_api_url($payload['system']);

            //取得資料
            unset($payload['system']);
            $result = Http::get($api_url,$payload)->json();
            if(empty($result) || $result['status_code'] !== 200){
                $message = (empty($result)) ? 'Undefined Error' : $result['data'];
                throw new ServiceException($message);
            }
            return ['status_code' => $result['status_code'], 'data' => $result['data']];

        }catch (Throwable $throwable){
            $status_code = (isset($throwable->error_code)) ? $throwable->error_code : 503;
            $content = $throwable->getMessage();
            return ['status_code' => $status_code, 'data' => $content];
        }
    }

    public function get(Request $request): array
    {
        try {
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
            $condition = json_decode($payload['condition'],true);
            $condition['filter'] = json_encode($condition['filter']);

            $repository_version = intval(config::get('data_api.repository_version'));
            if($repository_version === 0){
                $repository_manager = new RepositoryManager();
                $data = $repository_manager->get($payload['repository'])->read_list(json_decode($payload['condition'],true))->toArray()['data'];
            }else{
                $data = $this->repository($payload['repository'])->read_models(new ReadListParamsDto(...$condition));
            }

            return ['status_code' => 200, 'data' => $data];

        }catch (Throwable $throwable){
            $status_code = (isset($throwable->error_code)) ? $throwable->error_code : 503;
            $content = $throwable->getMessage();
            return ['status_code' => $status_code, 'data' => $content];
        }
    }
}
