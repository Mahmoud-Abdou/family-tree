<?php

namespace App\Models;

use App\Traits\HasImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


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
        return asset($this->filePath). '/' . $file;
    }

    public function owner()
    {
        return $this->belongsTo('App\Models\User', 'owner_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }

    public function UploadMedia($file, $category_id, $owner_id)
    {
        try{
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
            $image = $this->ImageUpload($file, $this->filePath);
            $media = Media::where('id', $media_id)->first();
            if($media == null){
                return null;
            }
            $name = explode('/', $media->file);
            $name = $this->filePath . $name[sizeof($name) - 1]; 
            $name = substr($name, 1);

            unlink($name);
            $media->file = $image;
            $media->save();
            return $media;
        }
        catch(Exception $ex){
            return null;
        }
    }
    public function delete_file($file)
    {
        try{
            $name = explode('/', $file->file);
            $name = $this->filePath . $name[sizeof($name) - 1]; 
            $name = substr($name, 1);
            return unlink($name);
        }catch(Exception $ex){
            return null;
        }
    }

    public function ImageUpload($query, $path, $name = null)
    {
        $ext = strtolower($query->getClientOriginalExtension()); // You can use also getClientOriginalName()

        if (isset($name)) {
            $image_full_name = $name.'.'.$ext;
        } else {
            $image_full_name = Str::random(20).'.'.$ext;
        }

        if (file_exists(public_path($path) . $image_full_name)) {
            unlink(public_path($path) . $image_full_name);
        }

        $image_url = public_path($path) . $image_full_name;
        $query->move(public_path($path), $image_full_name);

        return $image_full_name;
    }
}
