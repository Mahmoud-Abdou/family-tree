@extends('layouts.master')

@section('page-title', $pageTitle)

@section('add-styles')
    <link rel="stylesheet" href="{{ secure_asset('assets/css/slick.css') }}"/>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/slick-theme.css') }}"/>
@endsection

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-calendar-event-line"> </i>'.$menuTitle, 'slots' => [['title' => 'المناسبات', 'link' => route('events.index')],['title' => $menuTitle, 'link' => null],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="iq-card shadow">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-md-6 iq-item-product-right">
                                    <div class="product-additional-details">
                                        <h3 class="productpage_title">{{ $event->title }}</h3>
                                        {{--                                        <p>{{ date('Y-m-d | H:i', strtotime($event->event_date)) }}</p>--}}
                                        <hr>
                                        <div class="product-descriptio">
                                            {!! $event->body !!}
                                        </div>
                                        <hr>
                                        <div class="additional-product-action d-flex align-items-center">

                                            <div class="product-action w-100">
                                                {{--                                                <div class="add-to-cart"><a href="#"> Add to Cart </a></div>--}}
                                                <div class="add-to-cart mx-3">
                                                    <p data-toggle="tooltip" data-placement="top" title="المدينة"
                                                       data-original-title="المدينة"><i
                                                            class="ri-map-pin-2-line"> </i> {{ $event->city->name_ar }}
                                                    </p>
                                                </div>
                                                <div class="wishlist mx-3">
                                                    <p data-toggle="tooltip" data-placement="top" title="التاريخ"
                                                       data-original-title="التاريخ"><i
                                                            class="ri-timer-2-line"> </i> {{ date('Y-m-d | H:i', strtotime($event->event_date)) }}
                                                    </p>
                                                </div>
                                                <div class="wishlist mx-3 float-right">
                                                    <a href="#" data-toggle="tooltip" data-placement="top"
                                                       title="اضافة الى المفضلة"
                                                       data-original-title="اضافة الى المفضلة"> <i
                                                            class="ri-heart-line"> </i> </a>
                                                </div>
                                                <div class="wishlist mx-3 float-right">
                                                    <a data-toggle="modal" data-target=".bd-example-modal-xl"
                                                       title="التبليغ عن شكوي"
                                                       data-original-title="التبليغ عن شكوي"> <i
                                                            class="ri-alarm-warning-fill"> </i> </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 iq-item-product-left">
                                    <div class="iq-image-container">
                                        <div class="iq-product-cover">
                                            <img
                                                src="{{ isset($event->image->file) ? $event->image->file : 'default.png' }}"
                                                alt="{{ $event->title }}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 px-0 shadow">
                        <div class="iq-card">
                            <div class="iq-card-body p-0">

                                <div class="related-heading text-center my-4 p-2">
                                    <h2>آخر المناسبات</h2>
                                </div>

                                @if($lastEvents->count() > 0)
                                <div id="events-slider" class="slick-slider">
                                    @foreach($lastEvents as $e)
                                        <div class="product_item col-xs-12 col-sm-6 col-md-6 col-lg-4">
                                            <div class="product-miniature">
                                                <div class="thumbnail-container">
                                                    <a href="{{ route('events.show', $e) }}">
                                                        <img src="{{ $e->image->file }}" alt="{{ $e->title }}" class="img-fluid">
                                                    </a>
                                                </div>
                                                <div class="product-description">
                                                    <h4>{{ $e->title }}</h4>
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
                                                        <div class="product-price"></div>
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

            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-xl " tabindex="-1" role="dialog" aria-modal="true" >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">التبليغ عن شكوي</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form dir="rtl" method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="type" value="events" >
                        <input type="hidden" name="type_id" value="{{ $event->id }}">

                        <div class="form-group col-lg-6">
                            <label for="body">وصف الشكوي</label>
                            <textarea class="form-control" name="body" id="body"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" >Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
