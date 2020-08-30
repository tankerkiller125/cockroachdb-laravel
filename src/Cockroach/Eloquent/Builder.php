<?php
namespace Nbj\Cockroach\Eloquent;

use Illuminate\Database\Eloquent\Builder as IlluminateBuilder;

class Builder extends IlluminateBuilder {
    protected function addUpdatedAtColumn(array $values)
    {
        if (! $this->model->usesTimestamps() ||
            is_null($this->model->getUpdatedAtColumn())) {
            return $values;
        }

        $column = $this->model->getUpdatedAtColumn();

        $values = array_merge(
            [$column => $this->model->freshTimestampString()],
            $values
        );

        $segments = preg_split('/\s+as\s+/i', $this->query->from);

        $qualifiedColumn = $column;

        $values[$qualifiedColumn] = $values[$column];

        unset($values[$column]);

        return $values;
    }
}
