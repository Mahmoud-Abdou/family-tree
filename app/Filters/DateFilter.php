<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class DateFilter extends AbstractEloquentFilter
{
    protected $from;
    protected $to;
    protected $column;
 
    public function __construct($from, $to, $column)
    {
        $this->from = $from;
        $this->to = $to;
        $this->column = $column;
    }

    public function apply(Builder $query)
    {
        return $query->whereDate($this->column, '>=', $this->from)
                    ->whereDate($this->column, '<=', $this->to);
    }
}
