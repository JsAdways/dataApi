<?php

namespace Jsadways\DataApi\Traits;

use App\Core\Manager\GetObjectDto;
use App\Managers\RepositoryManager;
use Exception;

trait UseRepository
{
    /**
     * 呼叫需實例化 Class
     *
     * @param string $name
     * @return object
     * @throws Exception
     */
    protected function repository(string $name): object
    {
        $repository_manager = new RepositoryManager();
        return $repository_manager->get(new GetObjectDto($name));
    }
}
