@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-price-tag-2-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('admin.categories.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-price-tag-2-line"> </i> {{ $menuTitle }}</h5>
                            @can('categories.create')
                                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                            @endcan
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table m-0 px-2">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">الاسم</th>
                                        <th scope="col">النوع</th>
                                        <th scope="col">الايقونة</th>
                                        <th scope="col">الصورة</th>
                                        <th scope="col">تاريخ الانشاء</th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($categories->count() > 0)
                                        @foreach($categories as $key => $category)
                                            <tr>
                                                <td>{{ ++$key }}</td>
                                                <td>{{ $category->name_ar }}</td>
                                                <td>{!! $category->typeHtml() !!}</td>
                                                <td style="max-width: 60px;">
                                                    <div class="media">
                                                        <img src="{{ $category->icon }}" class="align-self-center img-thumbnail rounded" alt="{{$category->slug}}">
                                                    </div>
                                                </td>
                                                <td style="max-width: 60px;">
                                                    <div class="media">
                                                        <img src="{{ $category->image }}" class="align-self-center img-thumbnail rounded" alt="{{$category->slug}}">
                                                    </div>
                                                </td>
                                                <td>{{ $category->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <div class="d-flex justify-center">
                                                        @can('categories.read|categories.update')
                                                        <a class="btn btn-outline-info rounded-pill mx-1" href="{{ route('admin.categories.show', $category->id) }}"><i class="ri-information-fill"> </i></a>
                                                        <a class="btn btn-outline-warning rounded-pill mx-1" href="{{ route('admin.categories.edit', $category->id) }}"><i class="ri-edit-2-fill"> </i></a>
                                                        @endcan
                                                        @can('categories.delete')
                                                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
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
                                            <td colspan="7" class="text-center"> لا توجد بيانات </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-around">{{ $categories->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $categories->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
