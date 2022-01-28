<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CityController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:cities.read')->only(['index', 'show']);
        $this->middleware('permission:cities.create')->only(['create', 'store']);
        $this->middleware('permission:cities.update')->only(['edit', 'update']);
        $this->middleware('permission:cities.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'الدول و المدن';
        $pageTitle = 'لوحة التحكم';
//        $cities = City::all();
        $cities = City::paginate(20);

        return view('dashboard.cities.index', compact('appMenu', 'menuTitle', 'pageTitle', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'اضافة مدينة';
        $pageTitle = 'لوحة التحكم';

        return view('dashboard.cities.create', compact('appMenu', 'menuTitle', 'pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_en' => ['required'],
            'name_ar' => ['required'],
            'country_en' => ['nullable'],
            'country_ar' => ['required'],
        ]);

        $request['slug'] = Str::slug($request->name_en);
        $request['status'] = $request->status == 'on';

        $city = City::create($request->all());

        \App\Helpers\AppHelper::AddLog('City Create', class_basename($city), $city->id);
        return redirect()->route('admin.cities.index')->with('success', 'تم اضافة مدينة جديدة و يمكنك استخدامها.');
    }

    /**
     * Display the specified resource.
     *
     * @param City $city
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(City $city)
    {
        return redirect()->route('admin.cities.edit', $city);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return bool|\Illuminate\Auth\Access\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(City $city)
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'تعديل مدينة';
        $pageTitle = 'لوحة التحكم';

        return view('dashboard.cities.update', compact('appMenu', 'menuTitle', 'pageTitle', 'city'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        $request->validate([
            'name_en' => ['required'],
            'name_ar' => ['required'],
            'country_en' => ['nullable'],
            'country_ar' => ['required'],
        ]);

        $city->slug = Str::slug($request->name_en);
        $city->name_en = $request->name_en;
        $city->name_ar = $request->name_ar;
        $city->country_en = $request->country_en;
        $city->country_ar = $request->country_ar;
        $city->status = $request->status == 'on';
        $city->save();

        \App\Helpers\AppHelper::AddLog('City Update', class_basename($city), $city->id);
        return redirect()->route('admin.cities.index')->with('success', 'تم تعديل بيانات المدينة بنجاح.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();
        \App\Helpers\AppHelper::AddLog('City Delete', class_basename($city), $city->id);
        return redirect()->route('admin.cities.index')->with('success', 'تم حذف بيانات المدينة بنجاح.');
    }
}
