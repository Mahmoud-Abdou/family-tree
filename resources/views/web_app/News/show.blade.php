@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-newspaper-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الاخبار', 'link' => route('news.index')],['title' => $menuTitle, 'link' => null],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="iq-card shadow">
                        <div class="iq-card-body">
                            <div class="row">

                                <div class="col-lg-12 iq-item-product-right">
                                    <div class="product-additional-details">
                                        <h3 class="productpage_title">{{ $news->title }}</h3>
                                        <hr>
                                        <div class="product-descriptio">
                                            {!! $news->body !!}
                                        </div>
                                        <hr>
                                        <div class="additional-product-action d-flex align-items-center">

                                            <div class="product-action w-100">
                                                <div class="add-to-cart mx-3">
                                                    <p data-toggle="tooltip" data-placement="top" title="المدينة" data-original-title="المدينة"><i class="ri-map-pin-2-line"> </i> {{ $news->city->name_ar }}</p>
                                                </div>
                                                <div class="wishlist mx-3">
                                                    <p data-toggle="tooltip" data-placement="top" title="التاريخ" data-original-title="التاريخ">
                                                        <i class="ri-timer-2-line"> </i> {{ date('Y-m-d | H:i', strtotime($news->date)) }}
                                                    </p>
                                                </div>

                                                <div class="wishlist d-inline-flex mx-1 float-right">
                                                    @if($news->owner_id == auth()->id())
                                                        @can('news.update')
                                                            <span data-toggle="tooltip" data-placement="top" title="تعديل" data-original-title="تعديل">
                                                                <a class="bg-warning text-dark" href="{{ route('news.edit', $news) }}">
                                                                    <i class="ri-edit-2-fill"></i>
                                                                </a>
                                                            </span>
                                                        @endcan
                                                        @can('news.delete')
                                                            <span data-toggle="tooltip" data-placement="top" title="حذف" data-original-title="حذف">
                                                                <a class="bg-danger text-dark" href="#" data-toggle="modal" data-placement="top" data-target="#deleteModal">
                                                                    <i class="ri-delete-back-2-fill"> </i>
                                                                </a>
                                                            </span>
                                                        @endcan
                                                    @endif

                                                    <span class="mx-1" data-toggle="tooltip" data-placement="top" title="اضافة الى المفضلة" data-original-title="اضافة الى المفضلة">
                                                        @if($news->likes->where('owner_id', auth()->id())->first() == null)
                                                            <form method="POST" action="{{ route('news_likes.store') }}" >
                                                                @csrf
                                                                <input type="hidden" name="news_id" value="{{ $news->id }}">
                                                                    <button class="btn btn-info p-2" type="submit"><i class="ri-heart-line"></i></button>
                                                            </form>
                                                        @else
                                                            <form method="POST" action="{{ route('news_likes.destroy', $news->likes->where('owner_id', auth()->id())->first()) }}" >
                                                                @csrf
                                                                @method('DELETE')
                                                                    <button class="btn btn-info p-2" type="submit"><i class="ri-heart-fill"></i></button>
                                                            </form>
                                                        @endif
                                                    </span>

                                                    <span data-toggle="tooltip" data-placement="top" title="التبليغ عن الخبر" data-original-title="التبليغ عن الخبر">
                                                        <a href="#" data-toggle="modal" data-placement="top" data-target="#reportModal">
                                                            <i class="ri-alarm-warning-line"> </i>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr>

                        @if(Helper::GeneralSettings('app_comments'))
                            @include('web_app.News.comments')
                        @endif
                    </div>
                </div>

{{--                <div class="col-lg-12">--}}
{{--                    <div class="iq-card shadow-sm">--}}
{{--                        @include('web_app.News.comments')--}}
{{--                    </div>--}}
{{--                </div>--}}

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
                        <input type="hidden" name="type" value="news" >
                        <input type="hidden" name="type_id" value="{{ $news->id }}">

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

                <form method="POST" action="{{ route('news.destroy', $news) }}">
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


