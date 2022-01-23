@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-map-2-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الدول و المدن', 'link' => route('events.index')],['title' => $menuTitle, 'link' => route('roles.create')],]])
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
                            <h5 class="float-left my-auto"><i class="ri-map-2-line"> </i> {{ $menuTitle }}</h5>
                        </div>
                        <div class="card-body">
                            <form dir="rtl" method="POST" action="{{ route('events.update', $event) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">

                                    <div class="form-group col-lg-6">
                                        <label for="city_id">المدينة</label>
                                        <select name="city_id" id="city_id" class="form-control mb-0" required autofocus>
                                            <option disabled>اختر المدينة</option>
                                            @foreach($cities as $city)
                                                @if($city->id == $event->city->id)
                                                    <option value="{{$city->id}}" selected>{{ $city->name_ar }}</option>
                                                @else
                                                    <option value="{{$city->id}}">{{ $city->name_ar }}</option>
                                                @endif
                                            @endforeach
                                        </select>    
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="title">العنوان</label>
                                        <input type="text" name="title" class="form-control mb-0" id="title" tabindex="2" value="{{ $event->title }}" required autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="body">الوصف</label>
                                        <input type="text" name="body" class="form-control mb-0" id="body" tabindex="3" value="{{ $event->body }}" required autofocus>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="category_id">النوع</label>
                                        <select name="category_id" id="category_id" class="form-control mb-0" required autofocus>
                                            <option>اختر النوع</option>
                                            @foreach($categories as $category)
                                                @if($category->id == $event->category->id)
                                                    <option value="{{$category->id}}" selected>{{ $category->name_ar }}</option>
                                                @else
                                                    <option value="{{$category->id}}">{{ $category->name_ar }}</option>
                                                @endif
                                            @endforeach
                                        </select> 
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="image">الصورة</label>
                                        <div class="image-upload-wrap">
                                            <input id="image" class="file-upload-input" type="file" name="image"  accept="image/png,image/jpeg,image/jpg,image/icon" />
                                            <div class="drag-text">
                                                <h3 class="m-4"><i class="ri-upload-2-line"> </i>اضغط أو اسحب صورة لرفعها</h3>
                                            </div>
                                        </div>
                                        <div id="image-content" class="file-upload-content d-block">
                                            <img class="file-upload-image" src="{{ $event->image->file }}" alt="Image" />
                                            <div class="image-title-wrap">
                                                <button type="button" class="remove-image">حذف <span class="image-title">الصورة المرفوعة</span></button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <div class="row flex inline-flex p-2 mx-2">
                                            <button type="submit" class="btn px-5 btn-primary rounded-pill " tabindex="6"><i class="ri-save-2-fill"> </i>حفظ </button>
                                        </div>
                                    </div>
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
