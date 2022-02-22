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
                    <div class="iq-card shadow">
                        <div class="iq-card-header card-header mb-4">
                            <div class="related-heading text-center my-auto p-2">
                                <h5 class="card-title text-center my-2">آخر الأخبار</h5>
                            </div>
                        </div>

                        <div class="iq-card-body p-0">

                            @if($lastNews->count() > 0)
                                <div id="newsSlider" class="slick-slider">
                                    @foreach($lastNews as $e)
                                        <div class="product_item col-lg-4 col-md-6 col-sm-12">
                                            <div class="product-miniature-lo">
                                                <div class="thumbnail-container-lo">
                                                    <a href="{{ route('news.show', $e) }}">
                                                        <img src="{{ isset($e->image->file) ? $e->image->file : 'default.png' }}" alt="صورة الخبر" class="img-fluid">
                                                    </a>
                                                </div>
                                                <div class="product-description-lo">
                                                    <h4><a href="{{ route('news.show', $e) }}">{{ $e->title }}</a></h4>
                                                    <p class="mb-0">{!! $e->short_body !!}</p>
                                                    <hr>
                                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                                        <div class="product-action">
                                                            <div class="add-to-cart mx-3">
                                                                <p data-toggle="tooltip" data-placement="top" title="المدينة" data-original-title="المدينة"><i class="ri-map-pin-2-line"> </i> {{ $e->city->name_ar }}
                                                                </p>
                                                            </div>
                                                            <div class="wishlist mx-3">
                                                                <p data-toggle="tooltip" data-placement="top" title="التاريخ" data-original-title="التاريخ"><i class="ri-timer-2-line"> </i> {{ date('Y-m-d | H:i', strtotime($e->event_date)) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
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
@section('add-scripts')
    <script>
        const slidersCount = {{$lastNews->count()}};

        $('.slick-slider').slick({
            // dots: false,
            // infinite: false,
            speed: 300,
            centerMode: true,
            mobileFirst: false,
            pauseOnHover: true,
            rtl: true,
            centerPadding: '60px',
            slidesToShow: slidersCount >= 3 ? 3 : slidersCount,
            slidesToScroll: 1,
            focusOnSelect: true,
            responsive: [{
                breakpoint: 992,
                settings: {
                    arrows: true,
                    centerMode: true,
                    centerPadding: '30px',
                    slidesToShow: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    arrows: false,
                    centerMode: true,
                    centerPadding: '15px',
                    slidesToShow: 1
                }
            }],
            // nextArrow: '<a href="#" class="ri-arrow-left-s-line right slick-arrow" style="display: block;"></a>',
            // prevArrow: '<a href="#" class="ri-arrow-right-s-line left slick-arrow"></a>',
            nextArrow: '<a href="#" class="p-1 my-5 right iq-bg-primary-dark-hover bg-transparent font-size-32"><i class="ri-arrow-left-s-line"> </i></a>',
            prevArrow: '<a href="#" class="p-1 my-5 left iq-bg-primary-dark-hover bg-transparent font-size-32"><i class="ri-arrow-right-s-line"> </i></a>',
        });

    </script>
@endsection
