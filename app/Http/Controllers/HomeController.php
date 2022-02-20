<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\User;
use App\Models\Family;
use App\Models\Person;

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
        $this->middleware('permission:searching.public')->only(['search']);
    }

    public function home()
    {
        $pageTitle = 'القائمة الرئيسية';
        $menuTitle = 'الرئيسية';
        $lastNews = News::active()->latest()->take(5)->get();

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
            $FirstOne = \App\Models\Person::where('gender', '=', 'male')->where('birth_date', '<>', null)->orderBy('birth_date', 'ASC')->first();
            $main_families = $FirstOne->ownFamily;
//        $main_families = Family::whereColumn('id', 'gf_family_id')->get();
            $families = [];
            foreach($main_families as $main_family){
                $families[] = $this->familyTreeData($main_family->id);
            }
            return response()->json($families, 200);
        }

        $pageTitle = 'القائمة الرئيسية';
        $menuTitle = 'شجرة العائلة';
        $personsCount = \App\Models\Person::all()->count();
        $familiesCount = \App\Models\Family::all()->count();

        return view('family-tree-render', compact('menuTitle', 'pageTitle', 'personsCount', 'familiesCount'));
    }

    private function familyTreeData($main_family_id)
    {
        $family_data_array = [];
        $main_family = Family::where('id', $main_family_id)->first();
        if($main_family == null){
            return null;
        }
        $father = Person::where('id', $main_family->father_id)->first();
        $mother = Person::where('id', $main_family->mother_id)->first();
        $father_name = $father == null ?  'غير مسجل' : $father->first_name;
        $mother_name = $mother == null ?  'غير مسجل' : $mother->first_name;

        $family_data_array['name'] = $father_name;
        $family_data_array['wife'] = $mother_name;
        $family_data_array['status'] = $father->is_live;
        $family_data_array['status2'] = $father->has_family;
        $family_data_array['className'] = $father->is_live ? ($father->gender == 'male' ? 'man-father' : 'wife-out') : 'dead';
        $family_data_array['gender'] = $father->gender;

        $families = Family::where('gf_family_id', $main_family->id)
            ->whereColumn('id', '!=', 'gf_family_id')
            ->get();

        $family_noFamily_children = Person::where('family_id', $main_family_id)
            ->where('has_family', 0)
            ->get();
        $no_family_children = [];
        foreach($family_noFamily_children as $child){
            $no_family_child['name'] = $child->first_name;
            $no_family_child['wife'] = "";
            $no_family_child['status'] = $child->is_live;
            $no_family_child['status2'] = $child->has_family;
            $no_family_child['gender'] = $child->gender;
            $no_family_child['className'] = $child->is_live ? ($child->gender == 'male' ? 'boy' : 'girl') : 'dead';
            $no_family_child['children'] = [];
            $no_family_children[] = $no_family_child;
        }
        $family_data_array['children'] = $no_family_children;
        foreach($families as $family){
            $family_data_array['children'][] = $this->familyTreeData($family->id);
        }
        return $family_data_array;
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
        $searchResult = \App\Models\Person::whereLike(['first_name', 'father_name', 'grand_father_name'], $request->search)->get();

        return view('search', compact('menuTitle', 'pageTitle', 'searchResult', 'searchWord'));
    }

    public function dashboard()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'لوحة التحكم';
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

    public function read_notification(Request $request)
    {
        if(!isset($request['id'])){
            return null;
        }
        if($request['id'] == '-1'){
            auth()->user()->unreadNotifications->markAsRead();
        }
        else{
            $notification = auth()->user()->unreadNotifications()->where('id', $request['id'])->first();
            if($notification == null){
                return "0";
            }
            else{
                $notification->markAsRead();
            }
            return "1";
        }
    }

}
