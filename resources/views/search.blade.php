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

                        @foreach($searchResult as $data)
                            <div class="d-flex inline-flex justify-content-between">
                                <a href=""><img src="{{ $data->photo }}" width="50" class="rounded-circle ml-3" alt="{{ $data->full_name }}"></a>
                                <a href="">{{ $data->full_name }}</a>
                                <p>{{ $data->genderName() }}</p>
                                <p>{{ $data->status }}</p>
                                <p>{{ $data->job }}</p>
                                <p>{{ $data->birth_date }}</p>
                                <p>{{ $data->color }}</p>
                            </div>

                            @if(!$loop->last)
                                <hr class="px-0 mx-0">
                            @endif

                        @endforeach

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
