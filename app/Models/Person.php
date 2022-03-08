<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Filters\TextFilter;
use App\Filters\IDFilter;
use App\Filters\OwnerFilter;
use App\Filters\DateFilter;
use Pricecurrent\LaravelEloquentFilters\Filterable;
use App\Filters\OwnerRelativesFilter;

class Person extends Model
{
    use HasFactory, SoftDeletes;
    use Filterable;

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
        'birth_date' => 'datetime:Y-m-d',
        'death_date' => 'datetime:Y-m-d',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name', 'status', 'age'];

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
        switch (strtolower($this->gender)) {
            case 'male':
                return $this->hasMany('App\Models\Family', 'father_id', 'id');
            case 'female':
                return $this->hasMany('App\Models\Family', 'mother_id', 'id');
            default:
                return null;
        }
    }

    public function wifeOwnFamily()
    {
        return $this->hasOne('App\Models\Family', 'mother_id', 'id');
    }

    public function husband()
    {
        return $this->hasOneThrough('App\Models\Person', 'App\Models\Family', 'mother_id', 'id', 'id', 'father_id');
    }

    public function wives()
    {
        return $this->hasManyThrough('App\Models\Person', 'App\Models\Family', 'father_id', 'id', 'id', 'mother_id');
    }

    public function father()
    {
        return $this->hasOneThrough('App\Models\Person', 'App\Models\Family', 'id', 'id', 'family_id', 'father_id');
    }

    public function mother()
    {
        return $this->hasOneThrough('App\Models\Person', 'App\Models\Family', 'id', 'id', 'family_id', 'mother_id');
    }

    public function children()
    {
        return $this->hasManyThrough('App\Models\Person', 'App\Models\Family', 'father_id', 'family_id', 'id', 'id');
    }

    public function brothers()
    {
        return $this->hasManyThrough('App\Models\Person', 'App\Models\Family', 'id', 'family_id', 'family_id', 'id');
    }

    // accessories
    public function getPhotoAttribute($value)
    {
        return secure_asset($this->photoPath) . '/' . $value;
    }

    public function getStatusAttribute()
    {
        if (!$this->is_live) {
            return 'متوفي';
        } else {
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

    public function get4Name()
    {
        $father = $this->father;
        $grandFather = $father->father;
        $ggFather = isset($grandFather) ? $grandFather->father : null;
        return $this->first_name . ' ' . $father->first_name . ' ' . (isset($grandFather) ? $grandFather->first_name : '') . ' ' . (isset($ggFather) ? $ggFather->first_name : '');
    }

    public function getRelationFullNameAttribute()
    {
        $full_name = $this->first_name . ' ';
        if(isset($this->belongsToFamily->father)){
            $full_name .= $this->belongsToFamily->father->first_name . ' ';
            if(isset($this->belongsToFamily->father->belongsToFamily->father)){
                $full_name .= $this->belongsToFamily->father->belongsToFamily->father->first_name . ' ';
            }
        }
        return $full_name;
    }

    public function getFullNameLong()
    {
        return $this->prefix . ' ' . $this->first_name . ' ' . $this->father_name . ' ' . $this->grand_father_name . ' ' . $this->surname;
    }

//    public function getGenderAttribute($gender)
    public function genderName()
    {
        return $this->gender == 'male' ? 'ذكر' : 'انثى';
    }

    public function getBirthDateAttribute($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    public function getDeathDateAttribute($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    public function getAgeAttribute()
    {
        if ($this->is_live){
            return \Carbon\Carbon::parse($this->birth_date)->diff(\Carbon\Carbon::now())->format('%y سنوات');
        }

        return \Carbon\Carbon::parse($this->birth_date)->diff($this->death_date)->format('%y سنوات');
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

    public function filters($request_filter)
    {
        $filters = [];
        if(isset($request_filter['owner_name'])){
            $filters[] = new OwnerFilter($request_filter['owner_name'], 'name', 'user');
        }
        if(isset($request_filter['owner_phone'])){
            $filters[] = new OwnerFilter($request_filter['owner_phone'], 'mobile', 'user');
        }
        if(isset($request_filter['owner_email'])){
            $filters[] = new OwnerFilter($request_filter['owner_email'], 'email', 'user');
        }
        if(isset($request_filter['status'])){
            $filters[] = new OwnerFilter($request_filter['status'], 'status', 'user');
        }
        if(isset($request_filter['city'])){
            $filters[] = new OwnerFilter($request_filter['city'], 'city_id', 'user');
        }
        if(isset($request_filter['role'])){
            $filters[] = new OwnerFilter($request_filter['role'], 'role_id', 'user');
        }

        return $filters;
    }

}
