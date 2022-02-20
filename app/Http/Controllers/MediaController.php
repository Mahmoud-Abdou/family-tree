<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Models\Media;
use App\Models\Category;

use Exception;

class MediaController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:media.read')->only(['index', 'show']);
        $this->middleware('permission:media.create')->only(['create', 'store']);
        $this->middleware('permission:media.update')->only(['edit', 'update']);
        $this->middleware('permission:media.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appMenu = config('custom.main_menu');
        $menuTitle = 'المعرض';
        $pageTitle = 'لوحة التحكم';
        $media = Media::where('owner_id', auth()->user()->id)->paginate(20);
        $categories = Category::all();

        return view('web_app.Media.index', compact('menuTitle', 'pageTitle', 'media', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuTitle = 'اضافة صورة';
        $pageTitle = 'القائمة الرئيسية';

        return view('web_app.Media.create', compact('menuTitle', 'pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMediaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMediaRequest $request)
    {
        $request['owner_id'] = auth()->user()->id;
        $media = new Media;
        $media = $media->UploadMedia($request->file('file'), $request['category_id'], $request['owner_id']);
        if($media == null){
            return redirect()->route('media.index')->with('error', 'حدث خطا');
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
    public function show($category_id)
    {
        $category = Category::findOrFail($category_id);
        $menuTitle = $category->name_ar;
        $pageTitle = 'القائمة الرئيسية';
        if($category_id == 0){
            $media = Media::all();
        }
        else{
            $media = Media::where('category_id', $category_id)->get();
        }

        return view('web_app.Media.show', compact('menuTitle', 'pageTitle', 'media'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        $menuTitle = 'تعديل الصور';
        $pageTitle = 'القائمة الرئيسية';

        return view('web_app.Media.update', compact('menuTitle', 'pageTitle', 'media'));
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
        if($request->hasFile('file')){
            $request['owner_id'] = auth()->user()->id;

            $new_media = new Media;
            $new_media = $new_media->UploadMedia($request->file('file'), $request['category_id'], $request['owner_id']);
            if($new_media == null){
                return redirect()->route('media.index')->with('error', 'حدث خطا');
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


    public function get_media($category_id)
    {
        if($category_id == null || $category_id == 1){
            $media = Media::with('category')->get();
        }
        else{
            $media = Media::with('category')->where('category_id', $category_id)->get();
        }
        return response()->json($media, 200);
    }

    public function media_category()
    {
        return null;
    }

}
