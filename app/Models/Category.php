<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $photoPath = '/uploads/category/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name_en',
        'name_ar',
        'type',
        'icon',
        'image',
    ];

    public function getImageAttribute($image)
    {
        return asset($this->photoPath). '/' . $image;
    }

}
