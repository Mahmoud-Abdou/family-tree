<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\City;
use App\Models\Media;
use App\Models\Category;

class EventController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:events.read')->only(['index', 'show']);
        $this->middleware('permission:events.create')->only(['create', 'store']);
        $this->middleware('permission:events.update')->only(['edit', 'update']);
        $this->middleware('permission:events.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuTitle = 'المناسبات';
        $pageTitle = 'القائمة الرئيسية';
        $page_limit = 20;
        $events = Event::paginate($page_limit);

        return view('web_app.Events.index', compact('menuTitle', 'pageTitle', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuTitle = 'إضافة مناسبة';
        $pageTitle = 'القائمة الرئيسية';
        $cities = City::where('status', 1)->get();
        $categories = Category::where('type', 'event')->get();

        return view('web_app.Events.create', compact('menuTitle', 'pageTitle', 'cities', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        $request->validate([
            'city_id' => ['required'],
            'title' => ['required'],
            'body' => ['required'],
            'image' => ['required'],
            'event_date' => ['required'],
            'category_id' => ['required'],
        ]);
        $request['owner_id'] = auth()->user()->id;
        $request['event_date'] = strtotime($request['event_date']);
        $media = new Media;
        $media = $media->UploadMedia($request->file('image'), $request['category_id'], auth()->user()->id);
        $request['image_id'] = $media->id;

        $event = Event::create($request->all());

        \App\Helpers\AppHelper::AddLog('Event Create', class_basename($event), $event->id);
        return redirect()->route('events.index')->with('success', 'تم اضافة مناسبة جديدة .');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        return redirect()->route('events.edit', $event);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $menuTitle = 'تعديل مناسبة';
        $pageTitle = 'القائمة الرئيسية';
        $cities = City::where('status', 1)->get();
        $categories = Category::where('type', 'event')->get();

        return view('web_app.Events.update', compact('menuTitle', 'pageTitle', 'event','cities', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $request->validate([
            'city_id' => ['required'],
            'title' => ['required'],
            'body' => ['required'],
            'event_date' => ['required'],
            'category_id' => ['required'],
        ]);
        if(auth()->user()->id != $event->owner_id){
            return redirect()->route('events.index')->with('danger', 'لا يمكنك التعديل');
        }
        $event->city_id = $request->city_id;
        $event->title = $request->title;
        $event->body = $request->body;
        $event->event_date = strtotime($request['event_date']);
        $event->category_id = $request->category_id;

        if($request->hasFile('image')){
            $new_media = new Media;
            $new_media = $new_media->EditUploadedMedia($request->file('image'), $event->image_id);
            if($new_media == null){
                return redirect()->route('events.index')->with('danger', 'حدث خطا');
            }
        }

        $event->save();

        \App\Helpers\AppHelper::AddLog('Event Update', class_basename($event), $event->id);
        return redirect()->route('events.index')->with('success', 'تم تعديل بيانات المناسبة بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        if(auth()->user()->id != $event->owner_id){
            return redirect()->route('events.index')->with('danger', 'لا يمكنك التعديل');
        }
        $event->image->delete_file($event->image);
        $event->image->delete();
        $event->delete();

        \App\Helpers\AppHelper::AddLog('Event Delete', class_basename($event), $event->id);
        return redirect()->route('events.index')->with('success', 'تم حذف بيانات المناسبة بنجاح.');
    }
}
