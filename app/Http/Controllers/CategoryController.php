<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Traits\HasImage;
use Illuminate\Support\Str;

class CategoryController extends Controller
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
        $this->middleware('permission:categories.read')->only(['index', 'show']);
        $this->middleware('permission:categories.create')->only(['create', 'store']);
        $this->middleware('permission:categories.update')->only(['edit', 'update']);
        $this->middleware('permission:categories.delete')->only('destroy');
    }

    public function index()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'التصنيفات';
        $pageTitle = 'لوحة التحكم';
        $categories = Category::paginate(20);

        return view('dashboard.categories.index', compact('appMenu', 'menuTitle', 'pageTitle', 'categories'));
    }

    public function create()
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'اضافة تصنيف';
        $pageTitle = 'لوحة التحكم';
        $types = config('custom.category-types');

        return view('dashboard.categories.create', compact('appMenu', 'menuTitle', 'pageTitle', 'types'));
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = new Category();
        $category->fill($request->all());
        $category->slug = Str::slug($request->name_en);

        if ($request->hasfile('icon')) {
            $category->icon = $this->ImageUpload($request->file('icon'), $category->photoPath, $category->slug.'-icon');
        }
        if ($request->hasfile('image')) {
            $category->image = $this->ImageUpload($request->file('image'), $category->photoPath, $category->slug.'-image');
        }
        $category->save();

        \App\Helpers\AppHelper::AddLog('$category Create', class_basename($category), $category->id);
        return redirect()->route('admin.categories.index')->with('success', 'تم اضافة تصنيف جديد و يمكنك استخدامها.');
    }

    public function show(Category $category)
    {
        return redirect()->route('admin.categories.edit', $category);
    }

    public function edit(Category $category)
    {
        $appMenu = config('custom.app_menu');
        $menuTitle = 'تعديل تصنيف';
        $pageTitle = 'لوحة التحكم';
        $types = config('custom.category-types');

        return view('dashboard.categories.update', compact('appMenu', 'menuTitle', 'pageTitle', 'types', 'category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->fill($request->all());
        $category->slug = Str::slug($request->name_en);

        if ($request->hasfile('icon')) {
            $category->icon = $this->ImageUpload($request->file('icon'), $category->photoPath, $category->slug.'-icon');
        }
        if ($request->hasfile('image')) {
            $category->image = $this->ImageUpload($request->file('image'), $category->photoPath, $category->slug.'-image');
        }

        if($category->isDirty()) {
            $category->save();

            \App\Helpers\AppHelper::AddLog('Category Create', class_basename($category), $category->id);
            return redirect()->route('admin.categories.index')->with('success', 'تم تعديل التصنيف بنجاح.');
        }

        return redirect()->route('admin.categories.index');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        \App\Helpers\AppHelper::AddLog('Category Delete', class_basename($category), $category->id);
        return redirect()->route('admin.cities.index')->with('success', 'تم حذف بيانات التصنيف بنجاح.');
    }
}
