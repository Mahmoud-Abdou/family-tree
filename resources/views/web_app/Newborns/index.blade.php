@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-home-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('home')],]])
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
                            @can('newborns.create')
                                <a href="{{ route('newborns.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                            @endcan
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table m-0 px-2">
                                    <thead>
                                    <tr>
                                        <th scope="col">العائلة</th>
                                        <th scope="col">عنوان</th>
                                        <th scope="col">وصف </th>
                                        <th scope="col">المالك </th>
                                        <th scope="col">الصورة</th>
                                        <th scope="col">التاريخ </th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($newborns->count() > 0)
                                        @foreach($newborns as $newborn)
                                            <tr>
                                                <td>{{ $newborn->family->name }}</td>
                                                <td>{{ $newborn->title }}</td>
                                                <td>{{ $newborn->body }}</td>
                                                <td>{{ $newborn->owner->name }}</td>
                                                <td>
                                                    <img src="{{ $newborn->image->file }}" alt="" style="height: 100px;width: 100px;">
                                                </td>
                                                <td>{{ date("d-m-Y", $newborn->date) }}</td>
                                                <td>
                                                    <div class="d-flex justify-center">
                                                        @if($newborn->owner_id == auth()->user()->id)
                                                            @can('newborns.update')
                                                            <a class="btn btn-outline-warning rounded-pill mx-1" href="{{ route('newborns.edit', $newborn) }}"><i class="ri-edit-2-fill"></i></a>
                                                            @endcan
                                                            @can('newborns.delete')
                                                            <form action="{{ route('newborns.destroy', $newborn) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" class="btn btn-outline-danger rounded-pill mx-1"><i class="ri-delete-back-2-fill"></i></button>
                                                            </form>
                                                            @endcan
                                                        @endif
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

                            <div class="d-flex justify-content-around">{{ $newborns->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $newborns->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
