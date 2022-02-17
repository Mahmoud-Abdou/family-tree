@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
@include('partials.breadcrumb', ['pageTitle' => '<i class="ri-image-2-line"> </i>'.$menuTitle, 'slots' => [['title' => 'المعرض', 'link' => route('media.index')],['title' => $menuTitle, 'link' => null],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12 mb-4">
                    <div class="d-inline-flex">
                        <div class="btn-group btn-group-lg" role="group" aria-label="Basic example">
                            <a href="{{ route('media.index') }}" type="button" class="btn btn-primary text-white px-5">المعرض</a>
                            <a type="button" class="btn btn-primary disabled text-white px-5">{{$menuTitle}}</a>
                        </div>
                    </div>
                </div>

                @if($media->count() > 0)
                    @foreach($media as $row)

                        <div class="card col-lg-4" onclick="OpenImage({{ $row->id }})" data-toggle="modal" data-target=".bd-example-modal-xl" id="{{ $row->id }}" >
                            <div class="card-header">
                                <h4 class="card-title text-center">{{ $row->title }}</h4>
                            </div>
                            <div class="card-body p-0">
                                <div class="col-sm-12">
                                    <div class="card iq-mb-3">
                                        <div class="card-body">
                                            <img src="{{ $row->file }}" class="img-thumbnail" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    @endforeach
                @else
                    <div class="col-lg-12">
                        <div class="card iq-mb-3 shadow p-5">
                            <div class="card-body text-center">
                                لا توجد بيانات
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>

<div id="imageModel" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($media as $row)
                        <div class="carousel-item" id="image_{{ $row->id }}">
                            <img src="{{ $row->file }}" class="d-block w-100" alt="#">
                        </div>
                    @endforeach

                </div>
                <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">السابق</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">التالي</span>
                </a>
            </div>
        </div>
    </div>
</div>

@endsection
@section('add-scripts')
<script>
    function OpenImage(id){
        $('.carousel-item').removeClass('active')
        $('#image_' + id).addClass('active');
    }
</script>
@endsection
