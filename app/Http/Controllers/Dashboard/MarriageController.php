<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMarriageRequest;
use App\Http\Requests\UpdateMarriageRequest;
use App\Models\Marriage;
use App\Models\Person;
use App\Models\Family;
use App\Models\Category;
use App\Models\Media;
use App\Models\News;
use App\Models\User;
use App\Events\NotificationEvent;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Pricecurrent\LaravelEloquentFilters\EloquentFilters;

class MarriageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:marriages.read')->only(['index', 'show']);
        $this->middleware('permission:marriages.create')->only(['create', 'store']);
        $this->middleware('permission:marriages.update')->only(['edit', 'update']);
        $this->middleware('permission:marriages.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = auth()->id();
        $menuTitle = 'الزواجات';
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';

        $page_limit = 20;
        $marriages = new Marriage;
        $filters_data = isset($request['filters']) ? $request['filters'] : [];

        $filters_array = $marriages->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $marriages = $marriages->filter($filters);
        $marriages = $marriages->paginate($page_limit);

        return view('dashboard.marriages.index', compact('appMenu', 'menuTitle', 'pageTitle', 'marriages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('admin.marriages.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMarriageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMarriageRequest $request)
    {
        return redirect()->route('admin.marriages.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marriage  $marriage
     * @return \Illuminate\Http\Response
     */
    public function show($marriage_id)
    {
        return redirect()->route('admin.marriages.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marriage  $marriage
     * @return \Illuminate\Http\Response
     */
    public function edit(Marriage $marriage)
    {
        $menuTitle = 'تعديل حالة زواج';
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';

        return view('dashboard.marriages.update', compact('appMenu', 'menuTitle', 'pageTitle', 'marriage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMarriageRequest  $request
     * @param  \App\Models\Marriage  $marriage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMarriageRequest $request, Marriage $marriage)
    {
        if(auth()->id() != $marriage->owner_id){
            return redirect()->route('admin.marriages.index')->with('error', 'لا يمكنك التعديل');
        }
        $marriage->title = $request->title;
        $marriage->body = $request->body;
        $marriage->date = Carbon::parse($request['date']);

        if($request->hasFile('image')){
            $new_media = new Media;
            $new_media = $new_media->EditUploadedMedia($request->file('image'), $marriage->image_id);
            if($new_media == null){
                return redirect()->route('admin.marriages.index')->with('error', 'حدث خطا');
            }
        }

        if ($marriage->isDirty()){
            $marriage->save();

            \App\Helpers\AppHelper::AddLog('Marriage Update', class_basename($marriage), $marriage->id);
            return redirect()->route('admin.marriages.index')->with('success', 'تم تعديل بيانات الزواج بنجاح.');
        }

        return redirect()->route('admin.marriages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marriage  $marriage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marriage $marriage)
    {
        if(isset($marriage->image)){
            $marriage->image->DeleteFile($marriage->image);
            $marriage->image->delete();
        }
        $marriage->delete();

        \App\Helpers\AppHelper::AddLog('Marriage Delete', class_basename($marriage), $marriage->id);
        return redirect()->route('admin.marriages.index')->with('success', 'تم حذف بيانات الزواج بنجاح.');
    }
}
