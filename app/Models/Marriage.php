<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marriage extends Model
{
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

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
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

}
