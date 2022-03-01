@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-2-fill"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('admin.users.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')
                    
                    <div class="card iq-mb-3 shadow">
                        <div class="card-header d-inline-flex justify-content-between">
                            <h5><i class="ri-user-2-fill"> </i> {{ $menuTitle }}</h5>
                            <button type="button" class="btn btn-outline-secondary rounded-pill" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                                <i class="ri-filter-2-line"> </i>البحث في النتائج
                            </button>
                            @can('admin.users.create')
                                <a href="{{ route('admin.users.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                            @endcan
                        </div>
                        <div class="card-header collapse" id="collapseFilters">
                            <form method="GET" action="{{ route('admin.users.index') }}">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <label for="email-filter">بحث بالبريد الالكتروني</label>
                                        <input type="email" class="form-control" name="email" id="email-filter" value="{{ isset($_GET['email']) ? $_GET['email'] : '' }}" placeholder="بحث بالبريد الالكتروني">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <label for="mobile-filter">بحث برقم الجوال</label>
                                        <input type="text" class="form-control" name="mobile" id="mobile-filter" value="{{ isset($_GET['mobile']) ? $_GET['mobile'] : '' }}" placeholder="بحث برقم الجوال">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                    <label for="status-filter">بحث بالحالة</label>
                                    <select class="form-control" name="status" id="status-filter">
                                        <option disabled="">حدد الحالة</option>
                                        <option {{ isset($_GET['status']) && $_GET['status'] == 'all' ? 'selected=""' : '' }} value="all">الكل</option>
                                        <option {{ isset($_GET['status']) && $_GET['status'] == 'registered' ? 'selected=""' : '' }} value="registered">مسجل جديد</option>
                                        <option {{ isset($_GET['status']) && $_GET['status'] == 'active' ? 'selected=""' : '' }} value="active">نشط</option>
                                        <option {{ isset($_GET['status']) && $_GET['status'] == 'blocked' ? 'selected=""' : '' }} value="blocked">محظور</option>
                                    </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                    <label for="city-filter">بحث بالمدينة</label>
                                    <select class="form-control" name="city" id="city-filter">
                                        <option disabled="">حدد المدينة</option>
                                        <option {{ isset($_GET['city']) && $_GET['city'] == 'all' ? 'selected=""' : '' }} value="all">الكل</option>
                                        @foreach($cities as $city)
                                            <option {{ isset($_GET['city']) && $city->id == $_GET['city'] ? 'selected=""' : '' }} value="{{ $city->id }}">{{ $city->name_ar }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-tooltip">
                                        حدد المدينة
                                    </div>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                    <label for="role-filter">بحث بالصلاحية</label>
                                    <select class="form-control" name="role" id="role-filter">
                                        <option disabled="">حدد الصلاحية</option>
                                        <option {{ isset($_GET['role']) && $_GET['role'] == 'all' ? 'selected=""' : '' }} value="all">الكل</option>
                                        @foreach($rolesData as $role)
                                            <option {{ isset($_GET['role']) && $role->id == $_GET['role'] ? 'selected=""' : '' }} value="{{ $role->id }}">{{ $role->name_ar }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-tooltip">
                                        حدد الصلاحية
                                    </div>
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
                                        حدد عدد المستخدمين في الصفحة الواحدة
                                    </div>
                                    </div>
                                </div>

                                <div class="col-md-2 mt-2">
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
                                        <th scope="col">البريد الالكتروني</th>
                                        <th scope="col">الجوال</th>
                                        <th scope="col">المدينة</th>
                                        <th scope="col">الحالة</th>
                                        <th scope="col">تاريخ الاشتراك</th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($usersData->count() > 0)
                                        @foreach($usersData as $user)
                                            <tr>
                                                <td><a href="{{ route('admin.users.show', $user->id) }}">@isset($user->user) {{ $user->user->name }} @else {{ $user->first_name }} @endisset</a></td>
                                                <td>@isset($user->user) {{ $user->user->email }} @else - @endisset</td>
                                                <td>@isset($user->user) {{ $user->user->mobile }} @else - @endisset</td>
                                                <td>@isset($user->user) {{ $user->user->city->name_ar }} @else - @endisset</td>
                                                <td>
                                                    @isset($user->user) {!! $user->user->statusHtml() !!} @else - @endisset 
                                                </td>
                                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <div class="d-flex justify-center">
                                                    <a class="btn btn-outline-info rounded-pill m-1" href="{{ route('admin.users.show', $user->id) }}"><i class="ri-information-fill"> </i>تفاصيل</a>
                                                    @can('users.update')
                                                    @if(isset($user->user) && ($user->user->status == 'registered' || $user->user->status == 'blocked'))
                                                        <form method="POST" action="{{ route('admin.users.activate') }}">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $user->user->id }}">
                                                            <button type="submit" class="btn btn-outline-success rounded-pill m-1"><i class="ri-arrow-up-circle-line"> </i>تفعيل</button>
                                                        </form>
                                                    @endif
                                                    @if(isset($user->user) && $user->user->status == 'active')
                                                        <button type="button" class="btn btn-outline-warning rounded-pill m-1" data-toggle="modal" data-target="#roleModal" onclick="modalRole({{ $user->user->id }})"><i class="ri-guide-line"> </i>الصلاحيات</button>
                                                    @endif
                                                    @endcan
                                                    @can('users.delete')
                                                        @if(isset($user->user) && $user->user->status == 'active')
                                                            <button type="button" class="btn btn-outline-danger rounded-pill m-1" data-toggle="modal" data-target="#blockModal" onclick="modalBlock({{ $user->user->id }})"><i class="ri-delete-back-fill"></i></button>
                                                        @endif
                                                    @endcan
                                                    @can('users.update')
                                                        <a class="btn btn-outline-warning rounded-pill mx-1" href="{{ route('admin.users.edit', $user->id) }}"><i class="ri-edit-2-fill"> </i></a>
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

                            @if($usersData->lastPage() > 1)
                                <hr class="pt-0 mt-0" />
                            @endif

                            <div class="d-flex justify-content-around">{{ $usersData->links() }}</div>

                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $usersData->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="roleModalLabel">تحديد صلاحيات المستخدم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.users.roleAssign') }}">
                    <div class="modal-body">
                        @csrf
                        <input id="roleUserId" type="hidden" name="user_id">

                        <label for="roles">حدد الدور لاعطاء الصلاحيات</label>
                        <select class="form-control" id="roles" name="role_id">
                            <option disabled selected>حدد الدور</option>
                            @foreach($rolesData as $role)
                            <option value="{{ $role->id }}">{{ $role->name_ar }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button id="roleFormBtn" type="submit" class="btn btn-warning">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="blockModal" tabindex="-1" role="dialog" aria-labelledby="blockModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="blockModalLabel">حظر المستخدم</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('admin.users.activate') }}">
                    <div class="modal-body">
                        @csrf
                        <input id="blockUserId" type="hidden" name="user_id">
                        <input type="hidden" name="type" value="delete">

                        <p>سيتم حظر المستخدم و لن يتمكن من الدخول الى النظام.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button id="roleFormBtn" type="submit" class="btn btn-danger">حظر المستخدم</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('add-scripts')
    <script>
        function modalRole(userId) {
            $( '#roleUserId' ).val(userId);
            // $('#roleFormBtn').click( function() {
            //     $('form#roleUpdateForm').submit();
            // });
        }
        function modalBlock(userId) {
            $('#blockUserId').val(userId);
        }
    </script>
@endsection
