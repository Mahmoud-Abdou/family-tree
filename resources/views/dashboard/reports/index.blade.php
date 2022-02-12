@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-calendar-report-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('admin.dashboard')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-calendar-report-line"> </i> {{ $menuTitle }}</h5>
                            
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
                                    </colgroup>

                                    <thead>
                                    <tr>
                                        <th scope="col">الناشر </th>
                                        <th scope="col">نوع</th>
                                        <th scope="col">وصف </th>
                                        <th scope="col">التاريخ </th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($reports->count() > 0)
                                        @foreach($reports as $report)
                                            <tr>
                                                <td>{{ $report->owner->name }}</td>
                                                <td>{{ $report->type }}</td>
                                                <td>{!! $report->body !!}</td>
                                                <td dir="ltr">{{ date('Y-m-d | H:i', strtotime($report->created_at)) }}</td>
                                                <td>
                                                    <div class="d-flex justify-center">
                                                        @can('reports.show')
                                                        <a class="btn btn-outline-warning rounded-pill m-1 px-3" href="{{ route('admin.reports.show', $report) }}"><i class="ri-edit-2-fill"></i></a>
                                                        @endcan
                                                        @can('reports.delete')
                                                        <form action="{{ route('admin.reports.destroy', $report) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-outline-danger rounded-pill m-1 px-3"><i class="ri-delete-back-2-fill"></i></button>
                                                        </form>
                                                        @endcan
                                                        
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

                            <div class="d-flex justify-content-around">{{ $reports->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $reports->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
