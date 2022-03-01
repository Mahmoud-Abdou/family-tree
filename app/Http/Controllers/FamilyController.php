<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Person;
use Illuminate\Http\Request;

class FamilyController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:families.read')->only(['index', 'show']);
        $this->middleware('permission:families.create')->only(['create', 'store']);
        $this->middleware('permission:families.update')->only(['edit', 'update']);
        $this->middleware('permission:families.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'الأسر';
        $pageTitle = 'لوحة التحكم';

        // filters
        $perPage = isset($_GET['per-page']) ? $_GET['per-page'] : 10;
//        $perCity = isset($_GET['city']) && $_GET['city'] != 'all' ? $_GET['city'] : null;
        $perName = isset($_GET['name']) ? $_GET['name'] : null;

        $families = Family::where([
            ['name', $perName ? '=' : '<>', $perName],
        ])->paginate($perPage);

        return view('dashboard.families.index', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'families'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'إضافة أسرة';
        $pageTitle = 'لوحة التحكم';

        $fathers = Person::where('gender', '=', 'male')->get();
        $mothers = Person::where('gender', '=', 'female')->get();
        $families = Family::all();

        return view('dashboard.families.create', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'fathers', 'mothers', 'families'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'father_id' => ['required'],
            'mother_id' => ['required'],
            'children_count' => ['numeric'],
            'gf_family_id' => ['nullable'],
        ]);

        $family = Family::create($data);

        \App\Helpers\AppHelper::AddLog('Family Create', class_basename($family), $family->id);
        return redirect()->route('admin.families.index')->with('success', 'تم اضافة أسرة جديدة بنجاح.');
    }

    /**
     * Display the specified resource.
     *
     * @param Family $family
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Family $family)
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = $family->name;
        $pageTitle = 'لوحة التحكم';

        $allPersons = Person::where('family_id', null)
            ->get(['id', 'first_name', 'father_name', 'grand_father_name', 'prefix'])->except([$family->father_id, $family->mother_id]);
        $fosterPersons = Person::where('family_id', null)->get(['id', 'first_name', 'father_name', 'grand_father_name', 'prefix']);

        return view('dashboard.families.show', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'family', 'allPersons', 'fosterPersons'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Family $family
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Family $family)
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'إضافة أسرة';
        $pageTitle = 'لوحة التحكم';

        $fathers = Person::where('gender', '=', 'male')->get();
        $mothers = Person::where('gender', '=', 'female')->get();
        $families = Family::all()->except($family->id);

        return view('dashboard.families.update', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'fathers', 'mothers', 'families', 'family'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Family $family
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, family $family)
    {
        $request->validate([
            'name' => ['required'],
            'father_id' => ['required'],
            'mother_id' => ['required'],
            'children_count' => ['numeric'],
            'gf_family_id' => ['nullable'],
        ]);

        $family->name = $request->name;
        $family->father_id = $request->father_id;
        $family->mother_id = $request->mother_id;
        $family->gf_family_id = $request->gf_family_id;
        $family->children_count = $request->children_count;

        if ($family->isDirty()) {
            $family->save();
            \App\Helpers\AppHelper::AddLog('Family Create', class_basename($family), $family->id);
            return redirect()->route('admin.families.index')->with('success', 'تم تعديل الأسرة بنجاح.');
        }

        return redirect()->route('admin.families.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Family $family
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Family $family)
    {
        if (isset($family)){
            \App\Helpers\AppHelper::AddLog('Family Delete', class_basename($family), $family->id);
            $family->delete();
            return redirect()->route('admin.families.index')->with('success', 'تم حذف الأسرة بنجاح.');
        }

        return redirect()->route('admin.families.index');
    }
}
