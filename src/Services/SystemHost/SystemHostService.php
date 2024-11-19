<?php

namespace Jsadways\DataApi\Services\SystemHost;

use App\Exceptions\ServiceException;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Service\SystemHost\Contracts\SystemHostContract;

class SystemHostService implements SystemHostContract
{
    protected string $hr_host_url;
    protected Collection $system_list;

    public function __construct(){
        $get_api_url = config::get('data_api.get_api_url');
        $this->hr_host_url = config::get('data_api.hr_host');
        if(!empty($this->hr_host_url)){
            $this->hr_host_url .= $get_api_url;
        }
    }

    /**
     * @throws Exception
     */
    public function list(): SystemHostContract
    {
        // TODO: Implement list() method.
        $payload = [
            'repository' => 'systemRepository',
            'condition' => json_encode(['filter'=>[],'pre_page'=>0])
        ];
        $result = Http::get($this->hr_host_url,$payload)->json();
        if(empty($result) || $result['status_code'] !== 200){
            throw new ServiceException('HR host URL not found');
        }

        $this->system_list = Collect($result['data']);

        return $this;
    }

    /**
     * @throws Exception
     */
    public function get_api_url(string $name): string
    {
        // TODO: Implement get_api_url() method.
        $target_system = $this->system_list->filter(function ($item) use ($name) {
            return $item['name'] == $name;
        })->first();

        if(empty($target_system)){
            throw new ServiceException('Data Api URL not found');
        }

        $get_api_url = config::get('data_api.get_api_url');
        return $target_system['host'].$get_api_url;
    }
}
