<?php
namespace Anoixis\Cockroach\Eloquent;

use Illuminate\Database\Eloquent\Builder as IlluminateBuilder;

class Builder extends IlluminateBuilder {
    /**
     * @param array $values
     * @return array
     */
    protected function addUpdatedAtColumn(array $values): array
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
