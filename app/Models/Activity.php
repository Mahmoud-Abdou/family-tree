<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'log_activity';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject', 'user_id', 'action', 'action_id', 'uri', 'method', 'ip_address', 'agent'];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function log()
    {
        switch (strtolower($this->action)) {
            case 'user':
                return $this->belongsTo('App\Models\User', 'action_id', 'id');
            case 'role':
                return $this->belongsTo('Spatie\Permission\Models\Role', 'action_id', 'id');
            case 'city':
                return $this->belongsTo('App\Models\City', 'action_id', 'id');
            case 'category':
                return $this->belongsTo('App\Models\Category', 'action_id', 'id');
            case 'setting':
                return $this->belongsTo('App\Models\Setting', 'action_id', 'id');
            case 'news':
                return $this->belongsTo('App\Models\News', 'action_id', 'id');
            case 'event':
                return $this->belongsTo('App\Models\Event', 'action_id', 'id');
            case 'media':
                return $this->belongsTo('App\Models\Media', 'action_id', 'id');
            case 'newborn':
                return $this->belongsTo('App\Models\Newborn', 'action_id', 'id');
            case 'marriage':
                return $this->belongsTo('App\Models\Marriage', 'action_id', 'id');
            case 'death':
                return $this->belongsTo('App\Models\Death', 'action_id', 'id');
            case 'person':
                return $this->belongsTo('App\Models\Person', 'action_id', 'id');
            case 'family':
                return $this->belongsTo('App\Models\Family', 'action_id', 'id');
            case 'report':
                return $this->belongsTo('App\Models\Report', 'action_id', 'id');
            case 'comment':
                return $this->belongsTo('App\Models\Comment', 'action_id', 'id');
            default:
                return $this->action_id;
        }
    }

    public function getMethodAttribute($value)
    {
        switch (strtolower($value)) {
            case 'get':
                return '<span class="badge iq-bg-primary">'.$value.'</span>';
            case 'post':
                return '<span class="badge iq-bg-success">'.$value.'</span>';
            case 'delete':
                return '<span class="badge iq-bg-danger">'.$value.'</span>';
            default:
                return '<span class="badge iq-bg-warning">'.$value.'</span>';
        }
    }

}
