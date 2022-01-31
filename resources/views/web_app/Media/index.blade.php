@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-home-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('home')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                @foreach($categories as $category)
                    <div class="col-sm-4">
                        <a href="{{ route('media.show', $category->id) }}">
                            <div class="card iq-mb-3">
                                <img src="{{ isset($category->image) ? $category->image : 'default.png' }}" class="card-img-top img-fluid w-auto" alt="{{ $category->slug }}">
                                <div class="card-body">
                                    <h4 class="card-title">{{ $category->name_ar }}</h4>
                                    <hr />
                                    <p class="card-text">{!! $category->slug !!}</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
               

            </div>
        </div>
    </div>
@endsection
