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
            $data = [];
            $FirstOne = \App\Models\Person::where('birth_date', '<>', null)->orderBy('birth_date', 'ASC')->first();
            $firstNode = ['id' => $FirstOne->id, 'familyId' => $FirstOne->family_id, 'name' => $FirstOne->full_name, 'photo' => $FirstOne->photo, 'gender' => $FirstOne->gender,  'symbol' => $FirstOne->symbol,  'color' => $FirstOne->color, ];
            array_push($data, $firstNode);
            $families = \App\Models\Family::all();
//            $families = \App\Models\Family::all()->take(5);
//            $FirstFam = $FirstOne->ownFamily;

            foreach ($families as $family) {
                $famPer = \App\Models\Person::where('family_id', $family->id)->get();
                foreach ($famPer as $p) {
                    if ($family->father->id == $p->id || $family->mother->id == $p->id) {

                    }
                    else {
                        array_push($data, ['id' => $p->id, 'mid' => $family->mother->id, 'fid' => $family->father->id, 'name' => $p->full_name, 'photo' => $p->photo, 'gender' => $p->gender,  'symbol' => $p->symbol,  'color' => $p->color, 'born' => $p->birth_date ]);
                    }
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
        $FirstOne = \App\Models\Person::where('birth_date', '<>', null)->orderBy('birth_date', 'ASC')->first();

        $familyTree = new \App\Models\Family;
        $data = $familyTree->TreeRender($FirstOne->id);

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

    public function get_family_tree()
    {
        $FirstOne = \App\Models\Person::where('birth_date', '<>', null)->orderBy('birth_date', 'ASC')->first();
        $main_families = $FirstOne->ownFamily;
//        $main_families = Family::whereColumn('id', 'gf_family_id')->get();
        $families = [];
        foreach($main_families as $main_family){
            $families[] = $this->get_family_data($main_family->id);
        }
        return response()->json($families, 200, [], JSON_UNESCAPED_UNICODE);

    }

    public function get_family_data($main_family_id)
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
        $family_data_array['relation'] = $father->relation;
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
            $no_family_child['relation'] = $child->relation;
            $no_family_child['gender'] = $child->gender;
            $no_family_child['children'] = [];
            $no_family_children[] = $no_family_child;
        }
        $family_data_array['children'] = $no_family_children;
        foreach($families as $family){
            $family_data_array['children'][] = $this->get_family_data($family->id);
        }
        return $family_data_array;

    }
}
