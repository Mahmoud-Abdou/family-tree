@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-home-fill"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('terms')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="row">
                <div class="col">
                    <h1>Home</h1>
                    <x-message type="success" message="Hello"/>
                    <x-message type="warning" message="Hello"/>
                    <x-message type="danger" message="Hello"/>
                </div>
            </div>

        </div>
    </div>
@endsection
