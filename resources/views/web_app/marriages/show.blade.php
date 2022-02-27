@extends('layouts.master')

@section('page-title', $pageTitle)

@section('add-styles')
    <link rel="stylesheet" href="{{ secure_asset('assets/css/slick.css') }}"/>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/slick-theme.css') }}"/>
@endsection

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-parent-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الزواجات', 'link' => route('marriages.index')],['title' => $menuTitle, 'link' => null],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="iq-card shadow">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-md-6 iq-item-product-left d-block d-md-block d-lg-none">
                                    <div class="iq-image-container">
                                        <div class="iq-product-cover">
                                            <img src="{{ isset($marriage->image->file) ? $marriage->image->file : url('default.png') }}"
                                                 alt="{{ $marriage->title }}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 iq-item-product-right">
                                    <div class="product-additional-details">
                                        <h3 class="productpage_title">{{ $marriage->title }}</h3>
                                        <hr>
                                        <div class="product-descriptio">
                                            {!! $marriage->body !!}
                                        </div>
                                        <hr>
                                        <div class="additional-product-action d-flex align-items-center">

                                            <div class="product-action w-100">
                                                <div class="wishlist mx-3">
                                                    <p data-toggle="tooltip" data-placement="top" title="التاريخ"
                                                       data-original-title="التاريخ"><i
                                                            class="ri-timer-2-line"> </i> {{ date('Y-m-d', strtotime($marriage->date)) }}
                                                    </p>
                                                </div>

                                                <div class="wishlist mx-1 float-right d-inline-flex">
                                                    @if($marriage->owner_id == auth()->id())
                                                        @can('marriages.update')
                                                            <a class="bg-warning text-dark" href="{{ route('marriages.edit', $marriage) }}" data-toggle="tooltip" data-placement="top"
                                                               title="تعديل"
                                                               data-original-title="تعديل">
                                                                <i class="ri-edit-2-fill"></i>
                                                            </a>
                                                        @endcan
                                                        @can('marriages.delete')
                                                            <span data-toggle="tooltip" data-placement="top" title="حذف"
                                                                  data-original-title="حذف">
                                                                <a class="bg-danger text-dark" href="#" data-toggle="modal" data-placement="top" data-target="#deleteModal">
                                                                    <i class="ri-delete-back-2-fill"> </i>
                                                                </a>
                                                            </span>
                                                        @endcan
                                                    @endif

                                                    <a href="#" data-toggle="tooltip" data-placement="top"
                                                       title="اضافة الى المفضلة"
                                                       data-original-title="اضافة الى المفضلة">
                                                        <i class="ri-heart-line"></i>
                                                    </a>

                                                    <span data-toggle="tooltip" data-placement="top" title="التبليغ عن الخبر"
                                                          data-original-title="التبليغ عن الخبر">
                                                        <a href="#" data-toggle="modal" data-placement="top" data-target="#reportModal">
                                                            <i class="ri-alarm-warning-line"> </i>
                                                        </a>
                                                    </span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 iq-item-product-left d-none d-lg-block">
                                    <div class="iq-image-container">
                                        <div class="iq-product-cover">
                                            <img src="{{ isset($marriage->image->file) ? $marriage->image->file : url('default.png') }}"
                                                 alt="{{ $marriage->title }}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="iq-card shadow">
                        <div class="iq-card-header mb-4">
                            <div class="related-heading text-center my-auto p-2">
                                <h2>آخر الزواجات</h2>
                            </div>
                        </div>

                        <div class="iq-card-body p-0">

                            @if($lastMarriage->count() > 0)
                                <div id="marriageSlider" class="slick-slider">
                                    @foreach($lastMarriage as $e)
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <a href="{{ route('marriages.show', $e) }}">
                                                <div class="card iq-mb-3 shadow iq-bg-primary-hover">
                                                    <img src="{{ isset($e->image->file) ? $e->image->file : url('default.png') }}" class="card-img-top img-fluid w-auto card-img-lo" alt="{{ $e->title }}">
                                                    <div class="card-body card-size-lo">
                                                        <h4 class="card-title">{{ $e->title }}</h4>
                                                        <hr />
                                                        <p class="card-text">{!! $e->short_body !!}</p>
                                                    </div>
                                                    <div class="card-footer">
                                                        <div class="d-flex justify-content-between" dir="ltr">
                                                            <p class="card-text m-0"><i class="ri-timer-2-fill"> </i><small class="text-muted">{{ date('Y-m-d', strtotime($e->date)) }}</small></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
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

    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reportModalLabel"><i class="ri-alarm-warning-fill"> </i>التبليغ عن شكوي</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form dir="rtl" method="POST" action="{{ route('reports.store') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="type" value="marriages" >
                        <input type="hidden" name="type_id" value="{{ $marriage->id }}">

                        <div class="form-group col-lg-12">
                            <label for="body">وصف الشكوي</label>
                            <textarea class="form-control" name="body" id="body" required oninvalid="this.setCustomValidity('ادخل وصف الشكوى')"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-primary">ارسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="deleteModalLabel">حذف البيانات</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('marriages.destroy', $marriage) }}">
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')

                        <p>سيتم حذف البيانات بشكل كامل.</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">حذف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

