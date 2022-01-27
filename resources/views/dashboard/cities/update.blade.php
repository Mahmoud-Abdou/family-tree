@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-map-2-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الدول و المدن', 'link' => route('admin.cities.index')],['title' => $menuTitle, 'link' => route('admin.cities.create')],]])
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
                            <form dir="rtl" method="POST" action="{{ route('admin.cities.update', $city) }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="country_en">اسم الدولة (إنجليزي)</label>
                                        <input type="text" name="country_en" class="form-control mb-0" id="country_en" tabindex="1" value="{{ $city->country_en }}" required autofocus>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="country_ar">اسم الدولة (عربي)</label>
                                        <input type="text" name="country_ar" class="form-control mb-0" id="country_ar" tabindex="2" value="{{ $city->country_ar }}" required>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="name_en">اسم المدينة (إنجليزي)</label>
                                        <input type="text" name="name_en" class="form-control mb-0" id="name_en" tabindex="3" value="{{ $city->name_en }}" required>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="name_ar">اسم المدينة (عربي)</label>
                                        <input type="text" name="name_ar" class="form-control mb-0" id="name_ar" tabindex="4" value="{{ $city->name_ar }}" required>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <div class="row flex inline-flex p-2 mx-2">
                                            <button type="submit" class="btn px-5 btn-primary rounded-pill " tabindex="5"><i class="ri-save-2-fill"> </i>حفظ </button>
                                        </div>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" name="status" id="status-input" {{ $city->status ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status-input">تفعيل</label>
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
