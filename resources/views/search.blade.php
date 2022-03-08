@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-search-2-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('home')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card iq-mb-3 shadow">
                        <div class="card-header d-flex inline-flex justify-content-between">
                            <h5 class="my-auto mx-1"><i class="ri-search-2-line"> </i>{{ $menuTitle }}</h5>

                            <form method="POST" action="{{ route('search') }}" class="search-box">
                                @csrf

                                <div class="d-inline-flex">
                                    <input id="searchForm" type="text" name="search" class="text search-input" value="{{ $searchWord }}" placeholder="اكتب هنا للبحث..." />
                                    <button type="submit" class="btn btn-outline-primary px-3 mx-1"><i class="ri-search-line"></i></button> &nbsp;
                                </div>
                            </form>
                        </div>

                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table table-hover m-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">الصورة</th>
                                        <th scope="col">الاسم الكامل</th>
                                        <th scope="col">النوع</th>
                                        <th scope="col">الحالة</th>
                                        <th scope="col">الوظيفة</th>
                                        <th scope="col">تاريخ الميلاد</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($searchResult->count() > 0)
                                        @foreach($searchResult as $data)
                                            <tr class="clickable-row" data-href="{{ route('search.result', [$searchWord, $data->id]) }}" style="cursor: pointer;">
                                                <td><img src="{{ $data->photo }}" width="40" class="rounded-circle ml-3" alt="لا توجد صورة"></td>
                                                <td>{{ $data->full_name }}</td>
                                                <td>{{ $data->genderName() }}</td>
                                                <td>{{ $data->status }}</td>
                                                <td>{{ $data->job }}</td>
                                                <td>{{ $data->birth_date }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center p-5"> لا توجد بيانات في نتائج البحث </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            @if($searchResult->lastPage() > 1)
                                <hr class="pt-0 mt-0" />
                            @endif

                            <div class="d-flex justify-content-around">{{ $searchResult->links() }}</div>

                        </div>

                        <div class="card-footer text-muted">
                            عدد نتائج البحث:
                            <span class="badge badge-pill border border-dark text-dark">{{ $searchResult->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

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
