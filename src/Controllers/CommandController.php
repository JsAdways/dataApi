<?php

namespace Jsadways\DataApi\Controllers;

use Illuminate\Routing\Route as RouteElement;
use Illuminate\Support\Facades\Route;
use Jsadways\DataApi\Core\Attributes\ServiceAPI;
use ReflectionException;
use ReflectionMethod;

class CommandController
{
    /**
     * @throws ReflectionException
     */
    public function service_list(): array
    {
        $serviceApi_routes = [];
        $all_routes = Route::getRoutes();
        foreach ($all_routes as $route){
            if($this->_is_service_api($route))
            {
                $attributes = $this->_get_controller_attribute($route);
                $api_element = [
                    'method' => implode('|', $route->methods()),
                    'uri' => $route->uri(),
                    'param' => $this->_get_parameters($attributes),
                ];
                $serviceApi_routes [] = $api_element;
            }
        }

        return ['data'=>$serviceApi_routes];
    }

    protected function _is_service_api(RouteElement $route): bool
    {
        return str_starts_with($route->uri(), 'api/service_api');
    }

    /**
     * @throws ReflectionException
     */
    protected function _get_controller_attribute(RouteElement $route): array
    {
        list($controller,$method) = explode('@',$route->getActionName());
        $controller_method = new ReflectionMethod($controller,$method);

        return $controller_method->getAttributes(ServiceAPI::class);
    }

    protected function _get_parameters(array $attributes): array
    {
        return array_map(function ($attribute) {
            return $attribute->getArguments();
        },$attributes);
    }
}
