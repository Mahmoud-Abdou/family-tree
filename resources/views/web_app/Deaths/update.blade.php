@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-map-2-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الدول و المدن', 'link' => route('deaths.index')],['title' => $menuTitle, 'link' => route('deaths.create')],]])
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
                            <form dir="rtl" method="POST" action="{{ route('deaths.update', $death) }}" enctype="multipart/form-data" >
                                @csrf
                                @method('PUT')
                                <div class="row">

                                    <div class="form-group col-lg-6">
                                        <label for="family_id">العائلة</label>
                                        <select name="family_id" id="family_id" class="form-control mb-0" required autofocus>
                                            <option disabled>اختر العائلة</option>
                                            @foreach($families as $family)
                                                @if($family->id == $death->family->id)
                                                    <option value="{{$family->id}}" selected>{{ $family->name }}</option>
                                                @else
                                                    <option value="{{$family->id}}">{{ $family->name }}</option>
                                                @endif
                                            @endforeach
                                        </select>    
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="title">العنوان</label>
                                        <input type="text" name="title" class="form-control mb-0" id="title" tabindex="2" value="{{ $death->title }}" required autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="body">الوصف</label>
                                        <input type="text" name="body" class="form-control mb-0" id="body" tabindex="3" value="{{ $death->body }}" required autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="date">تاريخ الوفاة</label>
                                        <input type="date" name="date" class="form-control mb-0" id="date" tabindex="8" value="{{ $death->date }}"  required autofocus>
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
                                            <img class="file-upload-image" src="{{ $death->image->file }}" alt="Image" />
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
