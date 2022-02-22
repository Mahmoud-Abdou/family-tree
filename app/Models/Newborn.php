<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Filters\TextFilter;
//use App\Filters\IDFilter;
//use App\Filters\BetweenFilter;
//use App\Filters\InFilter;
use App\Filters\OwnerFilter;
use Pricecurrent\LaravelEloquentFilters\Filterable;
use App\Filters\DateFilter;

class Newborn extends Model
{
    use Filterable, HasFactory;

    public $photoPath = '/uploads/newborn/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'family_id',
        'person_id',
        'title',
        'body',
        'image_id',
        'date',
    ];

    protected $casts = [
        'date' => 'datetime:Y-m-d',
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

    public function getDateAttribute($date)
    {
        return date('Y-m-d', strtotime($date));
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

    public function image()
    {
        return $this->hasOne('App\Models\Media', 'id', 'image_id');
    }

    public function person()
    {
        return $this->hasOne('App\Models\Person', 'id', 'person_id');
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
