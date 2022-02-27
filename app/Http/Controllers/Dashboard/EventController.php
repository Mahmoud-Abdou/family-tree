<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\City;
use App\Models\User;
use App\Models\Media;
use App\Models\Category;
use App\Events\NotificationEvent;
use Illuminate\Http\Request;

use Pricecurrent\LaravelEloquentFilters\EloquentFilters;

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
        $appMenu = config('custom.app_menu');
        $menuTitle = 'المناسبات';
        $pageTitle = 'لوحة التحكم';
        $page_limit = 20;
        $events = new Event;
        $filters_data = isset($request['filters']) ? $request['filters'] : [];
        $filters_array = $events->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $events = $events->filter($filters);
        $events = $events->orderBy('created_at', 'DESC')
                ->paginate($page_limit);

        $cities = City::get();

        return view('dashboard.events.index', compact('menuTitle', 'appMenu', 'pageTitle', 'events', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'إضافة مناسبة';
        $pageTitle = 'لوحة التحكم';
        $cities = City::where('status', 1)->get();
        $categories = Category::where('type', 'event')->get();

        return view('dashboard.events.create', compact('menuTitle', 'appMenu', 'pageTitle', 'cities', 'categories'));
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
        return redirect()->route('admin.events.index')->with('success', 'تم اضافة مناسبة جديدة .');
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
        $pageTitle = 'لوحة التحكم';
        $lastEvents = Event::latest()->take(5)->get();

        return view('dashboard.Events.show', compact('menuTitle', 'pageTitle', 'event', 'lastEvents'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Event $event)
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'تعديل مناسبة';
        $pageTitle = 'لوحة التحكم';
        $cities = City::where('status', 1)->get();
        $categories = Category::where('type', 'event')->get();

        return view('dashboard.events.update', compact('menuTitle', 'appMenu', 'pageTitle', 'event', 'cities', 'categories'));
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
        if(!auth()->user()->can('events.update')) {
            return redirect()->route('admin.events.index')->with('error', 'لا تملك صلاحية للتعديل!');
        }

        if($request->hasFile('image')){
            $new_media = new Media;
            $new_media = $new_media->EditUploadedMedia($request->file('image'), $event->image_id);
            if($new_media == null){
                return redirect()->route('admin.events.index')->with('error', 'حدث خطا');
            }
        }

        $event->fill($request->all());

        if ($event->isDirty()) {
            $event->save();
            \App\Helpers\AppHelper::AddLog('Event Update', class_basename($event), $event->id);
            return redirect()->route('admin.events.index')->with('success', 'تم تعديل بيانات المناسبة بنجاح.');
        }

        return redirect()->route('admin.events.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Event $event)
    {
        if(auth()->user()->can('events.delete')) {
            $event->image->DeleteFile($event->image);
            $event->image->delete();
            $event->delete();

            \App\Helpers\AppHelper::AddLog('Event Delete', class_basename($event), $event->id);
            return redirect()->route('admin.events.index')->with('success', 'تم حذف بيانات المناسبة بنجاح.');
        }

        return redirect()->route('admin.events.index')->with('error', 'لا يمكن الحذف.');
    }

    public function activate(Request $request)
    {
        $event = Event::find($request->event_id);

        if (is_null($event)) {
            return back()->with('error', 'حدث خطأ.');
        }

        $event->approved = true;
        $event->approved_by = auth()->id();
        $event->save();

        $event['operation_type'] = 'store';
        $event_notification = [];
        $event_notification['title'] = 'تم اضافة مناسبة';
        $event_notification['body'] = $event->notification_body;
        $event_notification['content'] = $event;
        $event_notification['url'] = 'events/' . $event->id;
        $event_notification['operation'] = 'store';

        $users = User::where('status', 'active')->get();
        event(new NotificationEvent($event_notification, $users));


        return back()->with('success', 'تم تنشيط المناسبة بنجاح');
    }

}
