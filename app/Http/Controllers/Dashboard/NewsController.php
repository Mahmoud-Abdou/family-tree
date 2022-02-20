<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\News;
use App\Models\City;
use App\Models\Category;
use App\Events\NewsEvent;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use App\Events\NotificationEvent;
use Carbon\Carbon;
use App\Filters\OwnerFilter;
use Pricecurrent\LaravelEloquentFilters\EloquentFilters;

class NewsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:news.read')->only(['index', 'show']);
        $this->middleware('permission:news.create')->only(['create', 'store']);
        $this->middleware('permission:news.update')->only(['edit', 'update']);
        $this->middleware('permission:news.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $menuTitle = 'الاخبار';
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';

        $page_limit = 20;
        $categories = Category::get();
        $cities = City::get();

        $news = new News;
        $filters_data = isset($request['filters']) ? $request['filters'] : [];

        $filters_array = $news->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $news = $news->filter($filters);

        $news = $news->orderBy('created_at', 'DESC')
                ->paginate($page_limit);

        return view('dashboard.news.index', compact('appMenu', 'menuTitle', 'pageTitle', 'news', 'categories', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuTitle = 'اضافة خبر';
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';

        $cities = City::where('status', 1)->get();
        $categories = Category::get();

        return view('dashboard.news.create', compact('appMenu', 'menuTitle', 'pageTitle', 'cities', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->route('admin.news.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show($news_id)
    {
        return redirect()->route('admin.news.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $menuTitle = 'تعديل خبر';
        $appMenu = config('custom.app_menu');
        $pageTitle = 'لوحة التحكم';

        $cities = City::where('status', 1)->get();
        $categories = Category::get();

        return view('dashboard.news.update', compact('appMenu', 'menuTitle', 'pageTitle', 'news','cities', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'city_id' => ['required'],
            'title' => ['required'],
            'body' => ['required'],
            'category_id' => ['required'],
        ]);

        if(auth()->user()->id != $news->owner_id){
            return redirect()->route('admin.news.index')->with('error', 'لا يمكنك التعديل');
        }

        $news->city_id = $request->city_id;
        $news->title = $request->title;
        $news->body = $request->body;
        $news->category_id = $request->category_id;

        if ($news->isDirty()){
            $news->save();

            \App\Helpers\AppHelper::AddLog('News Update', class_basename($news), $news->id);
            return redirect()->route('admin.news.index')->with('success', 'تم تعديل بيانات الخبر بنجاح.');
        }

        return redirect()->route('admin.news.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        $news->delete();

        \App\Helpers\AppHelper::AddLog('News Delete', class_basename($news), $news->id);
        return redirect()->route('admin.news.index')->with('success', 'تم حذف بيانات الخبر بنجاح.');
    }

    public function activate(Request $request)
    {
        $news = News::find($request->news_id);

        if (is_null($news)) {
            return back()->with('error', '');
        }

        $news->approved = true;
        $news->approved_by = auth()->id();
        $news->save();
        
        $news['operation_type'] = 'store';
        $news_notification = [];
        $news_notification['title'] = 'تم اضافة خبر';
        $news_notification['body'] = $news->notification_body;
        $news_notification['content'] = $news;
        $news_notification['url'] = 'news/' . $news->id;
        $news_notification['operation'] = 'store';

        $users = User::where('status', 'active')->get();
        event(new NotificationEvent($news_notification, $users));

        return back()->with('success', 'تم تنشيط الخبر بنجاح');
    }

    public function get_news($category_id)
    {
        if($category_id == null || $category_id == 1){
            $news = News::with('category')->with('city')->with('owner')->where('approved', 1)->get();
        }
        else{
            $news = News::with('category')->with('city')->with('owner')->where('approved', 1)->where('category_id', $category_id)->get();
        }
        return response()->json($news, 200, [], JSON_UNESCAPED_UNICODE);
    }

}
