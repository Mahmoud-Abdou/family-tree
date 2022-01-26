@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-map-2-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الدول و المدن', 'link' => route('news.index')],['title' => $menuTitle, 'link' => route('roles.create')],]])
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
                    <form dir="rtl" method="POST" action="{{ route('news.store') }}" enctype="multipart/form-data">
                        @csrf
                            
                        <div class="row">

                            <div class="form-group col-lg-6">
                                <label for="city_id">المدينة</label>
                                <select name="city_id" id="city_id" class="form-control mb-0" required autofocus>
                                    <option>اختر المدينة</option>
                                    @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{ $city->name_ar }}</option>
                                    @endforeach
                                </select>    
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="title">العنوان</label>
                                <input type="text" name="title" class="form-control mb-0" id="title" tabindex="2" required autofocus>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="body">الوصف</label>
                                <input type="text" name="body" class="form-control mb-0" id="body" tabindex="3"  required autofocus>
                            </div>
                            
                            

                            <div class="form-group col-lg-6">
                                <label for="category_id">النوع</label>
                                <select name="category_id" id="category_id" class="form-control mb-0" required autofocus>
                                    <option>اختر النوع</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{ $category->name_ar }}</option>
                                    @endforeach
                                </select> 
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
