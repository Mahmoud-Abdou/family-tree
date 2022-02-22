@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-guide-fill"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('admin.roles.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-guide-fill"> </i> {{ $menuTitle }}</h5>
                            @can('roles.create')
                                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                            @endcan
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table m-0 px-2">
                                    <thead>
                                    <tr>
                                        <th scope="col">الاسم</th>
                                        <th scope="col">الوصف</th>
                                        <th scope="col">المدينة</th>
                                        <th scope="col">عدد المستخدمين</th>
                                        <th scope="col">تاريخ الانشاء</th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($rolesData->count() > 0)
                                        @foreach($rolesData as $role)
                                            <tr>
                                                <td>{{ $role->name_ar }}</td>
                                                <td>{{ $role->description }}</td>
                                                <td>@isset($role->cities) {{ $cities->where('id', $role->cities)->first()->name_ar }} @else - @endisset</td>
                                                <td>{{ $role->usersCount }}</td>
                                                <td>{{ $role->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <div class="d-flex justify-center">
                                                        @can('roles.read|roles.update')
                                                        <a class="btn btn-outline-info rounded-pill mx-1" href="{{ route('admin.roles.show', $role->id) }}"><i class="ri-information-fill"> </i></a>
                                                        <a class="btn btn-outline-warning rounded-pill mx-1" href="{{ route('admin.roles.edit', $role->id) }}"><i class="ri-edit-2-fill"> </i></a>
                                                        @endcan
                                                        @can('roles.delete')
                                                        <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-outline-danger rounded-pill mx-1"><i class="ri-delete-back-2-fill"> </i></button>
                                                        </form>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center p-5"> لا توجد بيانات </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $rolesData->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
