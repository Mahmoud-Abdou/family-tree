@extends('layouts.master')

@section('page-title', $pageTitle)

@section('add-styles')

@endsection

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-settings-2-fill"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('admin.settings.show')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <i class="ri-settings-2-fill mx-2"></i>
                            اعدادات التطبيق
                        </div>
                        <div class="card-body">

                            @include('partials.messages')
                            @include('partials.errors-messages')

                            <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="app_title_ar">عنوان التطبيق</label>
                                        <input type="text" class="form-control" name="app_title_ar" id="app_title_ar" value="{{ $settingData->app_title_ar }}">
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="family_name_ar">اسم العائلة</label>
                                        <input type="text" class="form-control" name="family_name_ar" id="family_name_ar" value="{{ $settingData->family_name_ar }}">
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="app_contact_ar">البريد الالكتروني للتواصل</label>
                                        <input type="email" class="form-control" name="app_contact_ar" id="app_contact_ar" value="{{ $settingData->app_contact_ar }}">
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="app-icon">ايقونة التطبيق</label>
                                        <div class="image-upload-wrap d-none">
                                            <input id="app-icon" class="file-upload-input" type="file" name="app_icon" value="{{ old('app_icon') }}" onchange="readURL(this);" accept="image/png,image/jpeg,image/jpg,image/icon" />
                                            <div class="drag-text">
                                                <h3 class="m-4"><i class="ri-upload-2-line"> </i>اضغط أو اسحب صورة لرفعها</h3>
                                            </div>
                                        </div>
                                        <div id="app-icon-content" class="file-upload-content d-block">
                                            <img class="file-upload-image" src="{{ $settingData->app_icon }}" alt="App Icon" />
                                            <div class="image-title-wrap">
                                                <button type="button" class="remove-image">حذف <span class="image-title">الصورة المرفوعة</span></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="app-logo">شعار التطبيق</label>
                                        <div class="image-upload-wrap d-none">
                                            <input id="app-logo" class="file-upload-input" type="file" name="app_logo" value="{{ old('app_logo') }}" onchange="readURL(this);" accept="image/png,image/jpeg,image/jpg" />
                                            <div class="drag-text">
                                                <h3 class="m-4"><i class="ri-upload-2-line"> </i>اضغط أو اسحب صورة لرفعها</h3>
                                            </div>
                                        </div>
                                        <div id="app-logo-content" class="file-upload-content d-block">
                                            <img class="file-upload-image" src="{{ $settingData->app_logo }}" alt="App Logo" />
                                            <div class="image-title-wrap">
                                                <button type="button" class="remove-image">حذف <span class="image-title">الصورة المرفوعة</span></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="app_registration" id="app_registration" {{ $settingData->app_registration ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="app_registration">تفعيل الحساب تلقائي بعد الاشتراك</label>
                                            <p>عند تفعيل هذا الخيار سيتم تفعيل الحسابات بشكل تلقائي عند الاشتراك.</p>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="default_user_role">الصلاحيات الافتراضية</label>
                                        <select class="form-control" id="default_user_role" name="default_user_role">
                                            <option disabled="">حدد الصلاحية</option>
                                            @foreach($rolesData as $role)
                                                <option value="{{ $role->id }}" {{ $settingData->default_user_role == $role->id ? 'selected=""' : '' }}>{{ $role->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="app_description_ar">وصف التطبيق</label>
                                        <textarea class="form-control" name="app_description_ar" id="app_description_ar" rows="2">{!! $settingData->app_description_ar !!}</textarea>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="app_about_ar">نبذة عن التطبيق</label>
                                        <textarea class="form-control" name="app_about_ar" id="app_about_ar" rows="2">{!! $settingData->app_about_ar !!}</textarea>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="app_terms_ar">الشروط و الأحكام</label>
                                        <textarea class="form-control" name="app_terms_ar" id="app_terms_ar" rows="2">{!! $settingData->app_terms_ar !!}</textarea>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="family-tree-image">صورة شجرة العائلة</label>
                                        <div id="family-tree-image-wrap" class="image-upload-wrap d-none">
                                            <input id="family-tree-image" class="file-upload-input" type="file" name="family_tree_image" value="{{ old('family_tree_image') }}" onchange="readURL(this);" accept="image/png,image/jpeg,image/jpg" />
                                            <div class="drag-text">
                                                <h3 class="m-4"><i class="ri-upload-2-line"> </i>اضغط أو اسحب صورة لرفعها</h3>
                                            </div>
                                        </div>
                                        <div id="family-tree-image-content" class="file-upload-content d-block">
                                            <img class="file-upload-image" src="{{ $settingData->family_tree_image }}" alt="Family Tree Image" />
                                            <div class="image-title-wrap">
                                                <button type="button" class="remove-image">حذف <span class="image-title">الصورة المرفوعة</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>
                        <div class="card-footer text-muted d-flex inline-flex justify-content-between">
                            <div class="d-flex">
                                <button type="submit" class="btn px-4 btn-primary rounded-pill"><i class="ri-save-2-fill"> </i>حفظ التعديلات</button>
                                <p class="my-auto mx-4">ملاحظة: هذه التعديلات ستؤثر بشكل مباشر في اعدادات التطبيق.</p>
                            </div>

                            <div class="d-flex">
                                <i class="ri-time-fill"></i>
                                آخر تعديل تم في
                                <span class="mx-2">{{ $settingData->updated_at }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('add-scripts')
{{--    <script src="{{ secure_asset('assets/js/jquery-3.6.0.slim.min.js') }}"></script>--}}
    <script src="{{ secure_asset('assets/js/tinymce/tinymce.min.js') }}"></script>

    <script>
        // TODO: fix error SyntaxError: Unexpected token '<' tinymce
        tinymce.init({
            selector: 'textarea',
            plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker advlist link image charmap print preview hr anchor pagebreak searchreplace wordcount nonbreaking',
            // plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker advlist link image charmap print preview hr anchor pagebreak searchreplace wordcount fullscreen nonbreaking',
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor',
            // toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor | fullscreen',
            toolbar_mode: 'floating',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Al Falak World',
            fullscreen_new_window : true,
            fullscreen_settings : {
                theme_advanced_path_location : "top"
            },
            language : "{{ app()->getLocale() }}",
            menubar: false,
            statusbar: false
        });
    </script>
@endsection
