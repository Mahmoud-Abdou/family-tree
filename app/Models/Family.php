<?php

namespace App\Models;

use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pricecurrent\LaravelEloquentFilters\Filterable;
use App\Filters\OwnerFilter;

class Family extends Model
{
    use HasFactory, SoftDeletes;
    use Filterable;

    public static function boot()
    {
        parent::boot();

        self::created(function($model){
            $model->children_count++;
        });
    }

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

    public function scopeChildless($q)
    {
        $q->has('children_count', '=', 0);
    }

    public function setFamilyTreeAttribute($value)
    {
        $this->attributes['family_tree'] = serialize($value);
    }

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

    public function members()
    {
        return $this->hasMany('App\Models\Person', 'family_id', 'id');
    }

    public function gfFamilies()
    {
        return $this->hasMany('App\Models\Family', 'gf_family_id', 'id');
    }

    public function fosterBrothers()
    {
        return $this->hasManyThrough('App\Models\Person','App\Models\FosterBrother', 'family_id', 'id', 'id', 'person_id');
//        return $this->hasMany('App\Models\FosterBrother', 'family_id', 'id');
    }

    public function fosterFamily()
    {
        return $this->hasManyThrough('App\Models\Person','App\Models\FosterBrother', 'family_id', 'id', 'id', 'person_id');
    }

    public function statusHtml()
    {
        switch ($this->status) {
            case 1:
                return '<span class="badge badge-pill badge-success p-3"> </span>';
            case 0:
                return '<span class="badge badge-pill badge-amber p-3"> </span>';
            default:
                return '<span class="badge badge-pill badge-danger p-3"> </span>';
        }
    }

    public function TreeRender($fid)
    {
        $families = self::where('father_id', $fid)->get();

        if ($fid === 0 || !isset($families))
        {
            return [];
        }
        else {
            foreach ($families as $f) {
                foreach ($f->members as $child) {
                    return ['id' => $fid, 'name' => $f->father->full_name, 'wife' => $f->mother->full_name, 'children' => [self::TreeRender($child->id)]];
                }
            }

        }
    }

    public function filters($request_filter)
    {
        $filters = [];
        if(isset($request_filter['father_name'])){
            $filters[] = new OwnerFilter($request_filter['father_name'], 'first_name', 'father');
        }
        if(isset($request_filter['mother_name'])){
            $filters[] = new OwnerFilter($request_filter['mother_name'], 'first_name', 'mother');
        }
        if(isset($request_filter['grand_father_name'])){
            $filters[] = new OwnerFilter($request_filter['grand_father_name'], 'father_name', 'father');
        }

        return $filters;
    }


}
