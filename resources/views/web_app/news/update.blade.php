@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-newspaper-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الأخبار', 'link' => route('news.index')],['title' => $menuTitle, 'link' => route('news.create')],]])
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
                            <h5 class="float-left my-auto"><i class="ri-newspaper-line"> </i> {{ $menuTitle }}</h5>
                        </div>
                        <form dir="rtl" method="POST" action="{{ route('news.update', $news) }}">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">

                                    <div class="form-group col-lg-6">
                                        <label for="city_id">المدينة</label>
                                        <select name="city_id" id="city_id" class="form-control mb-0" required>
                                            <option disabled>اختر المدينة</option>
                                            @foreach($cities as $city)
                                                @if($city->id == $news->city->id)
                                                    <option value="{{$city->id}}" selected>{{ $city->name_ar }}</option>
                                                @else
                                                    <option value="{{$city->id}}">{{ $city->name_ar }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="category_id">النوع</label>
                                        <select name="category_id" id="category_id" class="form-control mb-0" required>
                                            <option>اختر النوع</option>
                                            @foreach($categories as $category)
                                                @if($category->id == $news->category_id)
                                                    <option value="{{$category->id}}" selected>{{ $category->name_ar }}</option>
                                                @else
                                                    <option value="{{$category->id}}">{{ $category->name_ar }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-12">
                                        <label for="title">العنوان</label>
                                        <input type="text" name="title" class="form-control mb-0" id="title" value="{{ $news->title }}" required>
                                    </div>
                                    <div class="form-group col-lg-12">
                                        <label for="body">الوصف</label>
                                        <textarea class="form-control" name="body" id="body">{!! $news->body !!}</textarea>
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
