<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Filters\TextFilter;
use App\Filters\IDFilter;
use App\Filters\BetweenFilter;
use App\Filters\InFilter;
use App\Filters\OwnerFilter;
use Pricecurrent\LaravelEloquentFilters\Filterable;
use App\Filters\DateFilter;

class Report extends Model
{
    use Filterable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'type',
        'type_id',
        'body',
    ];
    
    protected $appends = ['short_body'];

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }

    public function getShortBodyAttribute()
    {
        $text = strip_tags($this->body);
        return substr($text, 0, 160) . ' ....';
    }
    

    public function filters($request_filter)
    {
        $filters = [];
        if(isset($request_filter['body'])){
            $filters[] = new TextFilter($request_filter['body'], 'body');
        }

        if(isset($request_filter['owner_name'])){
            $filters[] = new OwnerFilter($request_filter['owner_name'], 'name');
        }
        if(isset($request_filter['owner_phone'])){
            $filters[] = new OwnerFilter($request_filter['owner_phone'], 'mobile');
        }
        if(isset($request_filter['owner_email'])){
            $filters[] = new OwnerFilter($request_filter['owner_email'], 'email');
        }
        if(isset($request_filter['date'])){
            $filters[] = new DateFilter($request_filter['date'], 'created_at');
        }

        return $filters;
    }


}
