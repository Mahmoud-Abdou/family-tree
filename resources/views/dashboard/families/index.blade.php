@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-group-2-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('admin.families.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3 shadow">
                        <div class="card-header d-inline-flex justify-content-between">
                            <h5><i class="ri-group-2-fill"> </i> {{ $menuTitle }}</h5>
                            <div>
                                <button type="button" class="btn btn-outline-secondary rounded-pill mx-2" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                                    <i class="ri-filter-2-line"> </i>البحث في النتائج
                                </button>
                                @can('admin.families.create')
                                    <a href="{{ route('admin.families.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                                @endcan
                            </div>
                        </div>
                        <div class="card-header collapse" id="collapseFilters">
                            <form method="GET" action="{{ route('admin.families.index') }}">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <label for="name-filter">بحث بالاسم</label>
                                        <input type="text" class="form-control" name="name" id="name-filter" value="{{ isset($_GET['name-filter']) ? $_GET['name-filter'] : '' }}" placeholder="بحث بالاسم">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                    <label for="per-page-filter">عدد النتائج في الصفحة</label>
                                    <select class="form-control" name="per-page" id="per-page-filter">
                                        <option {{ isset($_GET['per-page']) && $_GET['per-page'] == 10 ? 'selected=""' : '' }} value="10">10</option>
                                        <option {{ isset($_GET['per-page']) && $_GET['per-page'] == 20 ? 'selected=""' : '' }} value="20">20</option>
                                        <option {{ isset($_GET['per-page']) && $_GET['per-page'] == 30 ? 'selected=""' : '' }} value="20">30</option>
                                        <option {{ isset($_GET['per-page']) && $_GET['per-page'] == 50 ? 'selected=""' : '' }} value="50">50</option>
                                        <option {{ isset($_GET['per-page']) && $_GET['per-page'] == 70 ? 'selected=""' : '' }} value="50">70</option>
                                        <option {{ isset($_GET['per-page']) && $_GET['per-page'] == 100 ? 'selected=""' : '' }} value="100">100</option>
                                    </select>
                                    <div class="invalid-tooltip">
                                        حدد عدد النتائج في الصفحة الواحدة
                                    </div>
                                    </div>
                                </div>

                                <div class="col-md-2 mt-2 my-auto">
                                    <button type="submit" class="btn btn-primary rounded-pill py-2 w-100">بحث</button>
                                </div>
                            </div>
                            </form>
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table m-0">
                                    <thead>
                                    <tr>
                                        <th scope="col">الاسم</th>
                                        <th scope="col">الأب</th>
                                        <th scope="col">الأم</th>
                                        <th scope="col">الجد</th>
                                        <th scope="col">عدد الأولاد</th>
                                        <th scope="col">الحالة</th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($families->count() > 0)
                                        @foreach($families as $family)
                                            <tr>
                                                <td><a href="{{ route('admin.families.show', $family->id) }}">{{ $family->name }}</a></td>
                                                <td>{{ $family->father->full_name }}</td>
                                                <td>{{ isset($family->mother) ? $family->mother->full_name : 'لا يوجد' }}</td>
                                                <td>{{ isset($family->gfFamilies->father) ? $family->gfFamilies->father->full_name : 'لا يوجد' }}</td>
                                                <td>{{ $family->members->count() }}</td>
                                                <td>{!! $family->statusHtml() !!}</td>
                                                <td>
                                                    <div class="d-flex justify-center">
                                                    @can('families.show')
                                                        <a class="btn btn-outline-info rounded-pill mx-1" href="{{ route('admin.families.show', $family->id) }}"><i class="ri-information-fill"> </i>تفاصيل</a>
                                                    @endcan
                                                    @can('families.update')
                                                        <a class="btn btn-outline-warning rounded-pill mx-1" href="{{ route('admin.families.edit', $family->id) }}"><i class="ri-edit-2-fill"> </i>تعديل</a>
                                                    @endcan
                                                    @can('families.delete')
                                                        <button type="button" class="btn btn-outline-danger rounded-pill mx-1" data-toggle="modal" data-target="#deleteModal" onclick="modalDelete(`{{ route('admin.families.destroy', $family->id) }}`)"> &nbsp; X &nbsp; </button>
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

                            @if($families->lastPage() > 1)
                                <hr class="pt-0 mt-0" />
                            @endif

                            <div class="d-flex justify-content-around">{{ $families->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $families->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="deleteModalLabel">حذف الأسرة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form id="formDelete" method="POST" action="">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body">
                        <p>سيتم حذف الأسرة بشكل نهائي.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">حذف الأسرة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('add-scripts')
    <script>
        function modalDelete(famId) {
            $('#formDelete').attr('action', famId);
        }
    </script>
@endsection
