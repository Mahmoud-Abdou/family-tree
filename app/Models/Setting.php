<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'app_title_ar',
        'app_title_en',
        'app_description_ar',
        'app_description_en',
        'app_about_ar',
        'app_about_en',
        'app_contact_ar',
        'app_contact_en',
        'app_terms_ar',
        'app_terms_en',
        'app_logo',
        'app_icon',
        'family_tree_image',
        'family_name_ar',
        'family_name_en',
        'app_registration',
    ];

}
