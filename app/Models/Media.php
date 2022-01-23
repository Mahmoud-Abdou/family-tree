<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use hasImage;

    public $filePath = '/uploads/media/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'file',
        'category_id'
    ];

    public function getFileAttribute($file)
    {
        return asset($file);
        // return asset($this->filePath). '/' . $file;
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }
}
