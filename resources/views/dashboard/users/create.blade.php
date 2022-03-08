@extends('layouts.master')

@section('page-title', $pageTitle)

@section('add-styles')
    <link rel="stylesheet" href="{{ secure_asset('assets/css/select2-rtl.min.css') }}"/>
@endsection

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-2-fill"> </i>'.$menuTitle, 'slots' => [['title' => 'المستخدمين', 'link' => route('admin.users.index')],['title' => $menuTitle, 'link' => route('admin.users.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @include('partials.messages')
                    @include('partials.errors-messages')
                </div>

                <div class="col-lg-12">
                    <form class="d-block" dir="rtl" method="POST" action="{{ route('admin.users.store') }}" id="WithFamily">
                        @csrf
                        <input type="hidden" name="type" value="withFamily" >

                        <div class="card iq-mb-3 shadow">
                            <div class="card-header d-inline-flex justify-content-between">
                                <h5 class="float-left my-auto"><i class="ri-user-2-fill"> </i> {{ $menuTitle }}</h5>
                                <button onclick="showFamilyModel(1)" id="addWithOutFamily" type="button" class="btn btn-outline-secondary rounded-pill mx-2">
                                    اضافة شخص بدون عائلة
                                </button>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="name">{{ __('الاسم') }}</label>
                                        <input type="text" name="name" class="form-control mb-0" id="name" placeholder="{{ __('الاسم') }}" value="{{ old('name') }}" required autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="gender">{{ __('النوع') }}</label>
                                        <select id="gender" name="gender" class="form-control mb-0" required>
                                            <option value="male"{{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('ذكر') }}</option>
                                            <option value="female"{{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('أنثى') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="father_id">{{ __('اسم الأب') }}</label>
                                        <select id="father_id" name="father_id" class="js-states form-control" style="width: 100%;">
                                            <option disabled selected>حدد الأب</option>
                                            @foreach($persons as $per)
                                                <option value="{{ $per->id }}" {{ old('father_id') == $per->id ? 'selected' : '' }}>{{$per->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="mother_id">{{ __('اسم الام') }}</label>
                                        <select id="mother_id" name="mother_id" class="js-states form-control" style="width: 100%;">
{{--                                            <option disabled selected>حدد الأم</option>--}}
                                            <option value="none">لا يوجد</option>
                                            @foreach($mothers as $per)
                                                <option value="{{$per->id}}" {{ old('mother_id') == $per->id ? 'selected' : '' }}>{{$per->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6" >
                                        <label>الحالة الاجتماعية</label>
                                        <br>
                                        <div class="d-inline-flex">
                                            <div class="custom-control custom-radio mx-4" onclick="openMainWifeModel()">
                                                <input type="radio"
                                                        id="family_yes_has_family" name="has_family" value="true"
                                                        class="custom-control-input">
                                                <label class="custom-control-label" for="family_yes_has_family">
                                                    متزوج/ة </label>
                                            </div>
                                            <div class="custom-control custom-radio mx-4" onclick="closeMainWifeModel()">
                                                <input type="radio" id="family_no_has_family" name="has_family"
                                                        value="false"
                                                        class="custom-control-input">
                                                <label class="custom-control-label" for="family_no_has_family"> غير
                                                    متزوج/ة </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="wifeForm" class="d-none form-group col-lg-6">
                                        <label for="wife_id">ابحث و اختر الزوجة، ليتم اضافتها</label>
                                        <select id="wife_id" name="wife_id[]" class="js-example-placeholder-multiple js-states form-control" multiple="multiple" style="width: 100%;">
                                            <option value="none">لا يوجد</option>
                                            @foreach($female as $per)
                                                <option value="{{$per->id}}" {{ old('wife_id') == $per->id ? 'selected' : '' }}>{{$per->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6 py-3">
                                        <label>حدد هذا الخيار اذا كان الشخص متوفي</label>
                                        <div class="d-inline-flex">
                                            <div class="custom-control custom-radio mx-4">
                                                <input type="checkbox" id="is_alive" name="is_alive" class="custom-control-input" onclick=showDate()>
                                                <label class="custom-control-label" for="is_alive"> متوفي </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 d-none" id="death_date">
                                        <label for="death_date_input">تاريخ الوفاه (اختياري)</label>
                                        <input type="date" name="death_date" id="death_date_input" class="form-control mb-0" value="{{ old('death_date') }}">
                                    </div>
                                    <div class="form-group col-lg-6 d-none" id="death_place">
                                        <label for="death_place_input">مكان الوفاه (اختياري)</label>
                                        <input type="text" name="death_place" id="death_place_input" class="form-control mb-0" value="{{ old('death_place') }}">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="surname">اللقب (اختياري)</label>
                                        <input type="text" name="surname" class="form-control mb-0" id="surname" placeholder="اللقب" value="{{ old('surname') }}"  autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="birth_date"> تاريخ الميلاد (اختياري)</label>
                                        <input type="date" name="birth_date" class="form-control mb-0" id="birth_date" placeholder="تاريخ الميلاد" value="{{ old('birth_date') }}"  autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="birth_place">محل الميلاد (اختياري)</label>
                                        <input type="text" name="birth_place" class="form-control mb-0" id="birth_place" placeholder="محل الميلاد" value="{{ old('birth_place') }}"  autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="job">الوظيفة (اختياري)</label>
                                        <input type="text" name="job" class="form-control mb-0" id="job" placeholder="الوظيفة" value="{{ old('job') }}"  autofocus>
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer text-muted">
                                <button type="submit" class="btn px-5 btn-primary rounded-pill"><i class="ri-save-2-fill"> </i>حفظ </button>
                            </div>
                        </div>
                        <br>

                        <div class="modal fade" id="FamilyModel" tabindex="-1" role="dialog" aria-labelledby="FamilyModelLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="FamilyModelLabel"><i class="ri-user-fill"> </i>ادخال بيانات الزوجة </h5>
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
                                            <input type="text" name="partner_father_name" class="form-control mb-0" id="partner_father_name" value="{{ old('partner_father_name') }}" placeholder="أدخل اسم الاب">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partner_grand_father_name">{{ __('اسم الجد') }}</label>
                                            <input type="text" name="partner_grand_father_name" class="form-control mb-0" id="partner_grand_father_name" value="{{ old('partner_grand_father_name') }}" placeholder="اسم الجد">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partner_surname">{{ __('اللقب') }}</label>
                                            <input type="text" name="partner_surname" class="form-control mb-0" id="partner_surname" value="{{ old('partner_surname') }}" placeholder="أدخل اللقب">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partner_email">{{ __('البريد الإلكتروني') }}</label>
                                            <input type="email" name="partner_email" class="form-control mb-0" id="partner_email" value="{{ old('partner_email') }}" placeholder="أدخل البريد الإلكتروني">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partnerMobile">{{ __('رقم الجوال') }}</label>
                                            <input type="text" name="partner_mobile" class="form-control numeric mb-0" id="partnerMobile" placeholder="أدخل رقم الجوال" value="{{ old('partner_mobile') }}"  >
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <label>حدد هذا الخيار اذا كان الشخص متوفي</label>
                                            <div class="d-inline-flex">
                                                <div class="custom-control custom-radio mx-4">
                                                    <input type="checkbox" id="partner_is_alive" name="partner_is_alive" class="custom-control-input">
                                                    <label class="custom-control-label" for="partner_is_alive"> متوفي </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-primary w-100 py-2">موافق</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form class="d-none" dir="rtl" method="POST" action="{{ route('admin.users.store') }}" id="NoFamilyId" >
                        @csrf

                        <div class="card iq-mb-3 shadow">
                        <div class="card-header d-inline-flex justify-content-between">
                            <h5 class="float-left my-auto"><i class="ri-user-2-fill"> </i> {{ $menuTitle }}</h5>

                            <button onclick="showFamilyModel(2)" id="addWithFamily" type="button" class="btn btn-outline-secondary rounded-pill mx-2 d-none">
                                اضافة شخص مع عائلة
                            </button>
                        </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="name">{{ __('الاسم') }}</label>
                                        <input type="text" name="name" class="form-control mb-0" id="name" placeholder="{{ __('الاسم') }}" value="{{ old('name') }}" required autofocus>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="father_name">{{ __('اسم الأب') }}</label>
                                        <input type="text" name="father_name" class="form-control mb-0" id="father_name" placeholder="{{ __('اسم الأب') }}" value="{{ old('father_name') }}" required autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="grand_father_name">{{ __('اسم الجد') }}</label>
                                        <input type="text" name="grand_father_name" class="form-control mb-0" id="grand_father_name" placeholder="{{ __('اسم الجد') }}" value="{{ old('grand_father_name') }}"  autofocus>
                                    </div>

                                    <input type="hidden" name="type" value="noFamily" >

                                    <div class="form-group col-lg-6">
                                        <label for="gender">{{ __('النوع') }}</label>
                                        <select id="gender" name="gender" class="form-control mb-0" required>
                                            <option value="male">{{ __('ذكر') }}</option>
                                            <option value="female">{{ __('أنثى') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6" >
                                        <label>الحالة الاجتماعية</label>
                                        <br>
                                        <div class="d-inline-flex">
                                            <div class="custom-control custom-radio mx-4" onclick="openMainWifeModel()">
                                                <input type="radio" id="yes_has_family" name="has_family" value="true"
                                                       class="custom-control-input">
                                                <label class="custom-control-label" for="yes_has_family">متزوج/ة </label>
                                            </div>
                                            <div class="custom-control custom-radio mx-4" onclick="closeMainWifeModel()">
                                                <input type="radio" id="no_has_family" name="has_family"
                                                       value="false" class="custom-control-input">
                                                <label class="custom-control-label" for="no_has_family"> غير متزوج/ة </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6 py-4">
                                        <label>حدد هذا الخيار اذا كان الشخص متوفي</label>
                                        <div class="d-inline-flex">
                                            <div class="custom-control custom-radio mx-4">
                                                <input type="checkbox" id="no_family_is_alive" name="no_family_is_alive" class="custom-control-input" onclick=noFamilyShowDate()>
                                                <label class="custom-control-label" for="no_family_is_alive"> متوفي </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 d-none" id="no_family_death_date">
                                        <label for="date">تاريخ الوفاه</label>
                                        <input type="date" name="death_date" class="form-control mb-0" id="date" value="{{ old('death_date') }}">
                                    </div>
                                    <div class="form-group col-lg-6 d-none" id="no_family_death_place">
                                        <label for="death_place">مكان الوفاه</label>
                                        <input type="text" name="death_place" class="form-control mb-0" value="{{ old('death_place') }}">
                                    </div>


                                    <div class="form-group col-lg-6">
                                        <label for="no_family_surname">اللقب (اختياري)</label>
                                        <input type="text" name="no_family_surname" class="form-control mb-0" id="no_family_surname" placeholder="اللقب" value="{{ old('surname') }}"  autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="no_family_birth_date"> تاريخ الميلاد (اختياري)</label>
                                        <input type="date" name="no_family_birth_date" class="form-control mb-0" id="no_family_birth_date" placeholder="تاريخ الميلاد" value="{{ old('birth_date') }}"  autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="no_family_birth_place">محل الميلاد (اختياري)</label>
                                        <input type="text" name="no_family_birth_place" class="form-control mb-0" id="no_family_birth_place" placeholder="محل الميلاد" value="{{ old('birth_place') }}"  autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="no_family_job">الوظيفة (اختياري)</label>
                                        <input type="text" name="no_family_job" class="form-control mb-0" id="no_family_job" placeholder="الوظيفة" value="{{ old('job') }}"  autofocus>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-muted">
                                <button type="submit" class="btn px-5 btn-primary rounded-pill"><i class="ri-save-2-fill"> </i>حفظ </button>
                            </div>
                        </div>
                        <br>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('add-scripts')

<script>
    $(document).ready(function() {
        $('#father_id').select2({
            placeholder: 'حدد الأب',
            closeOnSelect: true,
            allowClear: true,
            tags: true,
            dir: 'rtl',
            language: 'ar',
            width: '100%',
        });
        $('#mother_id').select2({
            placeholder: "حدد الام",
            closeOnSelect: true,
            allowClear: true,
            tags: true,
            dir: 'rtl',
            language: 'ar',
            width: '100%',
        });
        $('#wife_id').select2({
            placeholder: 'حدد الزوجة',
            closeOnSelect: true,
            allowClear: true,
            tags: true,
            dir: 'rtl',
            language: 'ar',
            width: '100%',
        });
    });

    function showDate(){
        if($('#death_date').hasClass('d-none')){
            $('#death_date').removeClass('d-none').addClass('d-block');
            $('#death_place').removeClass('d-none').addClass('d-block');
        }
        else{
            $('#death_date').removeClass('d-block').addClass('d-none');
            $('#death_place').removeClass('d-block').addClass('d-none');
        }
    }

    function noFamilyShowDate(){
        if($('#no_family_death_date').hasClass('d-none')){
            $('#no_family_death_date').removeClass('d-none').addClass('d-block');
            $('#no_family_death_place').removeClass('d-none').addClass('d-block');
        }
        else{
            $('#no_family_death_date').removeClass('d-block').addClass('d-none');
            $('#no_family_death_place').removeClass('d-block').addClass('d-none');
        }
    }

    function showFamilyModel(value){
        if(value == 2){
            $('#WithFamily').removeClass('d-none').addClass('d-block');
            $('#NoFamilyId').removeClass('d-block').addClass('d-none');
        }
        else{
            $('#NoFamilyId').removeClass('d-none').addClass('d-block');
            $('#WithFamily').removeClass('d-block').addClass('d-none');
        }
    }

    function changeSelect(value){
        if(value == 1){
            $("#FamilyModel").modal('show')
        }
    }

    function closeMainWifeModel() {
        $("#wifeForm").removeClass('d-block').addClass('d-none');
    }

    function openMainWifeModel() {
        $("#wifeForm").removeClass('d-none').addClass('d-block');
    }

    function openWifeModel() {
        $("#FamilyModel").modal('show')
    }

    $("#addWithOutFamily").click(() => {
        $("#addWithOutFamily").addClass('d-none');
        $("#addWithFamily").removeClass('d-none');
    });

    $("#addWithFamily").click(() => {
        $("#addWithFamily").addClass('d-none');
        $("#addWithOutFamily").removeClass('d-none');
    });

</script>
@endsection
