<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as crop;

class ImageHelper{

    public static function save($file, $path){
        $defaultImage="default.jpg";
        // rename image name or file name
        $extension = $file->getClientOriginalExtension();
        $getImageName = 'Image' . rand(11111, 99999) . time() . '.' . $extension;
        //$file->move($path, $getImageName);
        if($file->move($path, $getImageName))
            return $getImageName;
        else 
            return $defaultImage;
    }

    public static function delete($file,$path)
    {
      return File::delete(public_path("/" . $path . $file));
    }

    public static function copy($from_path,$file,$to_path)
    {

            $getImageName = 'Image' . rand(11111, 99999) . time() . '.png' ;
            File::copy(public_path()."/".$from_path.$file,public_path()."/".$to_path.$getImageName);
            return $getImageName;
    }

    public static function save_base64($image,$path){
            $arr=explode(';base64,', $image);
            if(isset($arr[1])){
                $image=$arr[1];
                $image = str_replace(' ', '+', $image);
                $data2 = base64_decode($image);
                $profile_name = 'baddelni' . rand(11111, 99999) . time() . '.png';
                $success = file_put_contents($path.$profile_name, $data2);
                return $profile_name;
            }
            return 0;
    }

    public static function upload($file, $path)
    {
//        $directoryPath = public_path('upload/'); // upload path
        $directoryPath = public_path($path); // upload path
        $extension = $file->getClientOriginalExtension();
        $imageName = uniqid('Image', '-') . $extension;
        $img = $file->move($directoryPath, $imageName);

//        $img->save(public_path($directoryPath . '/large/' . $imageName));
//
//        $width = $img->width();
//        $height = $img->height();
//
//        $thumb_size = 400;
//
//        if ($width > $thumb_size || $height > $thumb_size) {
//            if ($width > $height) {
//                //$new_size=image_thumb($width,$height,$thumb_size);
//                $img->resize($thumb_size, (($height * $thumb_size) / $width));
//                $img->save(public_path($directoryPath . '/thumb/' . $imageName));
//
//            } else if ($width < $height) {
//                //$new_size=image_thumb($height,$width,$thumb_size);
//                $img->resize((($width * $thumb_size) / $height), $thumb_size);
//                $img->save(public_path($directoryPath . '/thumb/' . $imageName));
//
//            } else {
//                $img->resize($thumb_size, $thumb_size);
//                $img->save(public_path($directoryPath . '/thumb/' . $imageName));
//
//            }
//        } else {
//            $img->save(public_path($directoryPath . '/thumb/' . $imageName));
//
//        }
        return public_path($directoryPath . '/large/' . $imageName);
    }

    public static function createSvg($name, $path = null)
    {
        // use svg image -----
//        $this->attributes['avatar'] = strtoupper(Str::slug($this->first_name)[0].Str::slug($this->last_name)[0]);

        // use png image -----
//        $url = 'https://k-server.epizy.com/api/?name='.Str::slug($this->first_name).'+'.Str::slug($this->last_name).'&size=128&background=0D8ABC&color=fff&font-size=0.5&bold=true&uppercase=true&rounded=true&format=png';
//        $imgNmae = Str::slug($this->first_name).'_'.time();
//        file_put_contents($this->uploadDirectory . $imgNmae, file_get_contents($url));
//        $this->attributes['avatar'] = $imgNmae.'.png';

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="128px" height="128px" viewBox="0 0 128 128" version="1.1">
            <defs>
                <filter id="f1" x="0" y="0" width="200%" height="200%">
                    <feOffset result="offOut" in="SourceAlpha" dx="5" dy="5" />
                    <feGaussianBlur result="blurOut" in="offOut" stdDeviation="8" />
                    <feBlend in="SourceGraphic" in2="blurOut" mode="normal" />
                </filter>
            </defs>
            <circle fill="#0D8ABf" cx="64" cy="64" r="62"  stroke="gray" stroke-width="3" />
            <text x="50%" y="50%" style="color: #fff; line-height: 1;font-family: -apple-system, BlinkMacSystemFont, Droid Sans;" alignment-baseline="middle" text-anchor="middle" font-size="64" font-weight="600" dy=".1em" dominant-baseline="middle" fill="#fff" filter="url(#f1)">
                '.$name.'
            </text>
        </svg>';

        return $svg;
    }

}