<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name_ar',
        'name_en',
        'country_ar',
        'country_en',
        'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Always slug the name when it is updated or create.
     * @param $value
     */
    public function setNameEnAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
        $this->attributes['name_en'] = $value;
    }

    public function scopeActive()
    {
        return $this->attributes['status'] == true;
    }

}
