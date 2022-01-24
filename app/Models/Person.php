<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    public $photoPath = '/uploads/persons/';

    protected $table = "persons";

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
    protected $appends = ['full_name', 'status'];

    // relations
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function belongsToFamily()
    {
        return $this->belongsTo('App\Models\Family', 'family_id', 'id');
//        return $this->hasOne('App\Models\Family', 'id', 'family_id');
    }

    public function ownFamily()
    {
        return $this->hasMany('App\Models\Family', 'id', 'family_id');
    }

    public function husband()
    {
        return $this->hasOneThrough('App\Models\Person', 'app\Models\Family', 'father_id', 'mother_id', 'id', 'id');
    }

    public function wife()
    {
        return $this->hasManyThrough('App\Models\Person', 'app\Models\Family', 'mother_id', 'father_id', 'id', 'id');
    }

    // accessories
    public function getPhotoAttribute($value)
    {
        return asset($this->photoPath) . '/' . $value;
    }

    public function getStatusAttribute()
    {
        if (!$this->is_live) {
            return 'متوفي';
        }
        else
        {
            if ($this->has_family) {
                return 'متزوج';
            }
            return 'غير متزوج';
        }

    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->father_name . ' ' . $this->grand_father_name;
    }

    public function getFullNameLong()
    {
        return $this->prefix . ' ' . $this->first_name . ' ' . $this->father_name . ' ' . $this->grand_father_name;
    }

    public function getGenderAttribute($gender)
    {
        return $gender == 'male' ? 'رجل' : 'امرأة';
    }

    // functions
    // check if user complete profile data
    public function completeData()
    {
        $missedData = [];

        foreach ($this->getFillable() as $field) {
            if (!isset($this->$field)){
                array_push($missedData,$field);
            }
        }

        return $missedData;
    }

}
