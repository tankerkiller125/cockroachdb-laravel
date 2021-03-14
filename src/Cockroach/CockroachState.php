<?php


namespace Anoixis\Cockroach;


use Illuminate\Database\Connection;
use Illuminate\Database\Schema\SchemaState;

class CockroachState extends SchemaState
{

    public function dump(Connection $connection, $path)
    {
        $excludedTables = collect($connection->getSchemaBuilder()->getAllTables())
            ->map->tablename->reject(function ($table) {
                return $table === $this->migrationTable;
            })->map(function ($table) {
                return '';
            });

        $this->makeProcess(
            $this->baseDumpCommand(). $excludedTables .' > $LARAVEL_LOAD_PATH'
        )->mustRun($this->output, array_merge($this->baseVariables($this->connection->getConfig()), [
            'LARAVEL_LOAD_PATH' => $path,
        ]));
    }

    public function load($path)
    {
        $process = $this->makeProcess($this->baseDumpCommand() . ' < $LARAVEL_LOAD_PATH');

        $process->mustRun(null, array_merge($this->baseVariables($this->connection->getConfig()), [
            'LARAVEL_LOAD_PATH' => $path,
        ]));
    }

    protected function baseDumpCommand(): string
    {
        return 'cockroach dump $LARAVEL_LOAD_DATABASE --dump-mode=schema --host=$LARAVEL_LOAD_HOST --port=$LARAVEL_LOAD_PORT';
    }

    protected function baseVariables(array $config)
    {
        return [
            'LARAVEL_LOAD_HOST' => $config['host'],
            'LARAVEL_LOAD_PORT' => $config['port'],
            'LARAVEL_LOAD_USER' => $config['username'],
            'LARAVEL_LOAD_PASSWORD' => $config['password'],
            'LARAVEL_LOAD_DATABASE' => $config['database'],
        ];
    }
}
