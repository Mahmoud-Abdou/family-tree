<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'city_id',
        'title',
        'body',
        'category_id',
        'approved',
        'approved_by',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['short_body'];

    // accessories
    public function getShortBodyAttribute($value)
    {
        return $value;
        // return str_limit($value, 20);
//        return str_limit($value, 20, '&raquo');
    }

    public function owner()
    {
        return $this->hasOne('App\Models\User','id', 'owner_id');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City','city_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id', 'id');
    }

    public function statusHtml()
    {
        switch ($this->status) {
            case 1:
                return '<span class="badge iq-bg-success">تم النشر</span>';
            case 0:
                return '<span class="badge iq-bg-danger">يحتاج موافقة</span>';
            default:
                return '<span class="badge iq-bg-warning">غير مصرح</span>';
        }
//        <div class="badge badge-pill badge-success">Moving</div>
    }
}
