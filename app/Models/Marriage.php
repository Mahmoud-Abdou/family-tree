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


}
