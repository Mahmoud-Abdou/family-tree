@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-group-2-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('home')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5>
                                <i class="ri-group-2-line"> </i>
                                {{ $menuTitle }}
                            </h5>
                        </div>
                        <div class="card-body p-0 m-0">
                            <img src="{{ $content }}" class="img-fluid max-width" alt="family tree">
                        </div>
                        <div class="card-footer text-muted">
                            <span>آخر تعديل في : </span>
                            <span dir="ltr">{{ $time }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
