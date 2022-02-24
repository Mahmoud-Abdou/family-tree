@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-parent-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الزواجات', 'link' => route('marriages.index')],['title' => $menuTitle, 'link' => route('marriages.create')],]])
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
                        <h5 class="float-left my-auto"><i class="ri-parent-line"> </i> {{ $menuTitle }}</h5>
                    </div>

                    <form dir="rtl" method="POST" action="{{ route('marriages.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="husband_id">اسم الزوج</label>
                                <select name="husband_id" id="husband_id" class="js-basic-multiple form-control mb-0" required autofocus>
                                    <option>اختر الزوج</option>
                                    @foreach($male as $person)
                                        <option value="{{$person->id}}">{{ $person->first_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="wife_id">اسم الزوجة</label>
                                <select name="wife_id" id="wife_id" class="js-basic-multiple form-control mb-0" required autofocus>
                                    <option>اختر الزوجة</option>
                                    @foreach($female as $person)
                                        <option value="{{$person->id}}">{{ $person->first_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="title">العنوان</label>
                                <input type="text" name="title" class="form-control mb-0" id="title" required>
                            </div>

                            <div class="form-group col-lg-12">
                                <label for="body">الوصف</label>
                                <textarea class="form-control" name="body" id="body">{!! old('body') !!}</textarea>
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="date">تاريخ الزواج</label>
                                <input type="date" name="date" class="form-control mb-0" id="date" value="{{ old('date') }}" required >
                            </div>

                            <div class="form-group col-lg-6">
                                <label for="image">الصورة </label>
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
    <script src="{{ secure_asset('assets/js/tinymce/tinymce.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#husband_id').select2({
                placeholder: 'حدد الزوج',
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
    </script>

    <script>
        tinymce.init({
            selector: 'textarea',
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
@endsection
