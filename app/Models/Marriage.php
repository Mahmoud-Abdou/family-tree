<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Filters\TextFilter;
//use App\Filters\IDFilter;
//use App\Filters\BetweenFilter;
//use App\Filters\InFilter;
use App\Filters\OwnerFilter;
use App\Filters\DateFilter;
use Pricecurrent\LaravelEloquentFilters\Filterable;

class Marriage extends Model
{
    use Filterable;

    public $photoPath = '/uploads/marriage/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'family_id',
        'husband_id',
        'wife_id',
        'title',
        'body',
        'image_id',
        'date',
    ];

    protected $appends = ['short_body', 'notification_body'];

    public function getNotificationBodyAttribute()
    {
        $text = strip_tags($this->body);
        return substr($text, 0, 20) . ' ....';
    }

    public function getShortBodyAttribute()
    {
        $text = strip_tags($this->body);
        return substr($text, 0, 160) . ' ....';
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }

    public function approver()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }

    public function family()
    {
        return $this->belongsTo('App\Models\Family', 'family_id', 'id');
    }

    public function father()
    {
        return $this->belongsTo('App\Models\Person', 'husband_id', 'id');
    }

    public function mother()
    {
        return $this->belongsTo('App\Models\Person', 'wife_id', 'id');
    }

    public function image()
    {
        return $this->hasOne('App\Models\Media', 'id', 'image_id');
    }

    public function scopeActive($query)
    {
        $query->where('approved', true);
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
