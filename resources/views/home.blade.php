@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-home-line"> </i>'.$menuTitle, 'slots' => []])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card iq-mb-3 shadow">
                        <div class="card-header">
                            <h5 class="card-title text-center">{{ @Helper::GeneralSettings('app_title_ar') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="card bg-dark text-white">
                                <img src="{{ secure_asset('assets/images/profile-bg.jpg') }}" class="card-img" alt="#">
                                <div class="card-img-overlay overflow-hidden overflow-auto scroll-content scroller width-100">
                                    <p class="card-text">{!! @Helper::GeneralSettings('app_description_ar') !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <h5 class="card-title text-center">آخر الأخبار</h5>
                        </div>
                        <div class="card-body d-inline-flex mt-3">

                            @if($lastNews->count() > 0)
{{--                            <div id="events-slider" class="slick-slider">--}}
                                @foreach($lastNews as $n)
                                    <div class="product_item col-xs-12 col-sm-6 col-md-6 col-lg-4">
                                        <div class="product-miniature">
                                            <div class="product-description">
                                                <h4>{{ $n->title }}</h4>
                                                <hr>
                                                <p class="mb-0">{!! $n->short_body !!}</p>
                                                <hr>
                                                <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                    <div class="product-action">
                                                        <div class="add-to-cart mx-3">
                                                            <p data-toggle="tooltip" data-placement="top" title="المدينة" data-original-title="المدينة"><i class="ri-map-pin-2-line"> </i> {{ $n->city->name_ar }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="product-price"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
{{--                            </div>--}}
                            @else
                                <p class="text-center">لا يوجد بيانات</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>

        </div>
    </div>
@endsection
