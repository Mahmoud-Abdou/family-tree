<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Family extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'father_id',
        'mother_id',
        'children_count',
        'gf_family_id',
        'status',
        'family_tree',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'family_tree' => Json::class,
    ];

//    public function setFamilyTreeAttribute($value)
//    {
//        $this->attributes['family_tree'] = serialize($value);
//    }

    public function parentFamily()
    {
        return $this->hasOne('App\Models\Family', 'id', 'gf_family_id');
    }

    public function father()
    {
        return $this->hasOne('App\Models\Person', 'id', 'father_id');
    }

    public function mother()
    {
        return $this->hasOne('App\Models\Person', 'id', 'mother_id');
    }

    public function statusHtml()
    {
        switch ($this->status) {
            case 1:
                return '<span class="badge iq-bg-success">Active</span>';
            case 0:
                return '<span class="badge iq-bg-danger">Not Active</span>';
            default:
                return '<span class="badge iq-bg-warning">Pending</span>';
        }
    }

}
