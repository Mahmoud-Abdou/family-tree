<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreNewbornRequest;
use App\Http\Requests\UpdateNewbornRequest;
use App\Models\Newborn;
use App\Models\Family;
use App\Models\Category;
use App\Models\Media;
use App\Models\News;
use App\Models\Person;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Pricecurrent\LaravelEloquentFilters\EloquentFilters;

class NewbornController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:newborns.read')->only(['index', 'show']);
        $this->middleware('permission:newborns.create')->only(['create', 'store']);
        $this->middleware('permission:newborns.update')->only(['edit', 'update']);
        $this->middleware('permission:newborns.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menuTitle = 'المواليد';
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';
        $page_limit = 20;
        $newborns = new Newborn;
        $filters_data = isset($request['filters']) ? $request['filters'] : [];

        $filters_array = $newborns->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $newborns = $newborns->filter($filters);
        $newborns = $newborns->paginate($page_limit);

        return view('dashboard.newborns.index', compact('appMenu', 'menuTitle', 'pageTitle', 'newborns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('admin.newborns.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNewbornRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewbornRequest $request)
    {
        return redirect()->route('admin.newborns.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function show($newborn_id)
    {
        return redirect()->route('admin.newborns.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function edit(Newborn $newborn)
    {
        $menuTitle = 'تعديل مولود';
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';

        return view('dashboard.newborns.update', compact('appMenu', 'menuTitle', 'pageTitle', 'newborn'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateNewbornRequest  $request
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewbornRequest $request, Newborn $newborn)
    {
        $newborn->title = $request->title;
        $newborn->body = $request->body;
        $newborn->date = Carbon::parse($request['date']);

        if($request->hasFile('image')){
            $new_media = new Media;
            $new_media = $new_media->EditUploadedMedia($request->file('image'), $newborn->image_id);
            if($new_media == null){
                return redirect()->route('admin.newborns.index')->with('error', 'حدث خطا');
            }
        }

        $newborn->save();
        \App\Helpers\AppHelper::AddLog('Newborn Update', class_basename($newborn), $newborn->id);
        return redirect()->route('admin.newborns.index')->with('success', 'تم تعديل بيانات مولود بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newborn $newborn)
    {

        if(isset($newborn->image)){
            $newborn->image->DeleteFile($newborn->image);
            $newborn->image->delete();
        }
        if(isset($newborn->person)){
            $newborn->person->delete();
        }
        $newborn->delete();

        \App\Helpers\AppHelper::AddLog('Newborn Delete', class_basename($newborn), $newborn->id);
        return redirect()->route('admin.newborns.index')->with('success', 'تم حذف بيانات مولود بنجاح.');
    }
}
