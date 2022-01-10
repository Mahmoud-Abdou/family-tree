<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
        'role_id',
        'city_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
//    protected $dateFormat = 'U';

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'status' => 'registered', // 'active'
        'role_id' => 3,
        'city_id' => 1,
    ];

    public function getFullNameAttribute()
    {
        return $this->name . ' ' . $this->name;
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    /**
     * Always encrypt the password when it is updated.
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
//        $this->attributes['password'] = bcrypt($password);
    }

    public function scopeActive()
    {
        return $this->attributes['status'] == 'active';
    }

    public function scopeIsActive($query)
    {
        return $query->where('status', '=', 'active');
    }

    public function role()
    {
        return $this->hasOne('Spatie\Permission\Models\Role','id', 'role_id');
    }

    public function city()
    {
        return $this->hasOne('app\Models\City','id', 'city_id');
    }

    public function profile()
    {
        return $this->belongsTo('app\Models\Person','id', 'user_id');
    }

    public function History()
    {
        return $this->hasMany('app\Models\History', 'user_id', 'id');
    }

}
