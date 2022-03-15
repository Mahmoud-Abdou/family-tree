<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Person;
use Pricecurrent\LaravelEloquentFilters\EloquentFilters;
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
    public function index(Request $request)
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'الأسر';
        $pageTitle = 'لوحة التحكم';

        // filters
        $perPage = isset($_GET['perPage']) ? $_GET['perPage'] : 10;
        $filters_data = isset($request['filters']) ? $request['filters'] : [];

        $families = new Family;
        $filters_array = $families->filters($filters_data);
        $filters = EloquentFilters::make($filters_array);
        $families = $families->filter($filters);
        $families = $families->paginate($perPage);

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['nullable'],
            'father_id' => ['required'],
            'mother_id' => ['required'],
            'children_count' => ['nullable', 'numeric'],
            'gf_family_id' => ['nullable'],
        ]);

        $father = Person::find($data['father_id']);
        if (!isset($father)) {
            $fatherName = explode(" ", $data['father_id']);
            if (!isset($fatherName[1])) {
                return back()->with('error', ' يوجد خطأ في اسم الأب (الاسم ثلالثي)');
            }

            $father = Person::create([
                'first_name' => $fatherName[0],
                'father_name' => $fatherName[1],
                'grand_father_name' => isset($fatherName[2]) ? $fatherName[2] : '',
                'surname' => isset($fatherName[3]) ? $fatherName[3] : '',
                'gender' => 'male',
                'has_family' => true,
            ]);
        } else {
            $father->has_family = true;
            $father->save();
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
        } else {
            $mother->has_family = true;
            $mother->save();
        }

        $gfFamily = Family::find($data['gf_family_id']);
        if (isset($gfFamily)) {
            // fix father family id
            $father->family_id = $gfFamily->id;
            $father->save();
        }

        if (isset($mother) && $father->wives->contains($mother->id)) {
            $family = Family::where([['father_id', $father->id], ['mother_id', $mother->id]])->first();
        } else {
            $family = Family::create([
                'name' => isset($data['name']) ? $data['name'] : 'أسرة '. $father->first_name,
                'father_id' => $father->id,
                'mother_id' => isset($mother) ? $mother->id : null,
                'children_count' => isset($data['children_count']) ? $data['children_count'] : 0,
                'gf_family_id' => isset($gfFamily) ? $gfFamily->id : null,
                'status' => true
            ]);
        }

        // add family children
        if (isset($request->family_children_m)) {
            foreach ($request->family_children_m as $children) {
                $boy = Person::find($children);

                if (isset($boy)) {
                    $boy->family_id = $family->id;
                    $boy->save();
                } else {
                    Person::create([
                        'first_name' => $children,
                        'father_name' => $father->first_name,
                        'grand_father_name' => $father->father_name,
                        'surname' => $father->grand_father_name,
                        'gender' => 'male',
                        'has_family' => false,
                        'family_id' => $family->id,
                    ]);
                }
            }
        }

        if (isset($request->family_children_f)) {
            foreach ($request->family_children_f as $children) {
                $girl = Person::find($children);

                if (isset($girl)) {
                    $girl->family_id = $family->id;
                    $girl->save();
                } else {
                    Person::create([
                        'first_name' => $children,
                        'father_name' => $father->first_name,
                        'grand_father_name' => $father->father_name,
                        'surname' => $father->grand_father_name,
                        'gender' => 'female',
                        'has_family' => false,
                        'family_id' => $family->id,
                    ]);
                }
            }
        }

        // fix children count
        $family->children_count = $family->members->count();
        $family->save();

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

        $allPersons = Person::get(['id', 'first_name', 'father_name', 'grand_father_name', 'prefix'])->except([$family->father_id, $family->mother_id]);

        return view('dashboard.families.show', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'family', 'allPersons'
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

        $fathers = Person::where('gender', 'male')->get();
        $mothers = Person::where('gender', 'female')->get();
        $families = Family::all()->except($family->id);
        $boys = Person::where('gender', '=', 'male')->where('family_id', '=', $family->id)->get();
        $girls = Person::where('gender', '=', 'female')->where('family_id', '=', $family->id)->get();

        return view('dashboard.families.update', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'fathers', 'mothers', 'families', 'family', 'boys', 'girls'
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
            'name' => ['nullable'],
            'father_id' => ['required'],
            'mother_id' => ['required'],
            'gf_family_id' => ['nullable'],
        ]);

        $father = Person::find($request->father_id);
        if (!isset($father)) {
            $fatherName = explode(" ", $request->father_id);

            $father = Person::create([
                'first_name' => $fatherName[0],
                'father_name' => $fatherName[1],
                'grand_father_name' => isset($fatherName[2]) ? $fatherName[2] : '',
                'surname' => isset($fatherName[3]) ? $fatherName[3] : '',
                'gender' => 'male',
                'has_family' => true,
            ]);
        } else {
            $father->has_family = true;
            $father->save();
        }

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
        } else {
            $mother->has_family = true;
            $mother->save();
        }

        // update family children
        if ($request->has('family_children_m')) {
            $boys = Person::where([['gender', '=', 'male'], ['family_id', '=', $family->id]])->get();
            foreach ($boys as $b) {
                $b->family_id = null;
                $b->save();
            }

            foreach ($request->family_children_m as $children) {
                $boy = Person::find($children);

                if (isset($boy)) {
                    $boy->family_id = $family->id;
                    $boy->father_name = $father->first_name;
                    $boy->grand_father_name = $father->father_name;
                    $boy->save();
                } else {
                    Person::create([
                        'first_name' => $children,
                        'father_name' => $father->first_name,
                        'grand_father_name' => $father->father_name,
//                        'surname' => $father->grand_father_name,
                        'gender' => 'male',
                        'has_family' => false,
                        'family_id' => $family->id,
                    ]);
                }
            }
        } else {
            $boys = Person::where([['gender', '=', 'male'], ['family_id', '=', $family->id]])->get();
            foreach ($boys as $b) {
                $b->family_id = null;
                $b->save();
            }
        }

        if ($request->has('family_children_f')) {
            $girls = Person::where([['gender', '=', 'female'], ['family_id', '=', $family->id]])->get();
            foreach ($girls as $g) {
                $g->family_id = null;
                $g->save();
            }

            foreach ($request->family_children_f as $children) {
                $girl = Person::find($children);

                if (isset($girl)) {
                    $girl->family_id = $family->id;
                    $girl->father_name = $father->first_name;
                    $girl->grand_father_name = $father->father_name;
                    $girl->save();
                } else {
                    Person::create([
                        'first_name' => $children,
                        'father_name' => $father->first_name,
                        'grand_father_name' => $father->father_name,
                        'surname' => $father->grand_father_name,
                        'gender' => 'female',
                        'has_family' => false,
                        'family_id' => $family->id,
                    ]);
                }
            }
        } else {
            $girls = Person::where([['gender', '=', 'female'], ['family_id', '=', $family->id]])->get();
            foreach ($girls as $g) {
                $g->family_id = null;
                $g->save();
            }
        }

        $grandFatherFamily = Family::find($request->gf_family_id);
        if (isset($grandFatherFamily)) {
            $father->family_id = $grandFatherFamily->id;
            $father->save();
        }

        $family->name = $request->has('name') ? $request->name : $family->name;
        $family->father_id = $father->id;
        $family->mother_id = isset($mother) ? $mother->id : null;
        $family->gf_family_id = isset($grandFatherFamily) ? $grandFatherFamily->id : null;
        $family->children_count = $family->members->count();
        $family->save();

        \App\Helpers\AppHelper::AddLog('Family Create', class_basename($family), $family->id);
        return redirect()->route('admin.families.index')->with('success', 'تم تعديل الأسرة بنجاح.');
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

        return redirect()->route('admin.families.index')->with('success', 'تم حذف الأسرة بنجاح');
    }

    public function addChildren(Request $request)
    {
        $family = Family::findOrFail($request->family_id);

        if (!isset($family)) {
            return back()->with('error', 'حدثت مشكلة.');
        }

        if ($request->has('type')) {
            Person::create([
                'first_name' => $request->name,
                'father_name' => $family->father->first_name,
                'grand_father_name' => $family->father->father_name,
                'surname' => $family->father->grand_father_name,
                'gender' => $request->gender,
                'has_family' => false,
                'family_id' => $family->id,
            ]);

            $family->children_count++;
            $family->save();

            return back()->with('success', 'تم إضافة فرد للأسرة بنجاح.');
        }

        if (isset($request->users)) {
            $oldChildren = Person::where('family_id', '=', $family->id)->get();
            foreach ($oldChildren as $old) {
                $old->family_id = null;
                $old->save();
            }

            foreach ($request->users as $children) {
                $child = Person::find($children);

                if (isset($child)) {
                    $child->family_id = $family->id;
                    $child->save();
                }
            }
        } else {
            $oldChildren = Person::where('family_id', '=', $family->id)->get();
            foreach ($oldChildren as $old) {
                $old->family_id = null;
                $old->save();
            }
        }

        $family->children_count = $family->members->count();
        $family->save();

        return back()->with('success', 'تم اضافة الأبناء بنجاح.');
    }
}
