<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class OwnerFilter extends AbstractEloquentFilter
{
    protected $value;
    protected $column;
    protected $quary_with;
    protected $quary_type;
 
    public function __construct($value, $column, $quary_with = 'owner', $quary_type = 'like')
    {
        $this->value = $value;
        $this->column = $column;
        $this->quary_with = $quary_with;
        $this->quary_type = $quary_type;
    }

    public function apply(Builder $query): Builder
    {
        if($this->quary_type == 'like'){
            // dd($query->whereHas($this->quary_with, function (Builder $owner_query) {
            //     $owner_query->where($this->column, 'like', "%{$this->value}%");
            // })->first());
            return $query->whereHas($this->quary_with, function (Builder $owner_query) {
                $owner_query->where($this->column, 'like', "%{$this->value}%");
            });
        }
        else{
            return $query->whereHas($this->quary_with, function (Builder $owner_query) {
                $owner_query->where($this->column, $this->value);
            });
        }
        
    }
}
