@extends('layouts.master')

@section('page-title', $pageTitle)

@section('add-styles')
    <link rel="stylesheet" href="{{ secure_asset('assets/css/slick.css') }}"/>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/slick-theme.css') }}"/>
@endsection

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-calendar-marriage-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الزواجات', 'link' => route('marriages.index')],['title' => $menuTitle, 'link' => null],]])
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
                                                            class="ri-timer-2-line"> </i> {{ date('Y-m-d | H:i', strtotime($marriage->date)) }}
                                                    </p>
                                                </div>
                                                <div class="wishlist mx-3 float-right">
                                                    <a  data-toggle="modal" data-target=".bd-example-modal-xl"
                                                       title="التبليغ عن شكوي"
                                                       data-original-title="التبليغ عن شكوي"> <i
                                                            class="ri-alarm-warning-fill"> </i> </a>
                                                </div>
                                                <div class="d-flex justify-content-between" dir="ltr">
                                                <p class="card-text m-0"><i class="ri-timer-2-fill"> </i><small class="text-muted">{{ date('Y-m-d | H:i', strtotime($marriage->date)) }}</small></p>
                                                    @if($marriage->owner_id == auth()->user()->id)
                                                        @can('marriages.update')
                                                        
                                                            <a href="{{ route('marriages.edit', $marriage) }}" class="card-text m-0"><i class="ri-edit-2-fill"> </i><small class="text-muted"></small></p>
                                                        @endcan
                                                        @can('marriages.delete')
                                                        <form action="{{ route('marriages.destroy', $marriage) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            <a onclick= "submit_form(this)" class="card-text m-0"><i class="ri-delete-back-2-fill"></i></a>
                                                        </form>
                                                        @endcan
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 iq-item-product-left">
                                    <div class="iq-image-container">
                                        <div class="iq-product-cover">
                                            <img
                                                src="{{ isset($marriage->image->file) ? $marriage->image->file : '/default.png' }}"
                                                alt="{{ $marriage->title }}" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
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
                        <input type="hidden" name="type" value="marriages" >
                        <input type="hidden" name="type_id" value="{{ $marriage->id }}">

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
