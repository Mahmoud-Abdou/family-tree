<?php

namespace App\Http\Controllers;

use App\Models\NewsComment;
use App\Http\Requests\StoreNewsCommentRequest;
use App\Http\Requests\UpdateNewsCommentRequest;
//use Illuminate\Http\Request;

class NewsCommentController extends Controller
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
    public function store(StoreNewsCommentRequest $request)
    {
        $request['owner_id'] = auth()->user()->id;

        $news_comment = NewsComment::create($request->all());

        return redirect()->back()->with('success', 'تم اضافة تعليق جديد .');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NewsComment  $news_comment
     * @return \Illuminate\Http\Response
     */
    public function show($news_comment_id)
    {
        return redirect()->route('news.index');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NewsComment  $news_comment
     * @return \Illuminate\Http\Response
     */
    public function edit(NewsComment $news_comment)
    {
        return redirect()->route('news.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NewsComment  $news_comment
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateNewsCommentRequest $request, NewsComment $news_comment)
    {

        if(auth()->user()->id != $news->owner_id){
            return redirect()->route('news.index')->with('error', 'لا يمكنك التعديل');
        }

        $news_comment->body = $request->body;

        if ($news_comment->isDirty()){
            $news_comment->save();

            return redirect()->back()->with('success', 'تم تعديل التعليق  بنجاح.');
        }

        return redirect()->route('news.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NewsComment  $news_comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(NewsComment $news_comment)
    {
        if(auth()->user()->id != $news_comment->owner_id){
            return redirect()->route('news.index')->with('error', 'لا يمكنك التعديل');
        }
        $news_comment->delete();

        return redirect()->back()->with('success', 'تم حذف  التعليق بنجاح.');
    }
}
