@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-archive-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('roles.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-archive-line"> </i> {{ $menuTitle }}</h5>
                            <a href="{{ route('log.destroy') }}" class="btn btn-danger rounded-pill float-right"><i class="ri-delete-back-2-fill"> </i>حذف كامل السجل</a>
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table m-0 px-2">
                                    <thead>
                                    <tr>
                                        <th scope="col">النشاط</th>
                                        <th scope="col">المستخدم</th>
                                        <th scope="col">النوع</th>
                                        <th scope="col">العملية</th>
                                        <th scope="col">البروتوكول</th>
                                        <th scope="col">الرابط</th>
                                        <th scope="col">الآي بي</th>
                                        <th scope="col">الجهاز المتصفح</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($activities->count() > 0)
                                        @foreach($activities as $log)
                                            <tr>
                                                <td>{{ $log->subject }}</td>
                                                <td>@isset($log->user_id) {{ $log->user->name }} @else - @endisset</td>
                                                <td>{{ $log->action }}</td>
                                                <td>{{ isset($log->log) ? $log->log->name : $log->action_id }}</td>
                                                <td>{!! $log->method !!}</td>
                                                <td><a href="{{ url($log->uri) }}">{{ $log->uri }}</a></td>
                                                <td>{{ $log->ip_address }}</td>
                                                <td>{{ $log->agent }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="8" class="text-center"> لا توجد بيانات </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <br>
                            <div class="d-flex justify-content-around">{{ $activities->links() }}</div>

                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $activities->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
