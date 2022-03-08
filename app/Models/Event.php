<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Filters\TextFilter;
use App\Filters\IDFilter;
//use App\Filters\BetweenFilter;
//use App\Filters\InFilter;
use App\Filters\OwnerFilter;
use App\Filters\DateFilter;
use Pricecurrent\LaravelEloquentFilters\Filterable;
use App\Filters\OwnerRelativesFilter;

class Event extends Model
{
    use Filterable, HasFactory;

    public $photoPath = '/uploads/events/';

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
        'image_id',
        'category_id',
        'event_date',
        'approved',
        'approved_by',
    ];

    protected $appends = ['short_body', 'notification_body'];

    protected $casts = [
        'approved' => 'boolean',
        'event_date' => 'datetime:Y-m-d H:i:s',
    ];

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
        return $this->belongsTo('App\Models\City', 'city_id', 'id');
    }

    public function image()
    {
        return $this->hasOne('App\Models\Media', 'id', 'image_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function scopeActive($query)
    {
        $query->where('approved', true);
    }

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

        return $filters;
    }

}
