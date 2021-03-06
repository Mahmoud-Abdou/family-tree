<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\TextFilter;
use App\Filters\IDFilter;
//use App\Filters\BetweenFilter;
//use App\Filters\InFilter;
use App\Filters\OwnerFilter;
use App\Filters\DateFilter;
use Pricecurrent\LaravelEloquentFilters\Filterable;
use App\Filters\OwnerRelativesFilter;

class News extends Model
{
    use Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'city_id',
        'title',
        'body',
        'category_id',
        'approved',
        'approved_by',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['short_body', 'notification_body'];

    public function getNotificationBodyAttribute()
    {
        $text = strip_tags($this->body);
        return mb_substr($text, 0, 20,'utf-8') . ' ....';
    }

    public function getShortBodyAttribute()
    {
        $text = strip_tags($this->body);
        return mb_substr($text, 0, 160,'utf-8') . ' ....';
    }

    public function scopeActive($query)
    {
        $query->where('approved', true);
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City','city_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\NewsComment', 'news_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function likes()
    {
        return $this->hasMany('App\Models\NewsLike', 'news_id', 'id');
    }

    public function statusHtml()
    {
        switch ($this->approved) {
            case 1:
                return '<span class="badge iq-bg-success">???? ??????????</span>';
            case 0:
                return '<span class="badge iq-bg-danger">?????????? ????????????</span>';
            default:
                return '<span class="badge iq-bg-warning">?????? ????????</span>';
        }
//        <div class="badge badge-pill badge-success">????????????</div>
    }

    public function filters($request_filter)
    {
        $filters = [];
        if(isset($request_filter['title'])){
            $filters[] = new TextFilter($request_filter['title'], 'title');
        }
        if(isset($request_filter['body'])){
            $filters[] = new TextFilter($request_filter['body'], 'body');
        }

        if(isset($request_filter['city'])){
            $filters[] = new IDFilter($request_filter['city'], 'city_id');
        }
        if(isset($request_filter['category'])){
            $filters[] = new IDFilter($request_filter['category'], 'category_id');
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
        if(isset($request_filter['relatives'])){
            if(isset(auth()->user()->profile->belongsToFamily)){
                $relatives_famiy_id = auth()->user()->profile->belongsToFamily->gf_family_id;
                $filters[] = new OwnerRelativesFilter($relatives_famiy_id, 'gf_family_id');
            }
        }

        if(isset($request_filter['approved'])){
            $filters[] = new IDFilter($request_filter['approved'], 'approved');
        }

        return $filters;
    }
}
