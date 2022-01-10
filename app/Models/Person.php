<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'father_name',
        'grand_father_name',
        'surname',
        'prefix',
        'job',
        'bio',
        'gender',
        'photo',
        'has_family',
        'family_id',
        'relation',
        'address',
        'is_live',
        'birth_date',
        'birth_place',
        'death_date',
        'death_place',
        'verified',
        'symbol',
        'color',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'has_family' => 'boolean',
        'is_live' => 'boolean',
        'verified' => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->father_name . ' ' . $this->grand_father_name;
    }

    public function user()
    {
        return $this->hasOne('app\Models\User', 'id', 'user_id');
    }

    public function belongsToFamily()
    {
        return $this->hasOne('app\Models\Family', 'id', 'family_id');
    }

    public function OwnFamily()
    {
        return $this->hasMany('app\Models\Family', 'father_id', 'id');
    }

    public function Husband()
    {
        return $this->hasOneThrough('app\Models\Person', 'app\Models\Family', 'father_id', 'mother_id', 'id', 'id');
    }

    public function Wife()
    {
        return $this->hasManyThrough('app\Models\Person', 'app\Models\Family', 'mother_id', 'father_id', 'id', 'id');
    }

}
