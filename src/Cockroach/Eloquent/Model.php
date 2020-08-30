<?php
namespace Nbj\Cockroach\Eloquent;

use Illuminate\Database\Eloquent\Model as IlluminateModel;

abstract class Model extends IlluminateModel {
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
