@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-calendar-event-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('home')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card iq-mb-3 shadow-sm">
                        <div class="card-header" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                            <h5 class="float-left my-auto"><i class="ri-calendar-event-line"> </i> {{ $menuTitle }}</h5>
                            <span class="ml-5"><i class="ri-filter-2-line"> </i>البحث في النتائج</span>
                            @can('events.create')
                                <a href="{{ route('events.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                            @endcan
                        </div>
                        <div class="collapse" id="collapseFilters">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                </div>

                @foreach($events as $event)
                    <div class="col-sm-4">
                    <a href="{{ route('events.show', $event->id) }}">
                        <div class="card iq-mb-3 shadow iq-bg-primary-hover">
                            <img src="{{ isset($event->image->file) ? $event->image->file : 'default.png' }}" class="card-img-top img-fluid w-auto" alt="{{ $event->title }}">
                            <div class="card-body">
                                <h4 class="card-title">{{ $event->title }}</h4>
                                <hr />
                                <p class="card-text">{!! $event->short_body !!}</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between" dir="ltr">
                                    <p class="card-text m-0"><i class="ri-timer-2-fill"> </i><small class="text-muted">{{ date('Y-m-d | H:i', strtotime($event->event_date)) }}</small></p>
                                    <p class="card-text m-0"><i class="ri-map-pin-2-fill"> </i><small class="text-muted">{{ $event->city->name_ar }}</small></p>
                                </div>
                            </div>
                        </div>
                    </a>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection
