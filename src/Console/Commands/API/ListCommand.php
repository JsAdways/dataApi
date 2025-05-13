<?php

namespace Jsadways\DataApi\Console\Commands\API;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Jsadways\DataApi\Services\SystemHost\SystemHostService;

class ListCommand extends Command
{
    protected $name = 'data-api:list';
    protected $description = 'list all data-api';

    /**
     * @throws Exception
     */
    public function handle(): void
    {

        $system_list = (new SystemHostService())->list()->all();

        foreach($system_list as $system){
            $result = Http::post($system['host'].'/command/service_list');
            if($result->successful()){
                $this->_outputTable([$system['name']],[]);
                $this->_refactor_data($result->json()['data']);
            }
        }
    }

    protected function _refactor_data(array $api_list): void
    {
        $table_header = ['Method','URI','Parameters'];
        $row_data = [];

        foreach($api_list as $api){
            $row_data[] = [
                'Method' => $api['method'],
                'URI' => $api['uri'],
                '',
                'Name',
                'Type',
                'Required',
                'Description',
            ];
            foreach($api['param'] as $index => $param){
                $row_data[] = [
                    's0' => '',
                    's1' => '',
                    'index' => $index,
                    'name' => $param['name'],
                    'type' => $param['type'],
                    'required' => $param['required'],
                    'description' => $param['description'],
                ];
            }
        }

        $this->_outputTable($table_header,$row_data);
    }

    protected function _outputTable(array $headers, array $rows): void
    {
        $columns = array_map('strlen', $headers);
        foreach ($rows as $row) {
            $columns = array_map(function ($max, $value) {
                return max($max, strlen($value));
            }, $columns, $row);
        }

        $separator = '+-' . implode('-+-', array_map(fn ($length) => str_repeat('-', $length), $columns)) . '-+';

        $this->line($separator);
        $this->line('| ' . implode(' | ', array_map(fn ($header, $length) => str_pad($header, $length), $headers, $columns)) . ' |');
        if(count($rows) !== 0){
            $this->line($separator);
        }

        foreach ($rows as $row) {
            $this->line('| ' . implode(' | ', array_map(fn ($value, $length) => str_pad($value, $length), $row, $columns)) . ' |');
        }

        $this->line($separator);
    }
}
