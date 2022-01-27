@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-calendar-event-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('home')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                @foreach($events as $event)
                    <div class="col-sm-4">
                    <a href="{{ route('events.show', $event->id) }}">
                        <div class="card iq-mb-3">
                            <img src="{{ $event->image->file }}" class="card-img-top img-fluid w-auto" alt="{{ $event->title }}">
                            <div class="card-body">
                                <h4 class="card-title">{{ $event->title }}</h4>
                                <p class="card-text">{!! $event->body !!}</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between">
                                    <p class="card-text"><i class="ri-timer-2-fill"> </i><small class="text-muted">{{ $event->event_date }}</small></p>
                                    <p class="card-text"><i class="ri-map-pin-2-fill"> </i><small class="text-muted">{{ $event->city->name_ar }}</small></p>
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
