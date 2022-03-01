<?php

namespace App\Http\Controllers;

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
//        $id = auth()->id();
        $menuTitle = 'الزواجات';
        $pageTitle = 'القائمة الرئيسية';
        $page_limit = 15;
        $marriages = new Marriage;
        $filters_data = isset($request['filters']) ? $request['filters'] : [];

        $filters_array = $marriages->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $marriages = $marriages->filter($filters);
        $marriages = $marriages->paginate($page_limit);

        return view('web_app.marriages.index', compact('menuTitle', 'pageTitle', 'marriages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuTitle = 'اضافة زواج';
        $pageTitle = 'القائمة الرئيسية';
        if(!isset(auth()->user()->profile)){
            return redirect()->back()->with('error', 'حدث خطا');
        }
        if(auth()->user()->profile->gender == 'female'){
            if(!isset(auth()->user()->profile->wifeOwnFamily)){
                return redirect()->back()->with('error', 'حدث خطا');
            }
            $husband_id = auth()->user()->profile->wifeOwnFamily->father_id;
        }
        else{
            $husband_id = auth()->user()->profile->id;
        }

        $family_ids = Family::where('father_id', $husband_id)->pluck('id');
        // dd($family_ids); 
        
        $family_id = auth()->user()->profile->family_id;
        $male = Person::where('family_id', $family_id)
//                        ->where('has_family', 0)
                        ->where('is_live', 1)
                        ->where('gender', 'male')
                        ->get();

        $female = Person::where('is_live', 1)
                        ->where('gender', 'female')
                        ->where('has_family', 0)
                        ->whereNotIn('family_id', $family_ids)
                        ->get();

        return view('web_app.marriages.create', compact('menuTitle', 'pageTitle', 'male', 'female'));
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
            $father = Person::where('id', $request['husband_id'])->first();
            if($request['wife_id'] == 'add'){
                $partner_person = User::where('email', $request['partner_email'])->orWhere('mobile', $request['partner_mobile'])->first();

                if ($partner_person == null) {
                    $partner_user = User::create([
                        'name' => $request->partner_first_name,
                        'email' => $request->partner_email,
                        'mobile' => $request->partner_mobile,
                        'password' => '123456789',
                        'accept_terms' => 1,
                        'status' => 'registered'
                    ]);

                    $wife = Person::create([
                        'user_id' => $partner_user->id,
                        'first_name' => $request->partner_first_name,
                        'father_name' => $request->partner_father_name,
                        'has_family' => 1,
                        'gender' => 'female' ,
                    ]);
                }
                else{
                    return redirect()->back()->with('error', 'هذالبريد موجود.');
                }
            }
            else{
                $wife = Person::where('id', $request['wife_id'])->first();
                if($wife == null){
                    return redirect()->back()->with('error', 'اختر زوجة.');
                }
            }

            $request['wife_id'] = $wife->id;

            $new_family = [];
            $new_family['name'] = 'عائلة ' . $father->first_name;
            $new_family['father_id'] = $father->id;
            $new_family['mother_id'] = $wife->id;
            $new_family['children_count'] = 0;
            $new_family['gf_family_id'] = isset(auth()->user()->profile->belongsToFamily) ? auth()->user()->profile->belongsToFamily->id : null;
            $new_family['status'] = 1;
            $new_family = Family::create($new_family);

            $father->has_family = 1;
            $wife->has_family = 1;
            $father->save();
            $wife->save();

            $request['owner_id'] = auth()->id();
            $request['family_id'] = $new_family->id;
            $request['date'] = Carbon::parse($request['date']);

            $category_id = Category::where('type', 'marriages')->first();
            $media = new Media;

            if($request->hasFile('image')){
                $media = $media->UploadMedia($request->file('image'), $category_id->id, auth()->id(), $request['title']);
                $request['image_id'] = $media->id;
            }
            else{
                $request['image_id'] = null;
            }

            $marriage = Marriage::create($request->all());

            $request['city_id'] = 1;
            $request['category_id'] = $category_id->id;
            $request['approved'] = 0;
            $news = News::create($request->all());

            $marriage_notification = [];
            $marriage_notification['title'] = 'تم اضافة زواج';
            $marriage_notification['body'] = $marriage->notification_body;
            $marriage_notification['content'] = $marriage;
            $marriage_notification['url'] = 'marriages/' . $marriage->id;
            $marriage_notification['operation'] = 'store';

            $users = User::where('status', 'active')->get();
            event(new NotificationEvent($marriage_notification, $users));

            \App\Helpers\AppHelper::AddLog('Marriage Create', class_basename($marriage), $marriage->id);
            return redirect()->route('marriages.index')->with('success', 'تم اضافة زواج جديد .');
        }catch(Exception $ex){
            return redirect()->route('marriages.index')->with('error', 'حدثت مشكلة');
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
        $marriage = Marriage::findOrFail($marriage_id);
        if (!isset($marriage)) {
            return back();
        }
        $menuTitle = $marriage->title;
        $pageTitle = 'القائمة الرئيسية';
        $lastMarriage = Marriage::latest()->take(5)->get();

        return view('web_app.marriages.show', compact('menuTitle', 'pageTitle', 'marriage', 'lastMarriage'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marriage  $marriage
     * @return \Illuminate\Http\Response
     */
    public function edit(Marriage $marriage)
    {
        if (!isset($marriage)) {
            return back();
        }
        $menuTitle = ' تعديل حالة زواج ' . $marriage->title;
        $pageTitle = 'القائمة الرئيسية';

        return view('web_app.marriages.update', compact('menuTitle', 'pageTitle', 'marriage'));
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
            return redirect()->route('marriages.index')->with('error', 'لا يمكنك التعديل');
        }
        $marriage->title = $request->title;
        $marriage->body = $request->body;
        $marriage->date = Carbon::parse($request['date']);

        if($request->hasFile('image')){
            $new_media = new Media;
            $new_media = $new_media->EditUploadedMedia($request->file('image'), $marriage->image_id);
            if($new_media == null){
                return redirect()->route('marriages.index')->with('error', 'حدث خطا');
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
        if(auth()->id() != $marriage->owner_id){
            return redirect()->route('marriages.index')->with('error', 'لا يمكنك الحذف');
        }
        $marriage->image->DeleteFile($marriage->image);
        $marriage->image->delete();
        $marriage->delete();

        \App\Helpers\AppHelper::AddLog('Marriage Delete', class_basename($marriage), $marriage->id);
        return redirect()->route('marriages.index')->with('success', 'تم حذف بيانات الزواج بنجاح.');
    }
}
