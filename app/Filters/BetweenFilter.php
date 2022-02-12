<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class BetweenFilter extends AbstractEloquentFilter
{
    protected $array;
    protected $column;
 
    public function __construct($array, $column)
    {
        $this->array = $array;
        $this->column = $column;
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereBetween($this->column, $this->array);
    }
}
