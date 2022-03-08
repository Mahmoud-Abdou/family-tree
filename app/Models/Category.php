<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $photoPath = '/uploads/category/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'name_en',
        'name_ar',
        'type',
        'icon',
        'image',
        'color'
    ];

    protected $primaryKey = 'slug';
    protected $keyType = 'string';
    public $incrementing = false;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['type_ar'];

    public function getImageAttribute($image)
    {
        return secure_asset($this->photoPath). '/' . $image;
    }

    public function getIconAttribute($icon)
    {
        return secure_asset($this->photoPath). '/' . $icon;
    }

    public function getTypeArAttribute(){
        switch ($this->type) {
            case 'general':
                return 'عام';
            case 'media':
                return 'صورة';
            case 'video':
                return 'فيديو';
            case 'event':
                return 'مناسبة';
            case 'news':
                return 'أخبار';
            case 'newborn':
                return 'ولادة';
            case 'marriages':
                return 'زواج';
            case 'deaths':
                return 'الوفيات';
            default:
                return $this->type;
        }
    }



    public static function getTypeName($type)
    {
        switch ($type) {
            case 'general':
                return 'عام';
            case 'media':
                return 'صورة';
            case 'video':
                return 'فيديو';
            case 'event':
                return 'مناسبة';
            case 'news':
                return 'أخبار';
            case 'newborn':
                return 'ولادة';
            case 'marriages':
                return 'زواج';
            case 'deaths':
                return 'الوفيات';
            default:
                return $type;
        }
    }

    public function typeHtml()
    {
        switch ($this->type) {
            case 'general':
                return '<span class="badge iq-bg-info">عام</span>';
            case 'media':
                return '<span class="badge iq-bg-warning">صورة</span>';
            case 'video':
                return '<span class="badge iq-bg-danger">فيديو</span>';
            case 'event':
                return '<span class="badge iq-bg-primary">مناسبة</span>';
            case 'news':
                return '<span class="badge iq-bg-secondary">أخبار</span>';
            case 'newborn':
                return '<span class="badge iq-bg-success">ولادة</span>';
            case 'marriages':
                return '<span class="badge iq-bg-dark">زواج</span>';
            case 'deaths':
                return '<span class="badge iq-bg-warning">الوفيات</span>';
            default:
                return $this->type;
        }
    }

    public function getByType($type)
    {
        return $this::where('type', $type)->get();
    }

    public function typeRef()
    {
        switch ($this->type) {
            case 'event':
                return $this->events;
            case 'news':
                return $this->news;
            case 'media':
                return $this->media;
            default:
                return null;
        }
    }

    // relations
    public function events()
    {
        return $this->hasMany('App\Models\Event', 'category_id', 'id');
    }

    public function news()
    {
        return $this->hasMany('App\Models\News', 'category_id', 'id');
    }

    public function media()
    {
        return $this->hasMany('App\Models\Media', 'category_id', 'id');
    }

}
