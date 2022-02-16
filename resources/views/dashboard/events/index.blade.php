@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-calendar-event-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('admin.dashboard')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-calendar-event-line"> </i> {{ $menuTitle }}</h5>
                            @can('events.create')
                                <a href="{{ route('admin.events.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                            @endcan
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table m-0 px-2">
                                    <colgroup>
                                        <col span="1" style="width: 10%;">
                                        <col span="1" style="width: 10%;">
                                        <col span="1" style="width: 30%;">
                                        <col span="1" style="width: 10%;">
                                        <col span="1" style="width: 10%;">
                                        <col span="1" style="width: 15%;">
                                        <col span="1" style="width: 15%;">
                                    </colgroup>

                                    <thead>
                                    <tr>
                                        <th scope="col">المدينة</th>
                                        <th scope="col">عنوان</th>
                                        <th scope="col">وصف </th>
                                        <th scope="col">الناشر </th>
                                        <th scope="col">الصورة</th>
                                        <th scope="col">التاريخ </th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($events->count() > 0)
                                        @foreach($events as $event)
                                            <tr>
                                                <td>{{ $event->city->name_ar }}</td>
                                                <td>{{ $event->title }}</td>
                                                <td>{!! $event->short_body !!}</td>
                                                <td>{{ $event->owner->name }}</td>
                                                <td>
                                                    <img src="{{ isset($event->image->file) ? $event->image->file : 'default.png' }}" alt="{{ $event->title }}" style="height: 100px;width: 100px;">
                                                </td>
                                                <td dir="ltr">{{ date('Y-m-d | H:i', strtotime($event->event_date)) }}</td>
                                                <td>
                                                    <div class="d-flex justify-center">
{{--                                                        @if($event->owner_id == auth()->user()->id)--}}
                                                            @can('events.update')
                                                            <a class="btn btn-outline-warning rounded-pill m-1 px-3" href="{{ route('admin.events.edit', $event) }}"><i class="ri-edit-2-fill"></i></a>
                                                            @endcan
                                                            @can('events.delete')
                                                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" class="btn btn-outline-danger rounded-pill m-1 px-3"><i class="ri-delete-back-2-fill"></i></button>
                                                            </form>
                                                            @endcan
                                                            @if(!$event->approved)
                                                            <form method="POST" action="{{ route('admin.events.activate') }}">
                                                                @csrf
                                                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                                                <button type="submit" class="btn btn-outline-success rounded-pill m-1 px-3"><i class="ri-arrow-up-circle-line"></i></button>
                                                            </form>
                                                            @endif
{{--                                                        @endif--}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center"> لا توجد بيانات </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-around">{{ $events->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $events->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
