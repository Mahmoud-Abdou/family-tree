@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-newspaper-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('news.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-newspaper-line"> </i> {{ $menuTitle }}</h5>
                            @can('news.create')
                                <a href="{{ route('news.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                            @endcan
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table m-0 px-2">
                                    <thead>
                                    <tr>
                                        <th scope="col">المدينة</th>
                                        <th scope="col">عنوان</th>
                                        <th scope="col">وصف </th>
                                        <th scope="col">المالك </th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($news->count() > 0)
                                        @foreach($news as $row_news)
                                            <tr>
                                                <td>{{ $row_news->city->name_ar }}</td>
                                                <td>{{ $row_news->title }}</td>
                                                <td>{{ $row_news->body }}</td>
                                                <td>{{ $row_news->owner->name }}</td>
                                                <td>
                                                    <div class="d-flex justify-center">
{{--                                                        @if($row_news->owner_id == auth()->user()->id)--}}
                                                            <a class="btn btn-outline-info rounded-pill mx-1" href="{{ route('news.show', $row_news) }}"><i class="ri-information-fill"></i></a>
                                                            @can('news.update')
                                                            <a class="btn btn-outline-warning rounded-pill mx-1" href="{{ route('news.edit', $row_news) }}"><i class="ri-edit-2-fill"></i></a>
                                                            @endcan
                                                            @can('news.delete')
                                                            <form action="{{ route('news.destroy', $row_news) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" class="btn btn-outline-danger rounded-pill mx-1"><i class="ri-delete-back-2-fill"></i></button>
                                                            </form>
                                                            @endcan
{{--                                                        @endif--}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center"> لا توجد بيانات </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-around">{{ $news->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $news->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
