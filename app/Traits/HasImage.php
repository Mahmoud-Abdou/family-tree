<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasImage
{
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
//        return $image_url;
    }

    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);
        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
        return $file;
    }

}
