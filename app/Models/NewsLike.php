<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsLike extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'news_id',
    ];

    public function owner()
    {
        return $this->hasOne('App\Models\User','id', 'owner_id');
    }

    public function news()
    {
        return $this->belongsTo('App\Models\News','news_id', 'id');
    }
}
