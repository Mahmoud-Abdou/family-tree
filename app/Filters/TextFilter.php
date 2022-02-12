<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class TextFilter extends AbstractEloquentFilter
{
    protected $name;
    protected $column;
 
    public function __construct($name, $column)
    {
        $this->name = $name;
        $this->column = $column;
    }

    public function apply(Builder $query) : Builder
    {
        return $query->where($this->column, 'like', "%{$this->name}%");
    }
}
