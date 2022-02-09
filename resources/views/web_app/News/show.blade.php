@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-calendar-event-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الاخبار', 'link' => route('media.index')],['title' => $menuTitle, 'link' => null],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @include('partials.messages')
                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-map-2-line"> </i> {{ $menuTitle }}</h5>
                            
                        </div>
                        <div class="col-lg-12">
                    <div class="iq-card shadow">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-md-6 iq-item-product-right">
                                    <div class="product-additional-details">
                                        <h3 class="productpage_title">{{ $news->title }}</h3>
                                        <hr>
                                        <div class="product-descriptio">
                                            {!! $news->body !!}
                                        </div>
                                        <hr>
                                        <div class="additional-product-action d-flex align-items-center">

                                            <div class="product-action w-100">
                                                
                                                <div class="wishlist mx-3">
                                                    <p data-toggle="tooltip" data-placement="top" title="التاريخ"
                                                       data-original-title="التاريخ"><i
                                                            class="ri-timer-2-line"> </i> {{ date('Y-m-d | H:i', strtotime($news->date)) }}
                                                    </p>
                                                </div>
                                                <div class="d-flex justify-content-between" dir="ltr">
                                                    @if($news->owner_id == auth()->user()->id)
                                                        @can('news.update')
                                                        
                                                            <a href="{{ route('news.edit', $news) }}" class="card-text m-0"><i class="ri-edit-2-fill"> </i><small class="text-muted"></small></p>
                                                        @endcan
                                                        @can('news.delete')
                                                        <form action="{{ route('news.destroy', $news) }}" method="POST">
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
                                                src="{{ isset($news->image->file) ? $news->image->file : '/default.png' }}"
                                                alt="{{ $news->title }}" class="img-fluid">
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
        </div>
    </div>
@endsection

<script>
    function submit_form(form){
        if(confirm('Are you sure?')){
            $(form).parent().submit()
        }
    }
</script>