@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-2-fill"> </i>'.$menuTitle, 'slots' => [['title' => 'الملف الشخصي', 'link' => route('profile')],['title' => $menuTitle, 'link' => route('profile')]]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    <div class="iq-card shadow">
                        <div class="iq-card-body p-0">
                            <div class="iq-edit-list">
                                <ul class="iq-edit-profile d-flex nav nav-pills">
                                    <li class="col-md-6 p-0">
                                        <a class="nav-link active" data-toggle="pill" href="#personal-information">
                                            تعديل الملف الشخصي
                                        </a>
                                    </li>

                                    <li class="col-md-6 p-0">
                                        <a class="nav-link" data-toggle="pill" href="#manage-secret">
                                            تعديل بيانات الدخول
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    @include('partials.messages')
                    @include('partials.errors-messages')
                </div>

            <div class="tab-content col-lg-12">
                <div class="tab-pane fade active show" id="personal-information" role="tabpanel">
                    <div class="card iq-mb-3 shadow">
                        <div class="card-header">
                            <h5 class="my-auto"><i class="ri-user-2-fill"> </i> {{ $menuTitle }}</h5>
                        </div>

                        <form dir="rtl" class="mt-4" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="remove_photo" id="remove_photo" value="false">

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label for="first_name">الاسم الأول</label>
                                        <input type="text" name="first_name" class="form-control mb-0" id="first_name" tabindex="1" value="{{ $person->first_name }}" required autofocus>
                                    </div>

                                    <div class="form-group col-lg-4">
                                        <label for="father_name">اسم الأب</label>
                                        <input type="text" name="father_name" class="form-control mb-0" id="father_name" tabindex="2" value="{{ $person->father_name }}" required>
                                    </div>

                                    <div class="form-group col-lg-4">
                                        <label for="grand_father_name">اسم الجد</label>
                                        <input type="text" name="grand_father_name" class="form-control mb-0" id="grand_father_name" tabindex="3" value="{{ $person->grand_father_name }}" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-4">
                                        <label for="prefix">مقدمة الاسم</label>
                                        <input type="text" name="prefix" class="form-control mb-0" id="prefix" tabindex="4" value="{{ $person->prefix }}">
                                    </div>

                                    <div class="form-group col-lg-4">
                                        <label for="surname">اللقب</label>
                                        <input type="text" name="surname" class="form-control mb-0" id="surname" tabindex="5" value="{{ $person->surname }}">
                                    </div>

                                    <div class="form-group col-lg-4">
                                        <label for="job">العمل / الوظيفة</label>
                                        <input type="text" name="job" class="form-control mb-0" id="job" tabindex="6" value="{{ $person->job }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <div>
                                            <label>النوع</label>
                                            <br>
                                            <div class="d-inline-flex">
                                                <div class="custom-control custom-radio mx-4">
                                                    <input type="radio" id="male" name="gender" value="male" class="custom-control-input" {{ $person->gender == 'male' ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="male"> ذكر </label>
                                                </div>
                                                <div class="custom-control custom-radio mx-4">
                                                    <input type="radio" id="female" name="gender" value="female" class="custom-control-input" {{ $person->gender == 'female' ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="female"> أنثى </label>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div>
                                            <label>الحالة الاجتماعية</label>
                                            <br>
                                            <div class="d-inline-flex">
                                                <div class="custom-control custom-radio mx-4">
                                                    <input onclick="openMainWifeModel()" type="radio" id="yes_has_family" name="has_family" value="true" class="custom-control-input" {{ $person->has_family ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="yes_has_family"> متزوج/ة </label>
                                                </div>
                                                <div class="custom-control custom-radio mx-4">
                                                    <input type="radio" id="no_has_family" name="has_family" value="false" class="custom-control-input" {{ !$person->has_family ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="no_has_family"> غير متزوج/ة </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="photo">الصورة الشخصية</label>
                                        <div class="image-upload-wrap d-none">
                                            <input id="photo" class="file-upload-input" type="file" name="photo" value="{{ old('photo') }}" onchange="readURL(this);" accept="image/png,image/jpeg,image/jpg"/>
                                            <div class="drag-text">
                                                <h3 class="m-4"><i class="ri-upload-2-line"> </i>اضغط أو اسحب صورة لرفعها</h3>
                                            </div>
                                        </div>
                                        <div id="photo-content" class="file-upload-content d-block">
                                            <img class="file-upload-image" src="{{ $person->photo }}" alt="Person Photo"/>
                                            <div class="image-title-wrap">
                                                <button type="button" id="remove_photo_btn" class="remove-image">حذف <span class="image-title">الصورة المرفوعة</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="bio">السيرة الذاتية</label>
                                        <textarea class="form-control" name="bio" id="bio" rows="2">{!! $person->bio !!}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="birth_place">مكان الميلاد</label>
                                        <input type="text" name="birth_place" class="form-control mb-0" id="birth_place" value="{{ $person->birth_place }}">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="birth_date">تاريخ الميلاد</label>
                                        <input type="date" name="birth_date" class="form-control mb-0" id="birth_date" value="{{ $person->birth_date }}">
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-muted">
                                <div class="row flex inline-flex justify-content-between p-2 mx-2">
                                    <button type="submit" class="btn px-5 btn-primary rounded-pill " tabindex="5"><i class="ri-save-2-fill"> </i>حفظ</button>
                                    <div class="text-muted my-2">
                                        <i class="ri-time-fill mx-2"></i>
                                        آخر تعديل تم في
                                        <span class="mx-2">{{ $person->updated_at }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="familyModal" tabindex="-1" role="dialog" aria-labelledby="familyModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content shadow">
                                    <div class="modal-header bg-primary">
                                        <h5 class="modal-title" id="familyModalLabel"><i class="ri-group-2-fill"> </i>اضافة فرد للعائلة</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    
                                        <div class="modal-body">
                                            <input id="familyId" type="hidden" name="family_id">

                                            <div class="form-group">
                                                <label for="selectUser">ابحث و اختر الشخص، ليتم اضافته</label>
                                                <select id="selectUser" name="wife_id" class="js-states form-control" style="width: 100%;">
                                                    <option value="add">اختر زوجة او اضف</option>
                                                    @foreach($female as $per)
                                                        <option value="{{$per->id}}">{{$per->full_name}}</option>
                                                    @endforeach
                                                </select>
                                                <br>
                                                <br>
                                                <button type="button" data-dismiss="modal" class="btn btn-primary rounded-pill m-1" data-toggle="modal" data-target="#newPersonModal" onclick="openWifeModel()"><i class="ri-add-fill"> </i>اضف شخص غير موجود</button>

                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-primary w-100 py-2">موافق</button>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="newFamilyModel" tabindex="-1" role="dialog" aria-labelledby="NewFamilyModelLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="NewFamilyModelLabel"><i class="ri-user-fill"> </i>ادخال بيانات الزوج/ة </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group col-lg-12">
                                            <label for="partner_first_name">{{ __('الاسم') }}</label>
                                            <input type="text" name="partner_first_name" class="form-control mb-0" id="partner_first_name" value="{{ old('partner_first_name') }}" placeholder="أدخل اﻷسم ">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partner_father_name">{{ __('اسم الأب') }}</label>
                                            <input type="text" name="partner_father_name" class="form-control mb-0" id="partner_father_name" value="{{ old('partner_father_name') }}" placeholder="أدخل أسم اﻷب ">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partner_email">{{ __('البريد الإلكتروني') }}</label>
                                            <input type="email" name="partner_email" class="form-control mb-0" id="partner_email" value="{{ old('partner_email') }}" placeholder="أدخل البريد الإلكتروني">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partnerMobile">{{ __('رقم الجوال') }}</label>
                                            <input type="text" name="partner_mobile" class="form-control numeric mb-0" id="partnerMobile" placeholder="أدخل رقم الجوال" value="{{ old('partner_mobile') }}" >
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-primary w-100 py-2">موافق</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="manage-secret" role="tabpanel">

                    <div class="card iq-mb-3 shadow">
                        <div class="card-header">
                            <h5 class="my-auto"><i class="ri-shield-user-fill"> </i> تعديل بيانات الدخول </h5>
                        </div>

                        <form dir="rtl" class="mt-4" method="POST" action="{{ route('profile.update-user') }}">
                            @csrf

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="mobile">الجوال</label>
                                        <input type="text" name="mobile" class="form-control mb-0" id="mobile" value="{{ $user->mobile }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="email">البريد الالكتروني</label>
                                        <input type="email" name="email" class="form-control mb-0" id="email" value="{{ $user->email }}" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="password">كلمة المرور</label>
                                        <input type="password" name="password" class="form-control mb-0" id="password">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="password_confirmation">تأكيد كلمة المرور</label>
                                        <input type="password" name="password_confirmation" class="form-control mb-0" id="password_confirmation">
                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-muted">
                                <div class="row flex inline-flex justify-content-between p-2 mx-2">
                                    <button type="submit" class="btn px-5 btn-primary rounded-pill"><i class="ri-save-2-fill"> </i>حفظ </button>
                                    <p class="my-2">ملاحظة: عند تعديل بيانات الدخول سيتم تسجيل خروج من النظام.</p>

                                    <div class="text-muted my-2">
                                        <i class="ri-time-fill mx-2"></i>
                                        آخر تعديل تم في
                                        <span class="mx-2">{{ $user->updated_at }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </form>
            </div>
            </div>
        </div>
    </div>
@endsection

@section('add-scripts')
    <script src="{{ secure_asset('assets/js/tinymce/tinymce.min.js') }}"></script>

    <script>
        tinymce.init({
            selector: 'textarea',
            // plugins: 'a11ychecker advcode casechange export formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker advlist link image charmap print preview hr anchor pagebreak searchreplace wordcount nonbreaking',
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media | forecolor backcolor',
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

    <script>
        $('#remove_photo_btn').click(function(){
            $('#remove_photo').val('true');
        });

        function openMainWifeModel(){
            $("#familyModal").modal('show')
        }
        function openWifeModel(){
            $("#familyModal").modal('hide')
            $("#newFamilyModel").modal('show')
        }
    </script>
@endsection
