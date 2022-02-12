<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class OwnerFilter extends AbstractEloquentFilter
{
    protected $value;
    protected $column;
 
    public function __construct($value, $column)
    {
        $this->value = $value;
        $this->column = $column;
    }

    public function apply(Builder $query): Builder
    {
        return $query->whereHas('owner', function (Builder $owner_query) {
            $owner_query->where($this->column, 'like', "%{$this->value}%");
        });
        
    }
}
