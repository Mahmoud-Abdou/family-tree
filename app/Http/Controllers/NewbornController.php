<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewbornRequest;
use App\Http\Requests\UpdateNewbornRequest;
use App\Models\Newborn;
use App\Models\Family;
use App\Models\Category;
use App\Models\Media;
use App\Models\News;
use App\Models\Person;
use Carbon\Carbon;
use App\Models\User;
use App\Events\NotificationEvent;


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
        $pageTitle = 'القائمة الرئيسية';
        $page_limit = 15;
        $newborns = new Newborn;

        $filters_data = isset($request['filters']) ? $request['filters'] : [];

        $filters_array = $newborns->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $newborns = $newborns->filter($filters);
        $newborns = $newborns->paginate($page_limit);

        return view('web_app.newborns.index', compact('menuTitle', 'pageTitle', 'newborns'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuTitle = 'اضافة مولود';
        $pageTitle = 'القائمة الرئيسية';

        if(auth()->user()->profile->gender == 'male'){
            $wives = auth()->user()->profile->wives;
        }
        else{
            $wives = [auth()->user()->profile];
        }

        return view('web_app.newborns.create', compact('menuTitle', 'pageTitle', 'wives'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreNewbornRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewbornRequest $request)
    {
        $request['owner_id'] = auth()->id();
//        $request['date'] = Carbon::parse($request['date']);

        if(!isset(auth()->user()->profile)){
            return redirect()->back()->with('error', 'حدث خطا');
        }
        if(!auth()->user()->profile->has_family){
            return redirect()->back()->with('error', 'لا يمكنك اضافة مولود لانك غير متزوج ');
        }
        // TODO: related to father family id.
        // if (auth()->user()->profile->has_family && isset(auth()->user()->profile->ownFamily[0])) {
        //     $request['family_id'] = auth()->user()->profile->ownFamily[0]->id;
        // } else {
        //     $request['family_id'] = auth()->user()->profile->belongsToFamily->id;
        // }

        $request['family_id'] = Family::where('mother_id', $request['wife_id'])->first();
        if($request['family_id'] == null){
            return redirect()->back()->with('error', 'حدث خطا');
        }
        $request['family_id'] = $request['family_id']->id;

        if ($request->hasFile('image')) {
            $media = new Media;
            $category_id = Category::where('type', 'newborn')->first();
            $media = $media->UploadMedia($request->file('image'), $category_id->id, auth()->id(), $request->title);
            $request['image_id'] = $media->id;
        }

        //        $news = News::create($request->all());

        if(auth()->user()->profile->gender == 'male'){
            $request['father_name'] = auth()->user()->profile->first_name;
        }
        else{
            $request['father_name'] = auth()->user()->husband->first_name;
        }

        $person = [];
        $person['user_id'] = 1;
        $person['first_name'] = $request['first_name'];
        $person['father_name'] = $request['father_name'];
        $person['family_id'] = $request['family_id'];
        $person['gender'] = $request['gender'];
        $person = Person::create($person);

        $request['person_id'] = $person->id;

        $newborn = Newborn::create($request->all());

        $newborn_notification = [];
        $newborn_notification['title'] = 'تم اضافة مولود';
        $newborn_notification['body'] = $newborn->notification_body;
        $newborn_notification['content'] = $newborn;
        $newborn_notification['url'] = 'newborns/' . $newborn->id;
        $newborn_notification['operation'] = 'store';

        $users = User::where('status', 'active')->get();
        event(new NotificationEvent($newborn_notification, $users));

        \App\Helpers\AppHelper::AddLog('Newborn Create', class_basename($newborn), $newborn->id);
        return redirect()->route('newborns.index')->with('success', 'تم اضافة مولود جديدة .');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function show($newborn_id)
    {
        $newborn = Newborn::where('id', $newborn_id)->first();
        if (!isset($newborn)) {
            return back();
        }
        $menuTitle = $newborn->title;
        $pageTitle = 'القائمة الرئيسية';
        $lastNewborn = Newborn::latest()->take(5)->get();

        return view('web_app.newborns.show', compact('menuTitle', 'pageTitle', 'newborn', 'lastNewborn'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function edit(Newborn $newborn)
    {
        if (!isset($newborn)) {
            return back();
        }
        $menuTitle = ' تعديل مولود ' . $newborn->title;
        $pageTitle = 'القائمة الرئيسية';

        return view('web_app.newborns.update', compact('menuTitle', 'pageTitle', 'newborn'));
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
        if(auth()->id() != $newborn->owner_id){
            return redirect()->route('newborns.index')->with('error', 'لا يمكنك التعديل');
        }
        $newborn->title = $request->title;
        $newborn->body = $request->body;
        $newborn->date = Carbon::parse($request['date']);

        if($request->hasFile('image')){
            $media = new Media;
            $new_media = $media->EditUploadedMedia($request->file('image'), $newborn->image_id);
            if($new_media == null){
                $category_id = Category::where('type', 'newborn')->first();
                $new_media = $media->UploadMedia($request->file('image'), $category_id->id, auth()->id(), $newborn->title);
                if($new_media == null){
                    return redirect()->route('newborns.index')->with('error', 'حدث خطا');
                }
                $request['image_id'] = $new_media->id;
            }
        }

        if ($newborn->isDirty()) {
            $newborn->save();

            \App\Helpers\AppHelper::AddLog('Newborn Update', class_basename($newborn), $newborn->id);
            return redirect()->route('newborns.index')->with('success', 'تم تعديل بيانات مولود بنجاح.');
        }

        return redirect()->route('newborns.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newborn $newborn)
    {
        if(auth()->id() != $newborn->owner_id){
            return redirect()->route('newborns.index')->with('error', 'لا يمكنك التعديل');
        }
        $newborn->image->DeleteFile($newborn->image);
        $newborn->image->delete();
        $newborn->person->delete();
        $newborn->delete();

        \App\Helpers\AppHelper::AddLog('Newborn Delete', class_basename($newborn), $newborn->id);
        return redirect()->route('newborns.index')->with('success', 'تم حذف بيانات مولود بنجاح.');
    }
}
