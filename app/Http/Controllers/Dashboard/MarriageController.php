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
        $id = auth()->user()->id;
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
        $menuTitle = 'اضافة زواجة';
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';

        $family_id = auth()->user()->profile->family_id;
        $male = Person::where('family_id', $family_id)
                        ->where('has_family', 0)
                        ->where('is_live', 1)
                        ->where('gender', 'male')
                        ->get();

        $female = Person::where('is_live', 1)
                        ->where('gender', 'female')
                        ->get();

        return view('dashboard.marriages.create', compact('appMenu', 'menuTitle', 'pageTitle', 'male', 'female'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMarriageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMarriageRequest $request)
    {
        try{
            $request['owner_id'] = auth()->user()->id;
            $request['family_id'] = auth()->user()->profile->belongsToFamily->id;
            $request['date'] = Carbon::parse($request['date']);

            $category_id = Category::where('type', 'marriages')->first();
            $media = new Media;

            if($request->hasFile('image')){
                $media = $media->UploadMedia($request->file('image'), $category_id->id, auth()->user()->id, $request['title']);
                $request['image_id'] = $media->id;
            }
            else{
                $request['image_id'] = null;
            }

            $father = Person::where('id', $request['husband_id'])->first();

            $new_family = [];
            $new_family['name'] = 'عائلة ' . $father->first_name;
            $new_family['father_id'] = $request['husband_id'];
            $new_family['mother_id'] = $request['wife_id'];
            $new_family['children_count'] = 0;
            $new_family['gf_family_id'] = $request['family_id'];
            $new_family['status'] = 1;
            $new_family = Family::create($new_family);

            $marriage = Marriage::create($request->all());
            
            $request['city_id'] = 1;
            $request['category_id'] = $category_id->id;
            $request['approved'] = 0;
            $news = News::create($request->all());
    
            $marriage_notification = [];
            $marriage_notification['title'] = 'تم اضافة زواج';
            $marriage_notification['body'] = $marriage->body;
            $marriage_notification['content'] = $marriage;
            $marriage_notification['url'] = 'marriages/' . $marriage->id;
            $marriage_notification['operation'] = 'store';
    
            $users = User::where('status', 'active')->get();
            event(new NotificationEvent($marriage_notification, $users));

            \App\Helpers\AppHelper::AddLog('Marriage Create', class_basename($marriage), $marriage->id);
            return redirect()->route('marriages.index')->with('success', 'تم اضافة زواج جديد .');
        }catch(Exception $ex){
            return redirect()->route('marriages.index')->with('danger', 'حدثت مشكلة');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marriage  $marriage
     * @return \Illuminate\Http\Response
     */
    public function show($marriage_id)
    {
        $menuTitle = '  اظهار الزواج';
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';

        $marriage = Marriage::where('id', $marriage_id)->first();
        
        return view('dashboard.marriages.show', compact('appMenu', 'menuTitle', 'pageTitle', 'marriage'));
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
        if(auth()->user()->id != $marriage->owner_id){
            return redirect()->route('marriages.index')->with('danger', 'لا يمكنك التعديل');
        }
        $marriage->title = $request->title;
        $marriage->body = $request->body;
        $marriage->date = Carbon::parse($request['date']);

        if($request->hasFile('image')){
            $new_media = new Media;
            $new_media = $new_media->EditUploadedMedia($request->file('image'), $marriage->image_id);
            if($new_media == null){
                return redirect()->route('marriages.index')->with('danger', 'حدث خطا');
            }
        }

        if ($marriage->isDirty()){
            $marriage->save();

            \App\Helpers\AppHelper::AddLog('Marriage Update', class_basename($marriage), $marriage->id);
            return redirect()->route('marriages.index')->with('success', 'تم تعديل بيانات الزواج بنجاح.');
        }

        return redirect()->route('marriages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marriage  $marriage
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marriage $marriage)
    {
        if(auth()->user()->id != $marriage->owner_id){
            return redirect()->route('marriages.index')->with('danger', 'لا يمكنك التعديل');
        }
        $marriage->image->DeleteFile($marriage->image);
        $marriage->image->delete();
        $marriage->delete();

        \App\Helpers\AppHelper::AddLog('Marriage Delete', class_basename($marriage), $marriage->id);
        return redirect()->route('marriages.index')->with('success', 'تم حذف بيانات الزواج بنجاح.');
    }
}
