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
                    <div class="card iq-mb-3">
                        <div class="card-header d-flex inline-flex justify-content-between">
                            <h5 class="my-auto"><i class="ri-search-2-line"> </i>{{ $menuTitle }}</h5>

                            <div>
                                <form method="POST" action="{{ route('search') }}" class="search-box">
                                    @csrf

                                    <div class="inline-flex">
                                        <button type="submit" class="btn btn-outline-primary p-2"><i class="ri-search-line"></i></button> &nbsp;
                                        <input id="searchForm" type="text" name="search" class="text search-input" value="{{ $searchWord }}" placeholder="اكتب هنا للبحث..." />
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="list-group">
                                @if($searchResult->count() > 0)
                                    <span class="list-group-item text-center iq-bg-secondary">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <p>الصورة</p>
                                            </div>
                                            <div class="col-lg-3">
                                                <p>الاسم الكامل</p>
                                            </div>
                                            <div class="col-lg-1">
                                                <p>النوع</p>
                                            </div>
                                            <div class="col-lg-2">
                                                <p>الحالة</p>
                                            </div>
                                            <div class="col-lg-2">
                                                <p>الوظيفة</p>
                                            </div>
                                            <div class="col-lg-2">
                                                <p>تاريخ الميلاد</p>
                                            </div>
                                        </div>
                                    </span>
                                @foreach($searchResult as $data)
                                    <a href="{{ route('search.result', [$searchWord, $data->user->id]) }}" class="list-group-item list-group-item-action text-center {{ $data->gender == 'male' ? ($data->has_family ? 'iq-bg-primary' : 'iq-bg-info') : ($data->has_family ? 'iq-bg-purple' : 'iq-bg-pink') }}">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <img src="{{ $data->photo }}" width="40" class="rounded-circle ml-3" alt="لا توجد صورة">
                                            </div>
                                            <div class="col-lg-3">
                                            <p>{{ $data->full_name }}</p>
                                            </div>
                                            <div class="col-lg-1">
                                            <p>{{ $data->genderName() }}</p>
                                            </div>
                                            <div class="col-lg-2">
                                            <p>{{ $data->status }}</p>
                                            </div>
                                            <div class="col-lg-2">
                                            <p>{{ $data->job }}</p>
                                            </div>
                                            <div class="col-lg-2">
                                            <p>{{ $data->birth_date }}</p>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                                @else
                                    <p class="list-group-item list-group-item-action text-center">
                                        لا توجد بيانات في نتائج البحث
                                    </p>
                                @endif
                            </div>

                        </div>
                        <div class="card-footer text-muted">
                            <p class="m-0 my-auto"> عدد نتائج البحث:  <span class="badge badge-pill border border-dark text-dark">{{ $searchResult->count() }}</span></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
