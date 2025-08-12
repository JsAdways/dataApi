<?php

namespace Jsadways\DataApi\Services\Cross\DataStream;

use Exception;
use Jsadways\DataApi\Core\Common\Dto;
use Jsadways\DataApi\Core\Services\Cross\Contracts\PayloadContract;
use Jsadways\DataApi\Core\Services\Data\Contracts\DataStreamContract;
use ReflectionClass;
use ReflectionException;

final class DataStreamManager
{
    protected array $cross_dto = [
        'start_string' => 'Cross',
        'end_string' => 'Dto',
    ];
    protected array $stream_dto = [
        'end_string' => 'ApiDto',
    ];
    protected array $namespace = [
        'stream_api' => 'Jsadways\\DataApi\\Services\\Cross\\DataStream\\API',
        'stream_dto' => 'Jsadways\\DataApi\\Core\\Services\\Data\\Dtos',
    ];
    protected string $stream_api_end_string = 'APIService';

    /**
     * 實例化 Repository
     *
     * @param string $system_host
     * @param PayloadContract $payload
     * @return DataStreamContract
     * @throws ReflectionException
     * @throws Exception
     */
    public function get(string $system_host,PayloadContract $payload): DataStreamContract
    {
        $data_stream_name = $this->_find_stream_name($payload);
        $data_stream_api_name = $this->_find_stream_api_name($data_stream_name);

        //先處理api需要的payload
        $data_stream_dto_name = $this->_find_stream_dto_name($data_stream_name);
        $data_stream_payload = $this->_payload_transform($data_stream_dto_name,$this->_payload_merge_data($payload,$system_host));
        $payloadDto = $this->_build_payload($data_stream_dto_name, $data_stream_payload);

        return $this->_build(
            class: $data_stream_api_name,
            payload: $payloadDto
        );
    }

    /**
     * @throws Exception
     */
    protected function _find_stream_name(PayloadContract $payload): string
    {
        $reflection_class = new ReflectionClass($payload);
        $cross_dto_class_name = $reflection_class->getShortName();
        if(str_starts_with($cross_dto_class_name, $this->cross_dto['start_string']) && str_ends_with($cross_dto_class_name, $this->cross_dto['end_string']))
        {
            return str_replace([$this->cross_dto['start_string'],$this->cross_dto['end_string']], '', $cross_dto_class_name);
        }

        throw new Exception("Class $cross_dto_class_name does not exist");
    }

    protected function _find_stream_api_name(string $data_stream_name):string
    {
        $api_class = $this->namespace['stream_api'].'\\'.ucfirst($data_stream_name).$this->stream_api_end_string;
        if(class_exists($api_class))
        {
            return $api_class;
        }

        throw new Exception("API Class $api_class does not exist");
    }

    /**
     * @throws Exception
     */
    protected function _find_stream_dto_name(string $data_stream_name):string
    {
        $payload_class = $this->namespace['stream_dto'].'\\'.ucfirst($data_stream_name).$this->stream_dto['end_string'];
        if(class_exists($payload_class))
        {
            return $payload_class;
        }

        throw new Exception("Payload Dto Class $payload_class does not exist");
    }

    /**
     * @throws ReflectionException
     */
    protected function _payload_transform(string $data_stream_dto, array $payload_item): array
    {
        $reflection_class = new ReflectionClass($data_stream_dto);
        $constructor_parameters = $reflection_class->getConstructor()->getParameters();
        return collect($constructor_parameters)->reduce(function ($result, $parameter_item) use ($payload_item) {
            $key = $parameter_item->getName();
            if(isset($payload_item[$key])){
                $result[$key] = $payload_item[$key];
            }

            return $result;
        },[]);
    }

    protected function _build_payload(string $data_stream_dto_name, array $data_stream_payload): Dto
    {
        return new $data_stream_dto_name(...$data_stream_payload);
    }

    /**
     * @throws Exception
     */
    protected function _build(string $class, Dto $payload): DataStreamContract
    {
        return new $class($payload);
    }

    protected function _payload_merge_data(PayloadContract $payload,string $system_host): array
    {
        $payload_item = $payload->get();
        $payload_item['system_host'] = $system_host;

        return $payload_item;
    }
}
