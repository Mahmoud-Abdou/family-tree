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
    use HasFactory, SoftDeletes, Filterable;

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
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'birth_date',
        'death_place',
        'created_at',
        'updated_at',
        'deleted_at'
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
            case 'female':
                return $this->hasMany('App\Models\Family', 'mother_id', 'id');
            default:
                return $this->hasMany('App\Models\Family', 'father_id', 'id');
        }
    }

    public function family()
    {
        return $this->hasOne('App\Models\Family', 'id', 'family_id');
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
            return '??????????';
        } else {
            if ($this->has_family) {
                return '??????????';
            }
            return '?????? ??????????';
        }
    }

    public function getFullNameAttribute()
    {
        if (isset($this->father)) {

            return $this->getCompleteName();
        }
        return $this->first_name . ' ' . $this->father_name . ' ' . $this->grand_father_name . ' ' . $this->surname;
    }

    public function getCompleteName($name = "", $num = 0, $father = null)
    {
        $nameCount = \App\Helpers\AppHelper::GeneralSettings('full_name_count');
        if ($nameCount < 4) $nameCount = 4;
        $fullName = $name;

        if ($num == 0) {
            $fullName = $this->first_name;
            $fatherName = $this;
        } else {
            $fatherName = $father;
            if (isset($fatherName)) {
                $fatherName = $fatherName->father()->first();
            }

            if (isset($fatherName)) {
                $fullName .= " {$fatherName->first_name}";
            }
            else {
                if ($num <= $nameCount) {
                    $fullName .= " {$father->father_name}";
                }
                if ($num + 1 <= $nameCount) {
                    $fullName .= " {$father->grand_father_name}";
                }

                $num = $nameCount + 1;
            }
        }

        if ($num <= $nameCount) {
            return $this->getCompleteName($fullName, $num + 1, $fatherName);
        } else {
            return $fullName;
        }
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
        return $this->gender == 'male' ? '??????' : '????????';
    }

    public function getBirthDateAttribute($date)
    {
        if (isset($date)) {
            return date('Y-m-d', strtotime($date));
        }
        return '-';
    }

    public function getDeathDateAttribute($date)
    {
        if (isset($date)) {
            return date('Y-m-d', strtotime($date));
        }
        return '-';
    }

    public function getAgeAttribute()
    {
        if ($this->is_live && $this->birth_date != '-'){
            return \Carbon\Carbon::parse($this->birth_date)->diff(\Carbon\Carbon::now())->format('%y ??????????');
        }

        if ($this->death_date != '-' && $this->birth_date != '-'){
            return \Carbon\Carbon::parse($this->birth_date)->diff($this->death_date)->format('%y ??????????');
        }

        return '-';
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
        if(isset($request_filter['name'])){
            $filters[] = new TextFilter($request_filter['name'], 'first_name');
        }
        if(isset($request_filter['father_name'])){
            $filters[] = new OwnerFilter($request_filter['father_name'], 'first_name', 'father');
        }
        if(isset($request_filter['grand_father_name'])){
            $filters[] = new OwnerFilter($request_filter['grand_father_name'], 'father_name', 'father');
        }
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
