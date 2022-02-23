<?php

namespace App\Http\Controllers;

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
        $menuTitle = 'الوفيات';
        $pageTitle = 'القائمة الرئيسية';
        $page_limit = 15;
        $deaths = new Death;
        $filters_data = isset($request['filters']) ? $request['filters'] : [];

        $filters_array = $deaths->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $deaths = $deaths->filter($filters);
        $deaths = $deaths->paginate($page_limit);

        return view('web_app.Deaths.index', compact('menuTitle', 'pageTitle', 'deaths'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuTitle = 'اضافة حالة وفاة';
        $pageTitle = 'القائمة الرئيسية';
        $family_id = auth()->user()->profile->family_id;
        $persons = Person::where('family_id', $family_id)->where('is_live', 1)->get();

        return view('web_app.Deaths.create', compact('menuTitle', 'pageTitle', 'persons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDeathRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeathRequest $request)
    {
        try{
            $request['owner_id'] = auth()->id();
            $request['date'] = Carbon::parse($request['date']);
            $request['family_id'] = auth()->user()->profile->belongsToFamily->id;

            $category_id = Category::where('type', 'deaths')->first();
            $media = new Media;

            if($request->hasFile('image')){
                $media = $media->UploadMedia($request->file('image'), $category_id->id, auth()->id(), $request['title']);
                $request['image_id'] = $media->id;
            }
            else{
                $request['image_id'] = null;
            }


            $person = Person::where('id', $request['person_id'])->first();
            if($person != null){
                $person->is_live = 0;
                $person->save();

                $request['person_id'] = $person->id;
            }

            $death = Death::create($request->all());

            $request['city_id'] = 1;
            $request['category_id'] = $category_id->id;
            $request['approved'] = 0;
            $news = News::create($request->all());

            $death_notification = [];
            $death_notification['title'] = 'تم اضافة متوفي';
            $death_notification['body'] = $death->notification_body;
            $death_notification['content'] = $death;
            $death_notification['url'] = 'deaths/' . $death->id;
            $death_notification['operation'] = 'store';

            $users = User::where('status', 'active')->get();
            event(new NotificationEvent($death_notification, $users));

            \App\Helpers\AppHelper::AddLog('Death Create', class_basename($death), $death->id);
            return redirect()->route('deaths.index')->with('success', 'تم اضافة وفاة جديدة .');
        }catch(Exception $ex){
            return redirect()->route('deaths.index')->with('error', 'حدثت مشكلة');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Death  $death
     * @return \Illuminate\Http\Response
     */
    public function show($death_id)
    {
        $menuTitle = 'عرض المتوفي';
        $pageTitle = 'القائمة الرئيسية';
        $death = Death::where('id', $death_id)->first();
        $death['type'] = 'deaths';
        $lastDeaths = Death::latest()->take(5)->get();

        return view('web_app.Deaths.show', compact('menuTitle', 'pageTitle', 'death', 'lastDeaths'));
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
        $pageTitle = 'القائمة الرئيسية';

        return view('web_app.Deaths.update', compact('menuTitle', 'pageTitle', 'death'));
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
        if(auth()->id() != $death->owner_id){
            return redirect()->route('deaths.index')->with('error', 'لا يمكنك التعديل');
        }
        $death->title = $request->title;
        $death->body = $request->body;
        $death->date = Carbon::parse($request['date']);

        if($request->hasFile('image')){
            $new_media = new Media;
            $new_media = $new_media->EditUploadedMedia($request->file('image'), $death->image_id);
            if($new_media == null){
                return redirect()->route('deaths.index')->with('error', 'حدث خطا');
            }
        }

        if ($death->isDirty()){
            $death->save();

            \App\Helpers\AppHelper::AddLog('Death Update', class_basename($death), $death->id);
            return redirect()->route('deaths.index')->with('success', 'تم تعديل بيانات وفاة بنجاح.');
        }

        return redirect()->route('deaths.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Death  $death
     * @return \Illuminate\Http\Response
     */
    public function destroy(Death $death)
    {
        if(auth()->id() != $death->owner_id){
            return redirect()->route('deaths.index')->with('error', 'لا يمكنك التعديل');
        }
        $death->image->DeleteFile($death->image);
        $death->image->delete();
        $death->delete();

        \App\Helpers\AppHelper::AddLog('Death Delete', class_basename($death), $death->id);
        return redirect()->route('deaths.index')->with('success', 'تم حذف بيانات وفاة بنجاح.');
    }
}
