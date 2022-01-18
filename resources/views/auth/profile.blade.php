@extends('layouts.master')

@section('page-title', 'الملف الشخصي')

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-2-fill"> </i>الملف الشخصي', 'slots' => [['title' => 'الملف الشخصي', 'link' => route('users.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">



            </div>
        </div>
    </div>
@endsection
