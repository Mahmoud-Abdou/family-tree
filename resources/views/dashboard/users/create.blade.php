@extends('layouts.master')

@section('page-title', $pageTitle)

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

                    <form dir="rtl" method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <div class="card iq-mb-3 shadow">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-user-2-fill"> </i> {{ $menuTitle }}</h5>
                        </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="name">{{ __('الاسم') }}</label>
                                        <input type="text" name="name" class="form-control mb-0" id="name" tabindex="1" placeholder="{{ __('الاسم') }}" value="{{ old('name') }}" required autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="gender">{{ __('النوع') }}</label>
                                        <select id="gender" name="gender" tabindex="3" class="form-control mb-0" required>
                                            <option value="male"{{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('ذكر') }}</option>
                                            <option value="female"{{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('أنثى') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="father_id">{{ __('اسم الأب') }}</label>
                                        <select id="father_id" name="father_id" class="js-states form-control" style="width: 100%;">
                                            <option disabled selected>حدد الأب</option>
                                            @foreach($persons as $per)
                                                <option value="{{$per->id}}">{{$per->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="mother_id">{{ __('اسم الام') }}</label>
                                        <select id="mother_id" name="mother_id" class="js-states form-control" style="width: 100%;">
                                            <option disabled selected>حدد الأم</option>
                                            @foreach($mothers as $per)
                                                <option value="{{$per->id}}">{{$per->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6" >
                                        <label>الحالة الاجتماعية</label>
                                        <br>
                                        <div class="d-inline-flex ">
                                            <div class="custom-control custom-radio mx-4" onclick="openMainWifeModel()">
                                                <input type="radio"
                                                        id="yes_has_family" name="has_family" value="true"
                                                        class="custom-control-input" >
                                                <label class="custom-control-label" for="yes_has_family">
                                                    متزوج/ة </label>
                                            </div>
                                            <div class="custom-control custom-radio mx-4" onclick="closeMainWifeModel()">
                                                <input type="radio" id="no_has_family" name="has_family"
                                                        value="false"
                                                        class="custom-control-input" >
                                                <label class="custom-control-label" for="no_has_family"> غير
                                                    متزوج/ة </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="wifeForm" class="d-none form-group col-lg-6" >
                                        <label for="wife_id">ابحث و اختر الزوجة، ليتم اضافتها</label>
                                        <select id="wife_id" name="wife_id" class="js-states form-control"
                                                style="width: 100%;">
                                            <option value="add" disabled selected>اختر زوجة </option>
                                            <option value="add" selected>اضف زوجة </option>
                                            @foreach($female as $per)
                                                <option value="{{$per->id}}">{{$per->full_name}}</option>
                                            @endforeach
                                        </select>
                                        <button type="button" data-dismiss="modal"
                                                class="btn btn-primary rounded-pill m-2 py-2 px-3" data-toggle="modal"
                                                data-target="#newPersonModal" onclick="openWifeModel()"><i
                                                class="ri-add-fill"> </i>اضف زوجة غير موجود
                                        </button>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label>حدد هذا الخيار اذا كان الشخص متوفي</label>
                                        <div class="d-inline-flex">
                                            <div class="custom-control custom-radio mx-4">
                                                <input type="checkbox" id="is_alive" name="is_alive" class="custom-control-input" onclick=showDate()>
                                                <label class="custom-control-label" for="is_alive"> متوفي </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6 d-none" id="death_date">
                                        <label for="date">تاريخ الوفاه</label>
                                        <input type="date" name="death_date" class="form-control mb-0" id="date" value="{{ old('date') }}">
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
                                            <input type="text" name="partner_first_name" class="form-control mb-0" id="partner_first_name" value="{{ old('partner_first_name') }}"placeholder="أدخل اﻷسم ">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partner_father_name">{{ __('اسم الأب') }}</label>
                                            <input type="text" name="partner_father_name" class="form-control mb-0" id="partner_father_name" value="{{ old('partner_father_name') }}" placeholder="أدخل اسم الاب">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partner_email">{{ __('البريد الإلكتروني') }}</label>
                                            <input type="email" name="partner_email" class="form-control mb-0" id="partner_email" value="{{ old('partner_email') }}" placeholder="أدخل البريد الإلكتروني">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partnerMobile">{{ __('رقم الجوال') }}</label>
                                            <input type="text" name="partner_mobile" class="form-control numeric mb-0" id="partnerMobile" placeholder="أدخل رقم الجوال" value="{{ old('partner_mobile') }}"  >
                                        </div>

                                        <div class="form-group col-lg-8">
                                            <label>الحالة</label>
                                            <br>
                                            <div class="d-inline-flex">
                                                <div class="custom-control custom-radio mx-4">
                                                    <input type="checkbox" id="partner_is_alive" name="partner_is_alive" class="custom-control-input" >
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

                </div>
            </div>
        </div>
    </div>
@endsection
@section('add-scripts')

<script>
    $(document).ready(function() {
        $('#father_id').select2({
            placeholder: 'حدد الاب',
            closeOnSelect: true,
            dir: 'rtl',
            language: 'ar',
            width: '100%',
        });
        $('#mother_id').select2({
            placeholder: 'حدد الام',
            closeOnSelect: true,
            dir: 'rtl',
            language: 'ar',
            width: '100%',
        });

        $('#wife_id').select2({
            placeholder: 'حدد الزوجة',
            closeOnSelect: true,
            dir: 'rtl',
            language: 'ar',
            width: '100%',
        });
    });

    function showDate(){
        if($('#death_date').hasClass('d-none'))
            $('#death_date').removeClass('d-none').addClass('d-block');
        else
            $('#death_date').removeClass('d-block').addClass('d-none');

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

</script>
@endsection
