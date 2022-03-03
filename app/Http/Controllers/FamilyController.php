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
            'children_count' => ['nullable', 'numeric'],
            'gf_family_id' => ['nullable'],
        ]);

        $father = Person::find($data['father_id']);
        if (!isset($father)) {
            $fatherName = explode(" ", $data['father_id']);
            if (!isset($fatherName[1])) {
                return back()->with('error', 'يوجد خطأ في اسم الأب');
            }

            $father = Person::create([
                'first_name' => $fatherName[0],
                'father_name' => $fatherName[1],
                'grand_father_name' => isset($fatherName[2]) ? $fatherName[2] : '',
                'surname' => isset($fatherName[3]) ? $fatherName[3] : '',
                'gender' => 'male',
                'has_family' => true,
            ]);
        }

        $mother = Person::find($data['mother_id']);
        if (!isset($mother)) {
            if ($data['mother_id'] != 'none') {
                $motherName = explode(" ", $data['mother_id']);

                $mother = Person::create([
                    'first_name' => $motherName[0],
                    'father_name' => $motherName[1],
                    'grand_father_name' => isset($motherName[2]) ? $motherName[2] : '',
                    'surname' => isset($motherName[3]) ? $motherName[3] : '',
                    'gender' => 'female',
                    'has_family' => true,
                ]);
            }
        }

        $gfFamily = Family::find($data['gf_family_id']);
        if (!isset($gfFamily)) {
            if ($data['gf_family_id'] != 'none') {
                $gfFamilyName = explode(" ", $data['gf_family_id']);

                $gfPerson = Person::create([
                    'first_name' => $gfFamilyName[0],
                    'father_name' => $gfFamilyName[1],
                    'grand_father_name' => isset($gfFamilyName[2]) ? $gfFamilyName[2] : '',
                    'surname' => isset($gfFamilyName[3]) ? $gfFamilyName[3] : '',
                    'gender' => 'male',
                    'has_family' => true,
                ]);

                $gfFamily = Family::create([
                    'name' => 'أسرة '. $gfPerson->first_name,
                    'father_id' => $gfPerson->id,
                    'mother_id' => null,
                    'children_count' => 1,
                    'gf_family_id' => null,
                    'status' => true,
                ]);

                $father->family_id = $gfFamily->id;
                $father->save();
            }
        }

        $family = Family::create([
            'name' => $data['name'],
            'father_id' => $father->id,
            'mother_id' => isset($mother) ? $mother->id : null,
            'children_count' => isset($data['children_count']) ? $data['children_count'] : 0,
            'gf_family_id' => isset($gfFamily) ? $gfFamily->id : null,
            'status' => true
        ]);

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
        $menuTitle = 'تعديل أسرة: '.$family->name;
        $pageTitle = 'لوحة التحكم';

        $mothers = Person::where('gender', '=', 'female')->get();
        $families = Family::all()->except($family->id);

        return view('dashboard.families.update', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'mothers', 'families', 'family'
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

        $mother = Person::find($request->mother_id);
        if (!isset($mother)) {
            if ($request->mother_id != 'none') {
                $motherName = explode(" ", $request->mother_id);

                $mother = Person::create([
                    'first_name' => $motherName[0],
                    'father_name' => $motherName[1],
                    'grand_father_name' => isset($motherName[2]) ? $motherName[2] : '',
                    'surname' => isset($motherName[3]) ? $motherName[3] : '',
                    'gender' => 'female',
                    'has_family' => true,
                ]);
            }
        }

        $family->name = $request->name;
        $family->father_id = $request->father_id;
        $family->mother_id = isset($mother) ? $mother->id : null;
        $family->gf_family_id = $request->gf_family_id != 'none' ? $request->gf_family_id : null;
        $family->children_count = $family->members->count();

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
