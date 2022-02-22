<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
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
        $appMenu = config('custom.app_menu');
        $menuTitle = 'المعرض';
        $pageTitle = 'لوحة التحكم';
        $media = Media::paginate(20);
        $categories = Category::all();

        return view('dashboard.media.index', compact('appMenu', 'menuTitle', 'pageTitle', 'media', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMediaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMediaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function show($category_id)
    {
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';
        $category = Category::findOrFail($category_id);
        $menuTitle = $category->name_ar;
        if($category_id == 0){
            $media = Media::all();
        }
        else{
            $media = Media::where('category_id', $category_id)->get();
        }

        return view('dashboard.media.show', compact('appMenu', 'menuTitle', 'menuTitle', 'pageTitle', 'media'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Media  $media
     * @return \Illuminate\Http\Response
     */
    public function edit(Media $media)
    {
        //
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
        //
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
        return redirect()->route('admin.media.index')->with('success', 'تم حذف بيانات الصور بنجاح.');
    }

}
