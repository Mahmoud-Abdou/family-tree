<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeathRequest;
use App\Http\Requests\UpdateDeathRequest;
use App\Models\Death;
use App\Models\City;
use App\Models\Person;
use App\Models\Media;
use App\Models\Category;
use App\Models\Family;
use App\Models\News;
use App\Models\User;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;
use App\Events\DeathEvent;
use App\Events\NotificationEvent;

use Illuminate\Http\Request;
use Pricecurrent\LaravelEloquentFilters\EloquentFilters;

class DeathController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:deaths.read')->only(['index', 'show']);
        $this->middleware('permission:deaths.create')->only(['create', 'store']);
        $this->middleware('permission:deaths.update')->only(['edit', 'update']);
        $this->middleware('permission:deaths.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';
        $menuTitle = 'الوفيات';

        $page_limit = 20;
        $deaths = new Death;
        $filters_data = isset($request['filters']) ? $request['filters'] : [];

        $filters_array = $deaths->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $deaths = $deaths->filter($filters);
        $deaths = $deaths->paginate($page_limit);

        return view('dashboard.deaths.index', compact('appMenu', 'menuTitle', 'pageTitle', 'deaths'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('admin.deaths.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDeathRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeathRequest $request)
    {
        return redirect()->route('admin.deaths.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Death  $death
     * @return \Illuminate\Http\Response
     */
    public function show($death_id)
    {
        return redirect()->route('admin.deaths.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Death  $death
     * @return \Illuminate\Http\Response
     */
    public function edit(Death $death)
    {
        $menuTitle = 'تعديل حالة وفاة';
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';

        return view('dashboard.deaths.update', compact('appMenu', 'menuTitle', 'pageTitle', 'death'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDeathRequest  $request
     * @param  \App\Models\Death  $death
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeathRequest $request, Death $death)
    {
        $death->title = $request->title;
        $death->body = $request->body;
        $death->date = Carbon::parse($request['date']);

        if($request->hasFile('image')){
            $new_media = new Media;
            $new_media = $new_media->EditUploadedMedia($request->file('image'), $death->image_id);
            if($new_media == null){
                return redirect()->route('admin.deaths.index')->with('error', 'حدث خطا');
            }
        }

        if ($death->isDirty()){
            $death->save();

            \App\Helpers\AppHelper::AddLog('Death Update', class_basename($death), $death->id);
            return redirect()->route('admin.deaths.index')->with('success', 'تم تعديل بيانات وفاة بنجاح.');
        }

        return redirect()->route('admin.deaths.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Death  $death
     * @return \Illuminate\Http\Response
     */
    public function destroy(Death $death)
    {
        if(isset($death->image)){
            $death->image->DeleteFile($death->image);
            $death->image->delete();
        }
        $death->delete();

        \App\Helpers\AppHelper::AddLog('Death Delete', class_basename($death), $death->id);
        return redirect()->back()->with('success', 'تم حذف بيانات وفاة بنجاح.');
    }


}
