<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeathRequest;
use App\Http\Requests\UpdateDeathRequest;
use App\Models\Death;
use App\Models\City;
use App\Models\Media;
use App\Models\Category;
use App\Models\Family;
use Carbon\Carbon;

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
        $pageTitle = 'التطبيق';
        $page_limit = 20;
        $deaths = Death::paginate($page_limit);

        return view('web_app.Deaths.index', compact('menuTitle', 'pageTitle', 'deaths'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuTitle = 'الوفيات';
        $pageTitle = 'التطبيق';
        $families = Family::get();

        return view('web_app.Deaths.create', compact('menuTitle', 'pageTitle', 'families'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDeathRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeathRequest $request)
    {
        $request->validate([
            'title' => ['required'],
            'family_id' => ['required'],
            'body' => ['required'],
            'image' => ['required'],
            'date' => ['required'],
        ]);
        $request['owner_id'] = auth()->user()->id;
        $request['date'] = Carbon::parse($request['date']);

        $category_id = Category::where('type', 'death')->first();
        $media = new Media;
        $media = $media->UploadMedia($request->file('image'), $category_id->id, auth()->user()->id);
        $request['image_id'] = $media->id;

        $death = Death::create($request->all());
        
        $request['city_id'] = 1;
        $request['category_id'] = $category_id->id;
        $request['approved'] = 0;
        $news = news::create($request->all());
        
        \App\Helpers\AppHelper::AddLog('Death Create', class_basename($death), $death->id);
        return redirect()->route('deaths.index')->with('success', 'تم اضافة وفاة جديدة .');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Death  $death
     * @return \Illuminate\Http\Response
     */
    public function show(Death $death)
    {
        return redirect()->route('deaths.edit', $death);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Death  $death
     * @return \Illuminate\Http\Response
     */
    public function edit(Death $death)
    {
        $menuTitle = 'الوفيات';
        $pageTitle = 'التطبيق';
        $families = Family::get();
        
        return view('web_app.Deaths.update', compact('menuTitle', 'pageTitle', 'death', 'families'));
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
        $request->validate([
            'family_id' => ['required'],
            'title' => ['required'],
            'body' => ['required'],
            'date' => ['required'],
        ]);
        if(auth()->user()->id != $death->owner_id){
            return redirect()->route('deaths.index')->with('danger', 'لا يمكنك التعديل');
        }
        $death->family_id = $request->family_id;
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
