<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// User History
class History extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'last_login',
        'ip',
        'os',
        'browser',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}
