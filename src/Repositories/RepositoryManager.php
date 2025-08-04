<?php

namespace Jsadways\DataApi\Repositories;

use Exception;
use Throwable;

final class RepositoryManager
{
    /**
     * 實例化 Repository
     *
     * @param string $name
     * @return object
     * @throws Exception
     */
    public function get(string $name): object
    {
        try {
            $namespace = 'App\\Repositories\\';
            $repository = "{$namespace}{$name}" . "Repository";
            return new $repository;
        } catch (Throwable $throwable) {
            throw new Exception($throwable->getMessage());
        }

    }
}
