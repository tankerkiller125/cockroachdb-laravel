<?php

namespace Anoixis\Cockroach\Processor;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Processors\Processor;

class CockroachProcessor extends Processor
{
    /**
     * Process an "insert get ID" query.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @param string $sql
     * @param array $values
     * @param null|string $sequence
     * @return int
     */
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null): int
    {
        $result = $query->getConnection()->selectFromWriteConnection($sql, $values)[0];

        $sequence = $sequence ?: 'id';

        $id = is_object($result) ? $result->{$sequence} : $result[$sequence];

        return is_numeric($id) ? (int) $id : $id;
    }

    /**
     * Process the results of a column listing query.
     *
     * @param  array  $results
     * @return array
     */
    public function processColumnListing($results): array
    {
        return array_map(function ($result) {
            return with((object) $result)->column_name;
        }, $results);
    }
}
