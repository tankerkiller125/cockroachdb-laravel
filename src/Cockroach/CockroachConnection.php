<?php

namespace Anoixis\Cockroach;

use Illuminate\Database\Connection;
use Anoixis\Cockroach\Builder\CockroachBuilder;
use Anoixis\Cockroach\Processor\CockroachProcessor;
use Doctrine\DBAL\Driver\PDO\PgSQL\Driver as DoctrineDriver;
use Anoixis\Cockroach\Grammar\Query\CockroachGrammar as QueryGrammar;
use Anoixis\Cockroach\Grammar\Schema\CockroachGrammar as SchemaGrammar;
use Illuminate\Database\PostgresConnection;

class CockroachConnection extends PostgresConnection
{
    /**
     * Get the default query grammar instance.
     *
     */
    protected function getDefaultQueryGrammar()
    {
        return $this->withTablePrefix(new QueryGrammar);
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return CockroachBuilder
     */
    public function getSchemaBuilder(): CockroachBuilder
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new CockroachBuilder($this);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \Illuminate\Database\Grammar
     */
    protected function getDefaultSchemaGrammar(): \Illuminate\Database\Grammar
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }

    /**
     * Get the default post processor instance.
     *
     * @return CockroachProcessor
     */
    protected function getDefaultPostProcessor(): CockroachProcessor
    {
        return new CockroachProcessor();
    }

    /**
     * Get the Doctrine DBAL driver.
     *
     * @return DoctrineDriver
     */
    protected function getDoctrineDriver(): DoctrineDriver
    {
        return new DoctrineDriver;
    }

    public function getSchemaState($files = null, callable $processFactory = null): CockroachState
    {
        return new CockroachState($this, $files, $processFactory);
    }
}
