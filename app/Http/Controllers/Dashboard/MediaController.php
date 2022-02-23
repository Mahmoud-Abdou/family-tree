<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Requests\UpdateMediaRequest;
use App\Models\Media;
use App\Models\Category;

use Pricecurrent\LaravelEloquentFilters\EloquentFilters;
use Illuminate\Http\Request;
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
    public function index(Request $request)
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'المعرض';
        $pageTitle = 'لوحة التحكم';
        $page_limit = 20;
        $media = new Media;
        $filters_data = isset($request['filters']) ? $request['filters'] : [];

        $filters_array = $media->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $media = $media->filter($filters);

        $media = $media->orderBy('created_at', 'DESC')
                ->paginate($page_limit);

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
    public function destroy($media_id)
    {
        $media = Media::where('id', $media_id)->first();
        $media->DeleteFile($media);
        $media->delete();
        \App\Helpers\AppHelper::AddLog('Media Delete', class_basename($media), $media->id);
        return redirect()->route('admin.media.index')->with('success', 'تم حذف بيانات الصور بنجاح.');
    }

}
