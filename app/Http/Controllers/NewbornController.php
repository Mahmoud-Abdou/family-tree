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
    public function index()
    {
//        $id = auth()->user()->id;
        $menuTitle = 'المواليد';
        $pageTitle = 'القائمة الرئيسية';
        $page_limit = 20;
        $newborns = Newborn::paginate($page_limit);

        return view('web_app.Newborns.index', compact('menuTitle', 'pageTitle', 'newborns'));
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

        return view('web_app.Newborns.create', compact('menuTitle', 'pageTitle'));
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
        $request['family_id'] = auth()->user()->profile->belongsToFamily->id;

        $media = new Media;
        $category_id = Category::where('type', 'newborn')->first();
        $media = $media->UploadMedia($request->file('image'), $category_id->id, auth()->id());
        $request['image_id'] = $media->id;


//        $request['city_id'] = 1;
//        $request['category_id'] = $category_id->id;
//        $request['approved'] = 0;
//        $news = News::create($request->all());

        $person = [];
        $person['user_id'] = 1;
        $person['first_name'] = $request['first_name'];
        $person['father_name'] = $request['father_name'];
        $person['family_id'] = $request['family_id'];
        $person['gender'] = $request['gender'];
        $person = Person::create($person);

        $request['person_id'] = $person->id;
        
        $newborn = Newborn::create($request->all());


        \App\Helpers\AppHelper::AddLog('Newborn Create', class_basename($newborn), $newborn->id);
        return redirect()->route('newborns.index')->with('success', 'تم اضافة مولود جديدة .');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function show(Newborn $newborn)
    {
        return redirect()->route('newborns.edit', $newborn);
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
        $pageTitle = 'القائمة الرئيسية';

        return view('web_app.Newborns.update', compact('menuTitle', 'pageTitle', 'newborn'));
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
        if(auth()->user()->id != $newborn->owner_id){
            return redirect()->route('newborns.index')->with('danger', 'لا يمكنك التعديل');
        }
        $newborn->title = $request->title;
        $newborn->body = $request->body;
        $newborn->date = Carbon::parse($request['date']);

        if($request->hasFile('image')){
            $new_media = new Media;
            $new_media = $new_media->EditUploadedMedia($request->file('image'), $newborn->image_id);
            if($new_media == null){
                return redirect()->route('newborns.index')->with('danger', 'حدث خطا');
            }
        }

        $newborn->save();

        \App\Helpers\AppHelper::AddLog('Newborn Update', class_basename($newborn), $newborn->id);
        return redirect()->route('newborns.index')->with('success', 'تم تعديل بيانات مولود بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Newborn  $newborn
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newborn $newborn)
    {
        if(auth()->user()->id != $newborn->owner_id){
            return redirect()->route('newborns.index')->with('danger', 'لا يمكنك التعديل');
        }
        $newborn->image->delete_file($newborn->image);
        $newborn->image->delete();
        $newborn->person->delete();
        $newborn->delete();

        \App\Helpers\AppHelper::AddLog('Newborn Delete', class_basename($newborn), $newborn->id);
        return redirect()->route('newborns.index')->with('success', 'تم حذف بيانات مولود بنجاح.');
    }
}
