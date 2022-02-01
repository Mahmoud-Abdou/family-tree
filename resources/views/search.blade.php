@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-search-2-fill"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('about')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card iq-mb-3">
                        <div class="card-header d-flex inline-flex justify-content-between">
                            <h5 class="my-auto"><i class="ri-search-2-fill"> </i>{{ $menuTitle }}</h5>

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
                                @foreach($searchResult as $data)
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="row">
                                            <div class="col-lg-2">
                                                <img src="{{ $data->photo }}" width="40" class="rounded-circle ml-3" alt="{{ $data->full_name }}">
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
