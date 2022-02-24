@extends('layouts.master')

@section('page-title', $pageTitle)

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

                    <div class="card iq-mb-3 shadow">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-user-4-line"> </i> {{ $menuTitle }}</h5>
                        </div>

                            <form dir="rtl" method="POST" action="{{ route('deaths.update', $death) }}" enctype="multipart/form-data" >
                                @csrf
                                @method('PUT')
                                <div class="card-body">

                                    <div class="row">

                                        <div class="form-group col-lg-6">
                                            <label for="person_id">المتوفي</label>
                                            <select name="person_id" id="person_id" class="form-control mb-0" required>
                                                <option value="{{ $death->person_id }}" selected disabled>{{ $death->person->full_name }}</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6">
                                            <label for="title">العنوان</label>
                                            <input type="text" name="title" class="form-control mb-0" id="title" value="{{ $death->title }}" required>
                                        </div>

                                        <div class="form-group col-lg-12">
                                            <label for="body">الوصف</label>
                                            <textarea class="form-control" name="body" id="body">{{ $death->body }}</textarea>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="date_picker">تاريخ الوفاة</label>
                                            <input type="text" name="date" value="{{ $death->date }}" class="form-control datepicker-decades" id="date_picker" required>
                                        </div>

                                        <div class="form-group col-lg-6">
                                            <label for="image">الصورة (اختياري)</label>
                                            <div class="image-upload-wrap d-none">
                                                <input id="image" class="file-upload-input" type="file" name="image" onchange="readURL(this);" accept="image/png,image/jpeg,image/jpg,image/icon" required>
                                                <div class="drag-text">
                                                    <h3 class="m-4"><i class="ri-upload-2-line"> </i>اضغط أو اسحب صورة لرفعها</h3>
                                                </div>
                                            </div>
                                            <div id="image-content" class="file-upload-content d-block">
                                                <img class="file-upload-image" src="{{ isset($death->image->file) ? $death->image->file : url('default.png') }}" alt="Image" />
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
