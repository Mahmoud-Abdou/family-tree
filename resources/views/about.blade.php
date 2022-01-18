@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-information-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('about')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="row">
                <div class="col">
                    <h1>نبذة عن العائلة</h1>
                </div>
            </div>

        </div>
    </div>
@endsection
