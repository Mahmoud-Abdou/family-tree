<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Models\Media;
use Exception;

class MediaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'الصور';
        $pageTitle = 'لوحة التحكم';
        $media = Media::paginate(20);

        return view('dashboard.media.index', compact('appMenu', 'menuTitle', 'pageTitle', 'media'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'اضافة صورة';
        $pageTitle = 'لوحة التحكم';

        return view('dashboard.media.create', compact('appMenu', 'menuTitle', 'pageTitle'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMediaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMediaRequest $request)
    {
        $request->validate([
            'file' => ['required'],
            'category_id' => ['required'],
        ]);
        $request['owner_id'] = auth()->user()->id;
        $media = new Media;
        $media = $media->UploadMedia($request->file('file'), $request['category_id'], $request['owner_id']);
        if($media == null){
            return redirect()->route('media.index')->with('danger', 'حدث خطا');
        }
        \App\Helpers\AppHelper::AddLog('Media Create', class_basename($media), $media->id);
        return redirect()->route('media.index')->with('success', 'تم اضافة صورة جديدة و يمكنك استخدامها.');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show(Media $media)
    {
        return redirect()->route('media.edit', $media);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'تعديل الصور';
        $pageTitle = 'لوحة التحكم';

        return view('dashboard.media.update', compact('appMenu', 'menuTitle', 'pageTitle', 'media'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMediaRequest  $request
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMediaRequest $request, Media $media)
    {
        $request->validate([
            'category_id' => ['required'],
        ]);
        if($request->hasFile('file')){
            $request['owner_id'] = auth()->user()->id;
            
            $new_media = new Media;
            $new_media = $new_media->UploadMedia($request->file('file'), $request['category_id'], $request['owner_id']);
            if($new_media == null){
                return redirect()->route('media.index')->with('danger', 'حدث خطا');
            }
            $media->file = $new_media->file;
        }
        $media->category_id = $request->category_id;
        $media->save();

        \App\Helpers\AppHelper::AddLog('Media Update', class_basename($media), $media->id);
        return redirect()->route('media.index')->with('success', 'تم تعديل بيانات الصور بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function destroy(Media $media)
    {
        $media->delete();
        \App\Helpers\AppHelper::AddLog('Media Delete', class_basename($media), $media->id);
        return redirect()->route('media.index')->with('success', 'تم حذف بيانات الصور بنجاح.');

    }


}
