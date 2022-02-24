<?php

namespace App\Filters;

use App\Filters;
use Illuminate\Database\Eloquent\Builder;
use Pricecurrent\LaravelEloquentFilters\AbstractEloquentFilter;

class OwnerRelativesFilter extends AbstractEloquentFilter
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
            $owner_query->whereHas('profile', function (Builder $profile_query) {    
                $profile_query->whereHas('belongsToFamily', function (Builder $family_query) {            
                    $family_query->where($this->column, $this->value);
                });        
            });
        });
        
    }
}
