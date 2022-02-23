@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-map-2-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('admin.cities.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-map-2-line"> </i> {{ $menuTitle }}</h5>
                            @can('cities.create')
                                <a href="{{ route('admin.cities.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                            @endcan
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table m-0 px-2">
                                    <thead>
                                    <tr>
                                        <th scope="col">الرابط</th>
                                        <th scope="col">الدولة</th>
                                        <th scope="col">المدينة</th>
                                        <th scope="col">عدد المستخدمين</th>
                                        <th scope="col">الحالة</th>
                                        <th scope="col">تاريخ الانشاء</th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($cities->count() > 0)
                                        @foreach($cities as $city)
                                            <tr>
                                                <td>{{ $city->slug }}</td>
                                                <td>{{ $city->country_ar }}</td>
                                                <td>{{ $city->name_ar }}</td>
                                                <td>{{ $city->users()->count() }}</td>
                                                <td>{!! $city->status !!}</td>
                                                <td>{{ $city->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <div class="d-flex justify-center">
                                                        @can('cities.read|cities.update')
                                                        <a class="btn btn-outline-info rounded-pill mx-1" href="{{ route('admin.cities.show', $city) }}"><i class="ri-information-fill"></i></a>
                                                        <a class="btn btn-outline-warning rounded-pill mx-1" href="{{ route('admin.cities.edit', $city) }}"><i class="ri-edit-2-fill"></i></a>
                                                        @endcan
                                                        @can('cities.delete')
                                                        <form action="{{ route('admin.cities.destroy', $city) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-outline-danger rounded-pill mx-1"><i class="ri-delete-back-2-fill"></i></button>
                                                        </form>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center p-5"> لا توجد بيانات </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

{{--                            @if($cities->hasMorePages())--}}
                            @if($cities->lastPage() > 1)
                                <hr class="pt-0 mt-0" />
                            @endif

                            <div class="d-flex justify-content-around">{{ $cities->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $cities->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
