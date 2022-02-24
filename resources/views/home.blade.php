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
                            <h5 class="card-title text-center">{{ Helper::GeneralSettings('app_title_ar') }}</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="card bg-dark text-white" style="min-height: 200px; max-height: 200px;">
                                <img src="{{ secure_asset('assets/images/profile-bg.jpg') }}" class="card-img img-fluid w-auto card-img-lo" alt="#">
                                <div class="card-img-overlay overflow-hidden overflow-auto scroll-content scroller width-100">
                                    <p class="card-text">{!! Helper::GeneralSettings('app_description_ar') !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="related-heading text-center my-auto">
                                <h5 class="card-title text-center my-2">آخر الأخبار</h5>
                            </div>
                        </div>

                        <div class="card-body p-0">

                            <div class="table-responsive table-hover">
                                <table class="table m-0">
                                    <thead>
                                        <tr class="w-100">
                                            <th class="my-auto" scope="col">العنوان</th>
                                            <th class="w-100" scope="col">الخبر</th>
                                            <th class="w-25" scope="col">التصنيف</th>
{{--                                            <th class="w-25" scope="col">المدينة</th>--}}
{{--                                            <th scope="col">التاريخ</th>--}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @if($lastNews->count() > 0)
                                        @foreach($lastNews as $row)
                                            <tr class="clickable-row" data-href="{{ route('news.show', $row->id) }}" style="cursor: pointer;">
                                                <td class="my-auto py-4">{{ $row->title }}</td>
                                                <td class="w-100 py-4">{!! $row->short_body !!}</td>
                                                <td class="w-25 py-4">{{ $row->category->name_ar }}</td>
{{--                                                <td class="w-25 py-4">{{ $row->city->name_ar }}</td>--}}
{{--                                                <td class="py-4">{{ $row->date }}</td>--}}
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center p-5"> لا توجد بيانات  </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <br>

        </div>
    </div>
@endsection

@section('add-scripts')
    <script>
        jQuery(document).ready(function($) {
            $(".clickable-row").click(function() {
                window.location = $(this).data("href");
            });
        });
    </script>
@endsection
