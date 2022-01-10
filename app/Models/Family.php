<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

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

    public function ParentFamily()
    {
        return $this->hasOne('app\Models\Family', 'id', 'gf_family_id');
    }

    public function Father()
    {
        return $this->hasOne('app\Models\Person', 'id', 'father_id');
    }

    public function Mother()
    {
        return $this->hasOne('app\Models\Person', 'id', 'mother_id');
    }

}
