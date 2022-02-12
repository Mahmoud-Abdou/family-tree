<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;
use Carbon\Carbon;

class DateFilter extends AbstractEloquentFilter
{
    protected $from;
    protected $column;
 
    public function __construct($from, $column)
    {
        if($from == 1){
            $this->from = Carbon::now()->startOfYear();
        }
        else if($from == 2){
            $this->from = Carbon::now()->startOfMonth();
        }
        else if($from == 3){
            $this->from = Carbon::now()->startOfWeek();
        }
        else if($from == 4){
            $this->from = Carbon::now()->startOfDay();
        }
            
        $this->column = $column;
    }

    public function apply(Builder $query) : Builder
    {
        return $query->whereDate($this->column, '>=', $this->from);
    }
}
