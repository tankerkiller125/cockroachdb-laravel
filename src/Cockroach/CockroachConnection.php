<?php

namespace Anoixis\Cockroach;

use Illuminate\Database\Connection;
use Anoixis\Cockroach\Builder\CockroachBuilder;
use Anoixis\Cockroach\Processor\CockroachProcessor;
use Doctrine\DBAL\Driver\PDOPgSql\Driver as DoctrineDriver;
use Anoixis\Cockroach\Grammar\Query\CockroachGrammar as QueryGrammar;
use Anoixis\Cockroach\Grammar\Schema\CockroachGrammar as SchemaGrammar;

class CockroachConnection extends Connection
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
     * @return \Illuminate\Database\Schema\PostgresBuilder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new CockroachBuilder($this);
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \App\Cockroach\Schema\CockroachGrammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new SchemaGrammar);
    }

    /**
     * Get the default post processor instance.
     *
     * @return \Illuminate\Database\Query\Processors\PostgresProcessor
     */
    protected function getDefaultPostProcessor()
    {
        return new CockroachProcessor();
    }

    /**
     * Get the Doctrine DBAL driver.
     *
     * @return \Doctrine\DBAL\Driver\PDOPgSql\Driver
     */
    protected function getDoctrineDriver()
    {
        return new DoctrineDriver;
    }
}
