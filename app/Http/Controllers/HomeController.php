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

    public function familyTreeRender(Request $request)
    {
        if($request->ajax()){
            $FirstOne = \App\Models\Person::where('birth_date', '<>', null)->orderBy('birth_date', 'ASC')->first();
            $firstNode = ['id' => $FirstOne->id, 'familyId' => $FirstOne->family_id, 'name' => $FirstOne->full_name, 'photo' => $FirstOne->photo, 'gender' => $FirstOne->gender,  'symbol' => $FirstOne->symbol,  'color' => $FirstOne->color, ];
//            $families = \App\Models\Family::all();
            $families = \App\Models\Family::all()->take(5);
            $data = [];

            array_push($data, $firstNode);

            foreach ($families as $family) {
                $famPer = \App\Models\Person::where('family_id', $family->id)->get();
                foreach ($famPer as $p) {
                    array_push($data, ['id' => $p->id, 'father' => $family->father->full_name, 'name' => $p->full_name, 'photo' => $p->photo, 'gender' => $p->gender,  'symbol' => $p->symbol,  'color' => $p->color, ]);
                }
            }

            return response()->json(array(
                'success' => true,
                'data' => $data
            ));
        }

        $pageTitle = 'القائمة الرئيسية';
        $menuTitle = 'شجرة العائلة';
        $personsCount = \App\Models\Person::all()->count();
        $familiesCount = \App\Models\Family::all()->count();

        return view('family-tree-render', compact('menuTitle', 'pageTitle', 'personsCount', 'familiesCount'));
    }

    public function familyTreeData()
    {
        dd('family data');
        $FirstOne = \App\Models\Person::where('birth_date', '<>', null)->orderBy('birth_date', 'ASC')->first();
        $firstNode = ['id' => $FirstOne->id, 'familyId' => $FirstOne->family_id, 'name' => $FirstOne->full_name, 'photo' => $FirstOne->photo, 'gender' => $FirstOne->gender,  'symbol' => $FirstOne->symbol,  'color' => $FirstOne->color, ];
//            $families = \App\Models\Family::all();
        $families = \App\Models\Family::all()->take(5);
        $data = [];

        array_push($data, $firstNode);

        foreach ($families as $family) {
            $famPer = \App\Models\Person::where('family_id', $family->id)->get();
            foreach ($famPer as $p) {
                array_push($data, ['id' => $p->id, 'father' => $family->father->full_name, 'name' => $p->full_name, 'photo' => $p->photo, 'gender' => $p->gender,  'symbol' => $p->symbol,  'color' => $p->color, ]);
            }
        }

        return response()->json(array(
            'success' => true,
            'data' => $data
        ));
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
