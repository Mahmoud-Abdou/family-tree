<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Death extends Model
{
    public $photoPath = '/uploads/death/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'family_id',
        'title',
        'body',
        'image_id',
        'date'
    ];

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }

    public function image()
    {
        return $this->hasOne('App\Models\Media', 'id', 'image_id');
    }

}
