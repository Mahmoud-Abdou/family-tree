@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-image-2-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('home')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                @foreach($categories as $category)
                    <div class="col-sm-4">
                        <div class="card shadow iq-mb-3">
                            <a class="text-center" href="{{ route('media.show', $category->slug) }}">
                                <img src="{{ isset($category->image) ? $category->image : url('default.png') }}" class="card-img-top img-fluid w-auto card-img-lo" alt="{{ $category->slug }}">
                                <hr class="m-0" />
                                <div class="card-body p-2">
                                    <h4 class="card-title text-center m-0">{{ $category->name_ar }}</h4>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
