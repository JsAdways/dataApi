<?php

namespace Jsadways\DataApi\Services\SystemHost;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Core\Services\SystemHost\Contracts\SystemHostContract;

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
        if(Cache::has('data_api_system_list')){
            $this->system_list = Cache::get('data_api_system_list');
        }else{
            $payload = [
                'repository' => 'System',
                'condition' => json_encode(['filter'=>[],'per_page'=>0])
            ];
            $result = Http::get($this->hr_host_url,$payload)->json();
            if(empty($result)){
                throw new Exception('HR host URL not found');
            }

            $this->system_list = Collect($result['data']);

            Cache::put('data_api_system_list',$this->system_list,now()->addHours(24));
        }

        return $this;
    }

    /**
     * @throws Exception
     */
    public function get_api_url(string $name): string
    {
        // TODO: Implement get_api_url() method.
        if($this->_find_fix_host($name)){
            return $this->_find_fix_host($name);
        }

        $target_system = $this->system_list->filter(function ($item) use ($name) {
            return $item['name'] == $name;
        })->first();

        if(empty($target_system)){
            throw new Exception('Data Api URL not found');
        }

        return $target_system['host'];
    }

    public function all(): array
    {
        return $this->system_list->toArray();
    }

    protected function _find_fix_host(string $name): string | bool
    {
        if(Config::has('data_api.fix_host.'.$name)){
            return Config::get('data_api.fix_host.'.$name);
        }

        return false;
    }
}
