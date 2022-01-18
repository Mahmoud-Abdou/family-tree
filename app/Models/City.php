<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class City extends Model
{
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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Always slug the name when it is updated or create.
     * @param $value
     */
    public function setNameEnAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($value);
        $this->attributes['name_en'] = Str::title($value);
    }

    /**
     * Always slug the name when it is updated or create.
     * @param $value
     */
    public function setCountryEnAttribute($value)
    {
        $this->attributes['country_en'] = Str::title($value);
    }

    public function scopeActive()
    {
        return $this->attributes['status'] == true;
    }

    public function getStatusAttribute($value)
    {
        if ($value) {
            return '<span class="badge iq-bg-success">مفعل</span>';
        }
        return '<span class="badge iq-bg-warning">غير مفعل</span>';
    }

    public function users()
    {
        return $this->hasMany('App\Models\User', 'city_id', 'id');
    }

    public function roles()
    {
        return $this->hasMany('Spatie\Permission\Models\Role', 'cities', 'id');
    }
}
