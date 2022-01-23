<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use App\Models\City;
use App\Models\Category;
use App\Traits\HasImage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class EventController extends Controller
{
    use HasImage;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->user()->id;
        $menuTitle = 'الافراح و المناسبات';
        $pageTitle = 'التطبيق';
        $page_limit = 20;
        $events = Event::where('owner_id', $id)
                    ->paginate($page_limit);

        return view('web_app.events.index', compact('menuTitle', 'pageTitle', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuTitle = 'الافراح و المناسبات';
        $pageTitle = 'التطبيق';
        $cities = City::where('status', 1)->get();
        $categories = Category::where('type', 'event')->get();

        return view('web_app.events.create', compact('menuTitle', 'pageTitle', 'cities', 'categories'));
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
            'category_id' => ['required'],
        ]);
        $request['owner_id'] = auth()->user()->id;
        $image = 1;
        // $image = $this->ImageUpload($request->file('image'), (new Event)->photoPath, null, $request['category_id'], auth()->user()->id);
        $request['image_id'] = $image;

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
        $menuTitle = 'الافراح و المناسبات';
        $pageTitle = 'التطبيق';
        $cities = City::where('status', 1)->get();
        $categories = Category::where('type', 'event')->get();
        // dd($event->category->id);

        return view('web_app.events.update', compact('menuTitle', 'pageTitle', 'event','cities', 'categories'));
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
            'image' => ['required'],
            'category_id' => ['required'],
        ]);

        $event->city_id = $request->city_id;
        $event->title = $request->title;
        $event->body = $request->body;
        $event->category_id = $request->category_id;
        // $event->image_id = $request->image_id;
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
        $event->delete();
        \App\Helpers\AppHelper::AddLog('Event Delete', class_basename($event), $event->id);
        return redirect()->route('events.index')->with('success', 'تم حذف بيانات المناسبة بنجاح.');
    }
}
