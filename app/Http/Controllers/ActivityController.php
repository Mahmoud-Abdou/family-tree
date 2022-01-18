<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:activities.read')->only(['index', 'show']);
        $this->middleware('permission:activities.delete')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'سجل المستخدمين';
        $pageTitle = 'لوحة التحكم';
        $activities = Activity::paginate(25);

        return view('dashboard.activities', compact('appMenu', 'pageTitle', 'menuTitle', 'activities'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
//     * @param Activity $activity
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        Activity::truncate();
        return back()->with('success', 'تم حذف السجل بشكل كامل');
    }
}
