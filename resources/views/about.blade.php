@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-information-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('about')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card iq-mb-3 shadow">
                        <div class="card-header">
                            <h5>
                                <i class="ri-information-line"> </i>
                                {{ $menuTitle }}
                            </h5>
                        </div>
                        <div class="card-body">
                            {!! $content !!}
                        </div>
                        <div class="card-footer text-muted">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
