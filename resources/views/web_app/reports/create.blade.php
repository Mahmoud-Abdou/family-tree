@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-4-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الوفيات', 'link' => route('reports.index')],['title' => $menuTitle, 'link' => route('reports.index')],]])
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

                    <form dir="rtl" method="POST" action="{{ route('reports.store') }}">
                    @csrf
                    <div class="card-body">

                        <div class="row">

                            <input type="hidden" name="type" value="{{ $type['type'] }}" >
                            <input type="hidden" name="type_id" value="{{ $type['type_id'] }}">

                            <div class="form-group col-lg-12">
                                <label for="body">الوصف</label>
                                <textarea class="form-control" name="body" id="body">{!! old('body') !!}</textarea>
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
