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
        $this->middleware('auth')->except('terms');
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
        $content = \App\Helpers\AppHelper::GeneralSettings('app_about_ar');

        return view('about', compact('menuTitle', 'pageTitle', 'content'));
    }

    public function familyTree()
    {
        $pageTitle = 'القائمة الرئيسية';
        $menuTitle = 'شجرة العائلة';
        $setting = \App\Models\Setting::first();
        $content = $setting->family_tree_image;
        if (file_exists(public_path('uploads/settings/') . $setting->getRawOriginal('family_tree_image'))) {
            $time = date ("Y-m-d H:i:s.", filemtime(public_path('uploads/settings/') . $setting->getRawOriginal('family_tree_image')));
        } else {
            $time = $setting->updated_at;
        }

        return view('family-tree', compact('menuTitle', 'pageTitle', 'content', 'time'));
    }

    public function terms()
    {
        $pageTitle = 'القائمة الرئيسية';
        $menuTitle = 'شروط الاستخدام';
        $content = \App\Helpers\AppHelper::GeneralSettings('app_terms_ar');

        return view('terms', compact('menuTitle', 'pageTitle', 'content'));
    }

    public function search(Request $request)
    {
        $pageTitle = 'القائمة الرئيسية';
        $menuTitle = 'البحث';
        $searchWord = $request->search;
        $searchResult = \App\Models\Person::whereLike(['first_name', 'father_name', 'grand_father_name'], $searchWord)->get();

        return view('search', compact('menuTitle', 'pageTitle', 'searchResult', 'searchWord'));
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
