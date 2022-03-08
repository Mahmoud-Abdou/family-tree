@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-2-fill"> </i>'.$menuTitle, 'slots' => [['title' => 'المستخدمين', 'link' => route('admin.users.index')], ['title' => $menuTitle, 'link' => route('admin.users.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12">
                    @include('partials.messages')
                    @include('partials.errors-messages')
                </div>

                <div class="col-sm-12">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height shadow">
                        <div class="iq-card-body profile-page p-0">
                            <div class="profile-header">
                                <div class="cover-container">
                                    <img src="{{ secure_asset('assets/images/profile-bg.jpg') }}" alt="profile-bg" class="rounded img-fluid w-100">
                                </div>
                                <div class="profile-info p-4">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="user-detail pl-5">
                                                <div class="d-flex flex-wrap align-items-center">
                                                    <div class="profile-img pr-4">
                                                        <img src="{{ $person->photo }}" alt="الصورة" class="avatar-130 img-fluid">
                                                    </div>
                                                    <div class="profile-detail d-flex align-items-center">
                                                        <h3>{{ $person->prefix }} {{ $person->full_name }}</h3>
                                                        @isset($person->job) <p class="m-0 pl-3"> - {{ $person->job }} </p> @endisset
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-6">
                                            <ul class="nav nav-pills d-flex align-items-end float-right profile-feed-items p-0 m-0">
                                                <li>
                                                    <a class="nav-link " data-toggle="pill" href="#profile-family">العائلة</a>
                                                </li>
                                                <li>
                                                    <a class="nav-link active" data-toggle="pill" href="#profile-profile">الملف الشخصي</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="tab-content">
                        @include('dashboard.users.family-section', ['ownFamily' => $person->OwnFamily, 'family' => $person->belongsToFamily, 'personsData' => $allPersons, 'fosterPersonsData' => $fosterPersons])

                        @include('auth.profile-profile', ['profile' => $person])
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
