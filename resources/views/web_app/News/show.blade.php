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
                                                <div class="wishlist mx-3 float-right">
                                                    <a  data-toggle="modal" data-target=".bd-example-modal-xl"
                                                       title="التبليغ عن شكوي"
                                                       data-original-title="التبليغ عن شكوي"> <i
                                                            class="ri-alarm-warning-fill"> </i> </a>
                                                </div>
                                                
                                                <div class="d-flex justify-content-between" dir="ltr">
                                                    @if($news->owner_id == auth()->user()->id)
                                                        @can('news.update')
                                                            <a href="{{ route('news.edit', $news) }}" class="card-text m-0"><i class="ri-edit-2-fill"> </i><small class="text-muted"></small></p>
                                                        @endcan
                                                        @can('news.delete')
                                                            <a data-toggle="modal" data-target=".deleteModel" onclick= "openDeleteModel(`{{ route('news.destroy', $news) }}`)" class="card-text m-0"><i class="ri-delete-back-2-fill"></i></a>
                                                        @endcan
                                                    @endif
                                                    @if($news->likes->where('owner_id', auth()->user()->id)->first() == null)
                                                        <form dir="rtl" method="POST" action="{{ route('news_likes.store') }}" >
                                                            @csrf
                                                            <input type="hidden" name="news_id" value="{{ $news->id }}">
                                                            <button type="submit" class="card-text m-0"><i class="ri-thumb-up-fill"></i></button>
                                                        </form>
                                                    @else 
                                                        <form dir="rtl" method="POST" action="{{ route('news_likes.destroy', $news->likes->where('owner_id', auth()->user()->id)->first()) }}" >
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="card-text m-0"><i class="ri-thumb-up-fill"></i></button>
                                                        </form>
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
                    
                    @include('web_app.News.comments')


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
                        <input type="hidden" name="type" value="news" >
                        <input type="hidden" name="type_id" value="{{ $news->id }}">

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

    <div class="modal fade deleteModel " tabindex="-1" role="dialog" aria-modal="true" >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">هل ترغب في الازالة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                
                <form id="DeleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">لا</button>
                        <button type="submit" class="btn btn-primary" >نعم</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>

    function openDeleteModel(data){
        console.log("Asd")
        $('#DeleteForm').attr('action', data)
    }
</script>