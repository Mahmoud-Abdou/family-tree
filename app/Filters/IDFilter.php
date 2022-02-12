<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class IDFilter extends AbstractEloquentFilter
{
    protected $id;
    protected $column;
 
    public function __construct($id, $column)
    {
        $this->id = $id;
        $this->column = $column;
    }

    public function apply(Builder $query) : Builder
    {
        return $query->where($this->column, $this->id);
    }
}
