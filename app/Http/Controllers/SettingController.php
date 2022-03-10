<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Traits\HasImage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use HasImage;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:settings.read')->only('show');
        $this->middleware('permission:settings.update')->only('update');
    }

    /**
     * Display the specified resource.
     *
     * @return bool|\Illuminate\Auth\Access\Response|Application|Factory|View
     */
    public function show()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'الاعدادات';
        $pageTitle = 'لوحة التحكم';
        $settingData = Setting::first();
        $rolesData = \Spatie\Permission\Models\Role::where('name', '!=', 'Super Admin')->get();
        $fathers = \App\Models\Person::where('gender', 'male')->get();

        return view('dashboard.settings', compact(
            'appMenu', 'pageTitle', 'menuTitle', 'settingData', 'rolesData', 'fathers'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $setting = Setting::find(1)->first();

        $request->validate([
            'app_title_ar' => ['required'],
            'family_name_ar' => ['required'],
            'app_contact_ar' => ['required'],
            'app_description_ar' => ['required'],
            'app_about_ar' => ['required'],
            'app_terms_ar' => ['required'],
            'app_icon' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:20000'],
            'app_logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:20000'],
            'family_tree_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:20000'],
            'default_user_role' => ['required', 'exists:roles,id'],
            'oldest_person' => ['required', 'exists:persons,id'],
            'full_name_count' => ['required', 'numeric'],
        ]);

        $setting->family_name_ar = $request->family_name_ar;
//        $setting->family_name_en = $request->family_name_en;
        $setting->app_title_ar = $request->app_title_ar;
//        $setting->app_title_en = $request->app_title_en;
        $setting->app_description_ar = $request->app_description_ar;
//        $setting->app_description_en = $request->app_description_en;
        $setting->app_about_ar = $request->app_about_ar;
//        $setting->app_about_en = $request->app_about_en;
        $setting->app_contact_ar = $request->app_contact_ar;
//        $setting->app_contact_en = $request->app_contact_en;
        $setting->app_terms_ar = $request->app_terms_ar;
//        $setting->app_terms_en = $request->app_terms_en;
        if ($request->hasfile('app_icon')) {
            $setting->app_icon = $this->ImageUpload($request->file('app_icon'), $setting->photoPath, 'icon');
        }
        if ($request->hasfile('app_logo')) {
            $setting->app_logo = $this->ImageUpload($request->file('app_logo'), $setting->photoPath, 'logo');
        }
        if ($request->hasfile('family_tree_image')) {
            $setting->family_tree_image = $this->ImageUpload($request->file('family_tree_image'), $setting->photoPath, 'family_tree_image');
        }
        $setting->default_user_role = $request->default_user_role;
        $setting->app_registration = $request->app_registration == 'on';
        $setting->app_first_registration = $request->app_first_registration == 'on';
        $setting->app_comments = $request->app_comments == 'on';
        $setting->oldest_person = $request->oldest_person;
        $setting->full_name_count = $request->full_name_count;

        if ($setting->isDirty()) {
            $setting->save();
            return back()->with('success', 'تم تحديث الاعدادت بنجاح.');
        }

        return back();
    }

}
