<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:dashboard.read')->only(['dashboard']);
    }

    public function home()
    {
        $pageTitle = 'القائمة الرئيسية';
        $menuTitle = 'الرئيسية';
        $lastNews = News::latest()->take(5)->get();

        return view('home', compact('menuTitle', 'pageTitle', 'lastNews'));
    }

    public function about()
    {
        $pageTitle = 'القائمة الرئيسية';
        $menuTitle = 'نبذة عن العائلة';

        return view('about', compact('menuTitle', 'pageTitle'));
    }

    public function dashboard()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'الاعدادات';
        $pageTitle = 'لوحة التحكم';
        $newsData = [];
        $newsData['lastNews'] = News::latest()->take(5)->get();
        $newsData['allNewsCount'] = News::count();
        $usersData = [];
        $usersData['lastUsers'] = User::where('status', '=', 'registered')->latest()->take(5)->get();
        $usersData['allUsersCount'] = User::count();
        $usersData['activeUsers'] = User::activeCount();
        $usersData['registeredUsers'] = User::registeredCount();
        $usersData['blockedCount'] = User::blockedCount();

        return view('dashboard.index', compact('appMenu', 'menuTitle', 'pageTitle', 'newsData', 'usersData'));
    }

}
