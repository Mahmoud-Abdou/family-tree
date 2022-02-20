<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsLike;
use App\Http\Requests\StoreNewsLikeRequest;


class NewsLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect()->route('news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('news.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreNewsLikeRequest $request)
    {
        $request['owner_id'] = auth()->user()->id;
        $old_like = NewsLike::where('owner_id', $request['owner_id'])
                            ->where('news_id', $request['news_id'])
                            ->first();
        if($old_like == null){
            $news_like = NewsLike::create($request->all());
        }
        return redirect()->back()->with('success', 'تم اضافة اعجاب جديد .');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewsLike  $news_like
     * @return \Illuminate\Http\Response
     */
    public function show($news_like_id)
    {
        return redirect()->route('news.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewsLike  $news_like
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsLike $news_like)
    {
        return redirect()->route('news.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewsLike  $news_like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NewsLike $news_like)
    {
        return redirect()->route('news.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsLike  $news_like
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsLike $news_like)
    {
        if(auth()->user()->id != $news_like->owner_id){
            return redirect()->route('news.index')->with('error', 'لا يمكنك التعديل');
        }
        $news_like->delete();

        return redirect()->back()->with('success', 'تم حذف الاعجاب بنجاح.');
    }
}
