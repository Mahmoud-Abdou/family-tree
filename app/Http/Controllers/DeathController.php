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
    public function index()
    {
        $id = auth()->user()->id;
        $menuTitle = 'الوفيات';
        $pageTitle = 'القائمة الرئيسية';
        $page_limit = 20;
        $deaths = Death::paginate($page_limit);
        $death = Death::first();
        $death_notification = [];
            $death_notification['title'] = 'تم اضافة متوفي';
            $death_notification['body'] = $death->body;
            $death_notification['content'] = $death;
            $death_notification['url'] = 'deaths/' . $death->id;
            $death_notification['operation'] = 'store';
    
            $users = User::where('id', 2)->get();
            event(new NotificationEvent($death_notification, $users));

        return view('web_app.Deaths.index', compact('menuTitle', 'pageTitle', 'deaths'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuTitle = 'اضافة الوفيات';
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
            $request['owner_id'] = auth()->user()->id;
            $request['date'] = Carbon::parse($request['date']);
            $request['family_id'] = auth()->user()->profile->belongsToFamily->id;

            $category_id = Category::where('type', 'deaths')->first();
            $media = new Media;

            if($request->hasFile('image')){
                $media = $media->UploadMedia($request->file('image'), $category_id->id, auth()->user()->id);
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
            $death_notification['body'] = $death->body;
            $death_notification['content'] = $death;
            $death_notification['url'] = 'deaths/' . $death->id;
            $death_notification['operation'] = 'store';
    
            $users = User::where('status', 'active')->get();
            event(new NotificationEvent($death_notification, $users));

            \App\Helpers\AppHelper::AddLog('Death Create', class_basename($death), $death->id);
            return redirect()->route('deaths.index')->with('success', 'تم اضافة وفاة جديدة .');
        }catch(Exception $ex){
            return redirect()->route('deaths.index')->with('danger', 'حدثت مشكلة');
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
        $appMenu = config('custom.main_menu');
        $menuTitle = '  اظهار المتوفي';
        $pageTitle = 'لوحة التحكم';        
        $death = Death::where('id', $death_id)->first();
        
        return view('web_app.Deaths.show', compact('appMenu', 'menuTitle', 'pageTitle', 'death'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Death  $death
     * @return \Illuminate\Http\Response
     */
    public function edit(Death $death)
    {
        $menuTitle = ' تعديل الوفيات ';
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
        if(auth()->user()->id != $death->owner_id){
            return redirect()->route('deaths.index')->with('danger', 'لا يمكنك التعديل');
        }
        $death->title = $request->title;
        $death->body = $request->body;
        $death->date = Carbon::parse($request['date']);

        if($request->hasFile('image')){
            $new_media = new Media;
            $new_media = $new_media->EditUploadedMedia($request->file('image'), $death->image_id);
            if($new_media == null){
                return redirect()->route('deaths.index')->with('danger', 'حدث خطا');
            }
        }

        $death->save();

        \App\Helpers\AppHelper::AddLog('Death Update', class_basename($death), $death->id);
        return redirect()->route('deaths.index')->with('success', 'تم تعديل بيانات وفاة بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Death  $death
     * @return \Illuminate\Http\Response
     */
    public function destroy(Death $death)
    {
        if(auth()->user()->id != $death->owner_id){
            return redirect()->route('deaths.index')->with('danger', 'لا يمكنك التعديل');
        }
        $death->image->delete_file($death->image);
        $death->image->delete();
        $death->delete();

        \App\Helpers\AppHelper::AddLog('Death Delete', class_basename($death), $death->id);
        return redirect()->route('deaths.index')->with('success', 'تم حذف بيانات وفاة بنجاح.');
    }


}
