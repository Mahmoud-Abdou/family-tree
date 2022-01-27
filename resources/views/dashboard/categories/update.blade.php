@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-price-tag-2-line"> </i>'.$menuTitle, 'slots' => [['title' => 'التصنيفات', 'link' => route('admin.categories.index')],['title' => $menuTitle, 'link' => route('admin.categories.create')],]])
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
                            <h5 class="float-left my-auto"><i class="ri-price-tag-2-lines"> </i> {{ $menuTitle }}</h5>
                        </div>
                        <div class="card-body">
                            <form dir="rtl" class="mt-4" method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="name_en">الاسم (إنجليزي)</label>
                                        <input type="text" name="name_en" class="form-control mb-0" id="name_en" tabindex="1" placeholder="الاسم (إنجليزي)" value="{{ $category->name_en }}" required autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="name_ar">الاسم (عربي)</label>
                                        <input type="text" name="name_ar" class="form-control mb-0" id="name_ar" tabindex="2" placeholder="الاسم (عربي)" value="{{ $category->name_ar }}" required>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="type">النوع</label>
                                        <select class="form-control" id="type" name="type" tabindex="3">
                                            <option disabled="">حدد النوع</option>
                                            @foreach($types as $type)
                                                <option value="{{ $type }}" {{ $category->type == $type ? 'selected' : '' }}>{{ \App\Models\Category::getTypeName($type) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="icon">ايقونة التصنيف</label>
                                        <div class="image-upload-wrap d-none">
                                            <input id="icon" class="file-upload-input" type="file" name="icon" value="{{ old('icon') }}" onchange="readURL(this);" accept="image/png,image/jpeg,image/jpg"/>
                                            <div class="drag-text">
                                                <h3 class="m-4"><i class="ri-upload-2-line"> </i>اضغط أو اسحب صورة لرفعها</h3>
                                            </div>
                                        </div>
                                        <div id="icon-content" class="file-upload-content d-block">
                                            <img class="file-upload-image" src="{{ $category->icon }}" alt="Category Icon"/>
                                            <div class="image-title-wrap">
                                                <button type="button" class="remove-image">حذف <span class="image-title">الصورة المرفوعة</span></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="image">صورة التصنيف</label>
                                        <div class="image-upload-wrap d-none">
                                            <input id="image" class="file-upload-input" type="file" name="image" value="{{ old('image') }}" onchange="readURL(this);" accept="image/png,image/jpeg,image/jpg"/>
                                            <div class="drag-text">
                                                <h3 class="m-4"><i class="ri-upload-2-line"> </i>اضغط أو اسحب صورة لرفعها</h3>
                                            </div>
                                        </div>
                                        <div id="image-content" class="file-upload-content d-block">
                                            <img class="file-upload-image" src="{{ $category->image }}" alt="Category Image"/>
                                            <div class="image-title-wrap">
                                                <button type="button" class="remove-image">حذف <span class="image-title">الصورة المرفوعة</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row flex inline-flex p-2 mx-2">
                                    <button type="submit" class="btn px-5 btn-primary rounded-pill" tabindex="5"><i class="ri-save-2-fill"> </i>حفظ</button>
                                </div>
                            </form>

                        </div>
                        <div class="card-footer text-muted"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('add-scripts')
    <script src="{{ secure_asset('assets/js/jquery-3.6.0.slim.min.js') }}"></script>
@endsection
