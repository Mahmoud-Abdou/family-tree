@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-smile-line"> </i>'.$menuTitle, 'slots' => [['title' => 'المواليد', 'link' => route('newborns.index')],['title' => $menuTitle, 'link' => route('newborns.create')],]])
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
                        <h5 class="float-left my-auto"><i class="ri-user-smile-line"> </i> {{ $menuTitle }}</h5>
                    </div>

                    <form dir="rtl" method="POST" action="{{ route('newborns.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            <div class="row">

                                <div class="form-group col-lg-6">
                                    <label for="title">العنوان</label>
                                    <input type="text" name="title" class="form-control mb-0" id="title" value="{{ old('title') }}" required autofocus>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="date">تاريخ الولادات</label>
                                    <input type="date" name="date" class="form-control mb-0" id="date" value="{{ old('date') }}" required >
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="first_name">الاسم</label>
                                    <input type="text" name="first_name" class="form-control mb-0" id="first_name" value="{{ old('first_name') }}" required >
                                </div>

                                <div class="form-group col-lg-4">
                                    <label for="father_name">اسم الاب</label>
                                    <input type="text" name="father_name" class="form-control mb-0" id="father_name" value="{{ old('father_name') }}" required >
                                </div>

                                <div class="form-group col-lg-4">
                                    <label>النوع</label>
                                    <br>
                                    <div class="d-inline-flex">
                                        <div class="custom-control custom-radio mx-4">
                                            <input type="radio" id="male" name="gender" value="male" class="custom-control-input">
                                            <label class="custom-control-label" for="male"> رجل </label>
                                        </div>
                                        <div class="custom-control custom-radio mx-4">
                                            <input type="radio" id="female" name="gender" value="female" class="custom-control-input">
                                            <label class="custom-control-label" for="female"> امرأة </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group col-lg-6 pt-3">
                                    <label for="body">الوصف</label>
                                    <textarea class="form-control" name="body" id="body">{!! old('body') !!}</textarea>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="image">الصورة</label>
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
@endsection
