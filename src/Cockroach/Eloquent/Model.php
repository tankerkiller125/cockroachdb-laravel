<?php
namespace Anoixis\Cockroach\Eloquent;

use Illuminate\Database\Eloquent\Model as IlluminateModel;

abstract class Model extends IlluminateModel {
    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @return Builder|Model|\Illuminate\Database\Eloquent\Builder
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
