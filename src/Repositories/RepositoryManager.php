<?php

namespace Jsadways\DataApi\Repositories;

use Exception;

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
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }

    }
}
