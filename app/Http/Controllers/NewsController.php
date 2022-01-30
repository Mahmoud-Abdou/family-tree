<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\City;
use App\Models\Category;
use Illuminate\Http\Request;

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
    public function index()
    {
        $id = auth()->user()->id;
        $menuTitle = 'الاخبار';
        $pageTitle = 'القائمة الرئيسية';
        $page_limit = 20;
        $news = News::paginate($page_limit);

        return view('web_app.News.index', compact('menuTitle', 'pageTitle', 'news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuTitle = 'الاخبار';
        $pageTitle = 'القائمة الرئيسية';

        $cities = City::where('status', 1)->get();
        $categories = Category::where('type', 'news')->get();

        return view('web_app.News.create', compact('menuTitle', 'pageTitle', 'cities', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'city_id' => ['required'],
            'category_id' => ['required'],
            'title' => ['required'],
            'body' => ['required'],
        ]);
        $request['owner_id'] = auth()->user()->id;

        $news = new News;
        $news = News::create($request->all());

        \App\Helpers\AppHelper::AddLog('News Create', class_basename($news), $news->id);
        return redirect()->route('news.index')->with('success', 'تم اضافة خبر جديد .');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return redirect()->route('news.edit', $news);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
        $menuTitle = 'الاخبار';
        $pageTitle = 'القائمة الرئيسية';
        $cities = City::where('status', 1)->get();
        $categories = Category::where('type', 'news')->get();

        return view('web_app.News.update', compact('menuTitle', 'pageTitle', 'news','cities', 'categories'));
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
            return redirect()->route('news.index')->with('danger', 'لا يمكنك التعديل');
        }
        $news->city_id = $request->city_id;
        $news->title = $request->title;
        $news->body = $request->body;
        $news->category_id = $request->category_id;

        $news->save();

        \App\Helpers\AppHelper::AddLog('News Update', class_basename($news), $news->id);
        return redirect()->route('news.index')->with('success', 'تم تعديل بيانات الخبر بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news)
    {
        if(auth()->user()->id != $news->owner_id){
            return redirect()->route('news.index')->with('danger', 'لا يمكنك التعديل');
        }
        $news->delete();

        \App\Helpers\AppHelper::AddLog('News Delete', class_basename($news), $news->id);
        return redirect()->route('news.index')->with('success', 'تم حذف بيانات الخبر بنجاح.');
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

        return back()->with('success', 'تم تنشيط الخبر بنجاح');
    }
}
