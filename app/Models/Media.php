<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Filters\TextFilter;
use App\Filters\IDFilter;
//use App\Filters\BetweenFilter;
//use App\Filters\InFilter;
use Pricecurrent\LaravelEloquentFilters\Filterable;
use App\Filters\OwnerFilter;
use App\Filters\DateFilter;
use App\Filters\OwnerRelativesFilter;

class Media extends Model
{
    use Filterable, hasImage;

    public $filePath = '/uploads/media/';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id',
        'title',
        'file',
        'category_id'
    ];

    public function getFileAttribute($file)
    {
        return secure_asset($this->filePath). '/' . $file;
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function UploadMedia($file, $category_id, $owner_id, $title = 'Title')
    {
        try{
            $media_data['title'] = $title;
            $media_data['owner_id'] = $owner_id;
            $media_data['category_id'] = $category_id;
            $image = $this->ImageUpload($file, (new Media)->filePath);
            $media_data['file'] = $image;
            $media = Media::create($media_data);
            return $media;
        }
        catch(Exception $ex){
            return null;
        }
    }

    public function EditUploadedMedia($file, $media_id)
    {
        try{
            $media = Media::where('id', $media_id)->first();
            if($media == null){
                return null;
            }
            $image = $this->ImageUpload($file, $this->filePath);
            $name = explode('/', $media->file);
            $name = $this->filePath . $name[sizeof($name) - 1];
            $name = substr($name, 1);

            if (file_exists($name)) {
                unlink($name);
            }
            $media->file = $image;
            $media->save();
            return $media;
        }
        catch(Exception $ex){
            return null;
        }
    }

    public function DeleteFile($file)
    {
        try{
            $name = explode('/', $file->file);
            $name = $this->filePath . $name[sizeof($name) - 1];
            $name = substr($name, 1);
            if (file_exists($name)){
                return unlink($name);
            }
        }catch(Exception $ex){
            return null;
        }
        return null;
    }

    public function ImageUpload($query, $path, $name = null)
    {
        $ext = strtolower($query->getClientOriginalExtension());

        if (isset($name)) {
            $image_full_name = $name.'.'.$ext;
        } else {
            $image_full_name = Str::random(20).'.'.$ext;
        }

        if (file_exists(public_path($path) . $image_full_name)) {
            unlink(public_path($path) . $image_full_name);
        }

//        $image_url = public_path($path) . $image_full_name;
        $query->move(public_path($path), $image_full_name);

        return $image_full_name;
    }

    public function filters($request_filter)
    {
        $filters = [];
        if(isset($request_filter['title'])){
            $filters[] = new TextFilter($request_filter['title'], 'title');
        }
        if(isset($request_filter['category'])){
            $filters[] = new IDFilter($request_filter['category'], 'category_id');
        }

        if(isset($request_filter['owner_name'])){
            $filters[] = new OwnerFilter($request_filter['owner_name'], 'name');
        }
        if(isset($request_filter['owner_phone'])){
            $filters[] = new OwnerFilter($request_filter['owner_phone'], 'mobile');
        }
        if(isset($request_filter['owner_email'])){
            $filters[] = new OwnerFilter($request_filter['owner_email'], 'email');
        }
        if(isset($request_filter['date'])){
            $filters[] = new DateFilter($request_filter['date'], 'created_at');
        }
        if(isset($request_filter['relatives'])){
            if(isset(auth()->user()->profile->belongsToFamily)){
                $relatives_famiy_id = auth()->user()->profile->belongsToFamily->gf_family_id;
                $filters[] = new OwnerRelativesFilter($relatives_famiy_id, 'gf_family_id');
            }
        }

        return $filters;
    }

}
