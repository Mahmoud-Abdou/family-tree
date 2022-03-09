@extends('layouts.master')

@section('page-title', $pageTitle)

@section('add-styles')
    <link rel="stylesheet" href="{{ asset('assets/css/select2-rtl.min.css') }}"/>
@endsection

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-2-fill"> </i>'.$menuTitle, 'slots' => [['title' => 'المستخدمين', 'link' => route('admin.users.index')],['title' => $menuTitle, 'link' => route('admin.users.create')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    @include('partials.messages')
                    @include('partials.errors-messages')

                    <div class="card iq-mb-3 shadow">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-user-2-fill"> </i> {{ $menuTitle }}</h5>
                        </div>
                        <form dir="rtl" method="POST" action="{{ route('admin.users.update_user') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="first_name">{{ __('الاسم') }}</label>
                                        <input type="text" name="first_name" class="form-control mb-0" id="first_name" placeholder="{{ __('الاسم') }}" value="{{ $person->first_name }}" required autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="father_id">{{ __('اسم الأب') }}</label>
                                        <select id="father_id" name="father_id" class="js-states form-control" style="width: 100%;">
                                            <option disabled selected>حدد الأب</option>
                                            @foreach($persons as $per)
                                                <option value="{{ $per->id }}" {{ (isset($person->father) && $person->father->id == $per->id) ? 'selected' : '' }}>{{$per->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="mother_id">{{ __('اسم الام') }}</label>
                                        <select id="mother_id" name="mother_id" class="js-states form-control" style="width: 100%;">
                                            <option value="none">لا يوجد</option>
                                            @foreach($mothers as $per)
                                                <option value="{{$per->id}}" {{ (isset($person->mother) && $person->mother->id == $per->id) ? 'selected' : '' }}>{{$per->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-lg-6">
                                        <label for="surname">{{ __('اللقب') }}</label>
                                        <input type="text" name="surname" class="form-control mb-0" id="surname" value="{{ $person->surname }}" placeholder="أدخل اللقب">
                                    </div>

                                    <div class="form-group col-lg-6" >
                                        <label>الحالة الاجتماعية</label>
                                        <br>
                                        <div class="d-inline-flex">
                                            <div class="custom-control custom-radio mx-4" onclick="openMainWifeModel()">
                                                <input type="radio" id="yes_has_family" name="has_family" value="true"
                                                       class="custom-control-input" {{ $person->has_family ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="yes_has_family">متزوج/ة </label>
                                            </div>
                                            <div class="custom-control custom-radio mx-4" onclick="closeMainWifeModel()">
                                                <input type="radio" id="no_has_family" name="has_family"
                                                       value="false" class="custom-control-input" {{ !$person->has_family ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="no_has_family"> غير متزوج/ة </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="wifeForm" class="form-group col-lg-6 {{ $person->has_family ? 'd-block' : 'd-none' }}">
                                        <label for="wife_id">ابحث و اختر الزوجة، ليتم اضافتها</label>
                                        <select id="wife_id" name="wife_id[]" class="js-example-placeholder-multiple js-states form-control" multiple="multiple" style="width: 100%;">
                                            @foreach($female as $per)
                                                <option value="{{$per->id}}" {{ $person->ownFamily->contains('mother_id', $per->id) ? 'selected' : '' }}>{{$per->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-8 my-3">
                                        <label>حدد هذا الخيار اذا كان الشخص متوفي</label>
                                        <div class="d-inline-flex">
                                            <div class="custom-control custom-radio mx-4">
                                                <input type="checkbox" id="is_alive" name="is_alive" class="custom-control-input" onclick=noUserShowDate() {{ $person->is_live ? '' : 'checked' }}>
                                                <label class="custom-control-label" for="is_alive"> متوفي </label>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="person_id" value="{{ $person->id }}">
                                    @if($person->is_live)
                                        <div class="form-group col-lg-6 d-none" id="no_user_death_date">
                                            <label for="date">تاريخ الوفاه</label>
                                            <input type="date" name="death_date" class="form-control mb-0" value="{{ $person->death_date }}">
                                        </div>
                                        <div class="form-group col-lg-6 d-none" id="no_user_death_place">
                                            <label for="death_place">مكان الوفاه</label>
                                            <input type="text" name="death_place" class="form-control mb-0" value="{{  $person->death_place }}">
                                        </div>
                                    @else
                                        <div class="form-group col-lg-6 d-block" id="no_user_death_date">
                                            <label for="date">تاريخ الوفاه</label>
                                            <input type="date" name="death_date" class="form-control mb-0" value="{{ $person->death_date }}">
                                        </div>
                                        <div class="form-group col-lg-6 d-block" id="no_user_death_place">
                                            <label for="death_place">مكان الوفاه</label>
                                            <input type="text" name="death_place" class="form-control mb-0" value="{{ $person->death_place }}">
                                        </div>
                                    @endif

                                    <div class="form-group col-lg-6">
                                        <label for="birth_date"> تاريخ الميلاد </label>
                                        <input type="date" name="birth_date" class="form-control mb-0"  placeholder="تاريخ الميلاد" value="{{$person->birth_date }}"  autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="birth_place">محل الميلاد </label>
                                        <input type="text" name="birth_place" class="form-control mb-0"  placeholder="محل الميلاد" value="{{ $person->birth_place }}"  autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="job">الوظيفة</label>
                                        <input type="text" name="job" class="form-control mb-0"  placeholder="الوظيفة" value="{{ $person->job }}"  autofocus>
                                    </div>
                                    @isset($person->user)

                                        <div class="form-group col-lg-6">
                                            <label for="new_mobile">{{ __('رقم الجوال') }}</label>
                                            <input type="text" name="mobile" class="form-control numeric mb-0" id="new_mobile" placeholder="أدخل رقم الجوال" value="{{ $person->user->mobile }}" >
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="new_email">{{ __('البريد الإلكتروني') }}</label>
                                            <input type="email" name="email" class="form-control mb-0" id="new_email" value="{{ $person->user->email }}" placeholder="أدخل البريد الإلكتروني">
                                        </div>
                                    @endisset

                                </div>
                            </div>

                            <div class="card-footer text-muted">
                                <button type="submit" class="btn px-5 btn-primary rounded-pill "
                                        tabindex="5"><i class="ri-save-2-fill"> </i>حفظ
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('add-scripts')

<script>

    $(document).ready(function() {
        $('#wife_id').select2({
            placeholder: 'حدد الزوجة',
            closeOnSelect: true,
            allowClear: true,
            tags: true,
            dir: 'rtl',
            language: 'ar',
            width: '100%',
        });
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
    });

    
    $("#yes_has_family").click(() => {
        $("#wifeSection").removeClass('d-none');
    });

    $("#no_has_family").click(() => {
        $("#wifeSection").addClass('d-none');
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

    function noUserShowDate(){
        if($('#no_user_death_date').hasClass('d-none')){
            $('#no_user_death_date').removeClass('d-none').addClass('d-block');
            $('#no_user_death_place').removeClass('d-none').addClass('d-block');
        }
        else{
            $('#no_user_death_date').removeClass('d-block').addClass('d-none');
            $('#no_user_death_place').removeClass('d-block').addClass('d-none');
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
