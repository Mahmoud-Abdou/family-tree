@extends('layouts.master')

@section('page-title', $pageTitle)

@section('add-styles')
    <link rel="stylesheet" href="{{ secure_asset('assets/css/bootstrap-datetimepicker.min.css') }}"/>
@endsection

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-calendar-event-line"> </i>'.$menuTitle, 'slots' => [['title' => 'المناسبات', 'link' => route('admin.events.index')],['title' => $menuTitle, 'link' => route('admin.events.index')],]])
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
                            <h5 class="float-left my-auto"><i class="ri-calendar-event-line"> </i> {{ $menuTitle }}</h5>
                        </div>

                        <form dir="rtl" method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" >
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-lg-6">
                                        <label for="city_id">المدينة</label>
                                        <select name="city_id" id="city_id" class="form-control mb-0" required>
                                            <option disabled>اختر المدينة</option>
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}" {{ $event->city_id == $city->id ? 'selected' : '' }}>{{ $city->name_ar }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="title">العنوان</label>
                                        <input type="text" name="title" class="form-control mb-0" id="title" value="{{ $event->title }}" required>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="body">الوصف</label>
                                        <textarea class="form-control" name="body" id="body">{!! $event->body !!}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="event_date_picker">تاريخ المناسبة</label>
                                                    <input type="text" name="event_date" value="{{ $event->event_date }}" class="form-control datetimepicker-input" id="event_date_picker" data-toggle="datetimepicker" data-target="#event_date_picker" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="category_id">النوع</label>
                                                    <select name="category_id" id="category_id" class="form-control mb-0" required>
                                                        <option disabled>اختر النوع</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{$category->id}}" {{ $event->category_id == $category->id ? 'selected' : '' }}>{{ $category->name_ar }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="image">الصورة</label>
                                        <div class="image-upload-wrap d-none">
                                            <input id="image" class="file-upload-input" type="file" name="image" value="{{ old('image') }}" onchange="readURL(this);" accept="image/png,image/jpeg,image/jpg,image/icon">
                                            <div class="drag-text">
                                                <h3 class="m-4"><i class="ri-upload-2-line"> </i>اضغط أو اسحب صورة لرفعها</h3>
                                            </div>
                                        </div>
                                        <div id="image-content" class="file-upload-content d-block">
                                            <img class="file-upload-image" src="{{ isset($event->image->file) ? $event->image->file : 'default.png' }}" alt="Event Image" />
                                            <div class="image-title-wrap">
                                                <button type="button" class="remove-image">حذف <span class="image-title">الصورة المرفوعة</span></button>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="card-footer text-muted">
                                <button type="submit" class="btn px-5 btn-primary rounded-pill"><i class="ri-save-2-fill"> </i>حفظ </button>
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
            $('#event_date_picker').datetimepicker({
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
