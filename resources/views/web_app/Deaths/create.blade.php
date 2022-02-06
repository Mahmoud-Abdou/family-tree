@extends('layouts.master')

@section('page-title', $pageTitle)

@section('add-styles')
    <link rel="stylesheet" href="{{ secure_asset('assets/css/bootstrap-datetimepicker.min.css') }}"/>
@endsection

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-4-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الوفيات', 'link' => route('deaths.index')],['title' => $menuTitle, 'link' => route('deaths.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    @include('partials.messages')
                    @include('partials.errors-messages')

                    <div class="card iq-mb-3">
                    <div class="card-header">
                        <h5 class="float-left my-auto"><i class="ri-user-4-line"> </i> {{ $menuTitle }}</h5>
                    </div>

                    <form dir="rtl" method="POST" action="{{ route('deaths.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="row">

                            <div class="form-group col-lg-6">
                                <label for="person_id">المتوفي</label>
                                <select name="person_id" id="person_id" class="form-control mb-0" required>
                                    <option disabled>اختر الشخص</option>
                                    @foreach($persons as $person)
                                        <option value="{{$person->id}}" >{{ $person->first_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="title">العنوان</label>
                                <input type="text" name="title" class="form-control mb-0" id="title" tabindex="2" required autofocus>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="body">الوصف</label>
                                <textarea class="form-control" name="body" id="body">{!! old('body') !!}</textarea>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="date_picker">تاريخ الوفاة</label>
                                <input type="text" name="date" value="{{ old('date') }}" class="form-control datetimepicker-input" id="date_picker" data-toggle="datetimepicker" data-target="#date_picker" required>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="image">الصورة (اختياري)</label>
                                <div class="image-upload-wrap d-block">
                                    <input id="image" class="file-upload-input" type="file" name="image" value="{{ old('image') }}" onchange="readURL(this);" accept="image/png,image/jpeg,image/jpg,image/icon" required>
                                    <div class="drag-text">
                                        <h3 class="m-4"><i class="ri-upload-2-line"> </i>اضغط أو اسحب صورة لرفعها</h3>
                                    </div>
                                </div>
                                <div id="image-content" class="file-upload-content d-none">
                                    <img class="file-upload-image" src="" alt="Event Image" />
                                    <div class="image-title-wrap">
                                        <button type="button" class="remove-image">حذف <span class="image-title">الصورة المرفوعة</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-muted">
                        <button type="submit" class="btn px-5 btn-primary rounded-pill " tabindex="6"><i class="ri-save-2-fill"> </i>حفظ </button>
                    </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('add-scripts')
    <script src="{{ secure_asset('assets/js/moment/moment.min.js') }}"></script>
    <script src="{{ secure_asset('assets/js/bootstrap-datetimepicker.min.js') }}"></script>
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
        $(function () {
            $('#date_picker').datetimepicker({
                locale: '{{ app()->getLocale() }}',
                format: 'YYYY-MM-DD HH:mm',
                defaultDate: moment(new Date()),
                minDate: moment().subtract(1, 'seconds'),
                tooltips: {
                    today: 'Go to today',
                    clear: 'Clear selection',
                    close: 'Close the picker',
                    selectMonth: 'Select Month',
                    prevMonth: 'Previous Month',
                    nextMonth: 'Next Month',
                    selectYear: 'Select Year',
                    prevYear: 'Previous Year',
                    nextYear: 'Next Year',
                    selectDecade: 'Select Decade',
                    prevDecade: 'Previous Decade',
                    nextDecade: 'Next Decade',
                    prevCentury: 'Previous Century',
                    nextCentury: 'Next Century',
                    incrementHour: 'Increment Hour',
                    pickHour: 'Pick Hour',
                    decrementHour:'Decrement Hour',
                    incrementMinute: 'Increment Minute',
                    pickMinute: 'Pick Minute',
                    decrementMinute:'Decrement Minute',
                    incrementSecond: 'Increment Second',
                    pickSecond: 'Pick Second',
                    decrementSecond:'Decrement Second'
                },
            });
        });
    </script>
@endsection
