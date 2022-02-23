<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\City;
use App\Models\Media;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Pricecurrent\LaravelEloquentFilters\EloquentFilters;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;
use App\Events\DeathEvent;
use App\Events\NotificationEvent;


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
        $this->middleware('permission:events.update')->only(['edit', 'update', 'activate']);
        $this->middleware('permission:events.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $menuTitle = 'المناسبات';
        $pageTitle = 'القائمة الرئيسية';
        //$events = Event::active()->paginate($page_limit);
        $page_limit = 15;
        $events = new Event;
        $filters_data = isset($request['filters']) ? $request['filters'] : [];

        $filters_array = $events->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $events = $events->filter($filters);
        $events = $events->active();
        $events = $events->paginate($page_limit);

        return view('web_app.Events.index', compact('menuTitle', 'pageTitle', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $menuTitle = 'إضافة مناسبة';
        $pageTitle = 'لوحة التحكم';
        $cities = City::where('status', 1)->get();
        $categories = Category::where('type', 'event')->get();

        return view('web_app.events.create', compact('menuTitle', 'pageTitle', 'cities', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreEventRequest $request)
    {
        $request['owner_id'] = auth()->id();

        if ($request->hasfile('image')) {
            $media = new Media;
            $media = $media->UploadMedia($request->file('image'), $request['category_id'], auth()->id());
            $request['image_id'] = $media->id;
        }

        $event = Event::create($request->all());

        \App\Helpers\AppHelper::AddLog('Event Create', class_basename($event), $event->id);
        return redirect()->route('events.index')->with('success', 'تم اضافة مناسبة جديدة .');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Event $event)
    {
        $menuTitle = $event->title;
        $pageTitle = 'القائمة الرئيسية';
        $lastEvents = Event::latest()->take(5)->get();

        return view('web_app.Events.show', compact('menuTitle', 'pageTitle', 'event', 'lastEvents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Event $event)
    {
        $menuTitle = 'تعديل مناسبة';
        $pageTitle = 'لوحة التحكم';
        $cities = City::where('status', 1)->get();
        $categories = Category::where('type', 'event')->get();

        return view('web_app.events.update', compact('menuTitle', 'pageTitle', 'event', 'cities', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        if(auth()->id() != $event->owner_id){
            return redirect()->route('events.index')->with('error', 'لا تملك صلاحية للتعديل!');
        }

        if($request->hasFile('image')){
            $new_media = new Media;
            $new_media = $new_media->EditUploadedMedia($request->file('image'), $event->image_id);
            if($new_media == null){
                return redirect()->route('events.index')->with('error', 'حدث خطا');
            }
        }

        $event->fill($request->all());

        if ($event->isDirty()) {
            $event->save();
            \App\Helpers\AppHelper::AddLog('Event Update', class_basename($event), $event->id);
            return redirect()->route('events.index')->with('success', 'تم تعديل بيانات المناسبة بنجاح.');
        }

        return redirect()->route('events.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event)
    {
        if(auth()->id() != $event->owner_id){
            return redirect()->route('events.index')->with('error', 'لا يمكنك الحذف');
        }
        $event->image->DeleteFile($event->image);
        $event->image->delete();
        $event->delete();

        \App\Helpers\AppHelper::AddLog('Event Delete', class_basename($event), $event->id);
        return redirect()->route('events.index')->with('success', 'تم حذف بيانات المناسبة بنجاح.');
    }

}
