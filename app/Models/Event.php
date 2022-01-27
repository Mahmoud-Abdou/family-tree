<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
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

    protected $casts = [
        'approved' => 'boolean',
        'event_date' => 'datetime:Y-m-d HH:mm:ss',
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

}
