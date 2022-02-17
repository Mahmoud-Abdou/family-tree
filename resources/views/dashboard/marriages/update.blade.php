@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-newspaper-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الأخبار', 'link' => route('marriages.index')],['title' => $menuTitle, 'link' => route('marriages.create')],]])
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
                        <form dir="rtl" method="POST" action="{{ route('admin.marriages.update', $marriage) }}" enctype="multipart/form-data" >
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">

                                

                                <div class="form-group col-lg-6">
                                    <label for="date">تاريخ الزواج</label>
                                    <input type="date" name="date" class="form-control mb-0" id="date" value="{{ $marriage->date }}" required >
                                </div>

                                <div class="form-group col-lg-12">
                                    <label for="title">العنوان</label>
                                    <input type="text" name="title" class="form-control mb-0" id="title" value="{{ $marriage->title }}" required>
                                </div>

                                <div class="form-group col-lg-12">
                                    <label for="body">الوصف</label>
                                    <textarea class="form-control" name="body" id="body">{!! $marriage->body !!}</textarea>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="image">الصورة </label>
                                    <div class="image-upload-wrap d-none">
                                        <input id="image" class="file-upload-input" type="file" name="image" onchange="readURL(this);" accept="image/png,image/jpeg,image/jpg,image/icon">
                                        <div class="drag-text">
                                            <h3 class="m-4"><i class="ri-upload-2-line"> </i>اضغط أو اسحب صورة لرفعها</h3>
                                        </div>
                                    </div>
                                    <div id="image-content" class="file-upload-content d-block">
                                        <img class="file-upload-image" src="{{ isset($marriage->image->file) ? $marriage->image->file : 'default.png' }}" alt="Image" />
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