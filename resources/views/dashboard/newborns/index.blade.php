@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-smile-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('admin.dashboard')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3 shadow-sm">
                        <div class="card-header d-inline-flex justify-content-between">
                            <h5 class="float-left my-auto"><i class="ri-user-smile-line"> </i> {{ $menuTitle }}</h5>
                            <button type="button" class="btn btn-outline-secondary rounded-pill" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                                <i class="ri-filter-2-line"> </i>البحث في النتائج
                            </button>
                        </div>

                        <div class="card-header collapse" id="collapseFilters">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <label for="title-filter">بحث  بالعنوان</label>
                                        <input type="text" class="form-control" name="title" id="title-filter" value="{{ isset($_GET['filters']['title']) ? $_GET['filters']['title'] : '' }}" placeholder="بحث  بالعنوان">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <label for="body-filter">بحث بالمحتوى</label>
                                        <input type="text" class="form-control" name="body" id="body-filter" value="{{ isset($_GET['filters']['body']) ? $_GET['filters']['body'] : '' }}" placeholder="بحث بالمحتوى">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <label for="name-filter">بحث بالاسم</label>
                                        <input type="text" class="form-control" name="name" id="name-filter" value="{{ isset($_GET['filters']['owner_name']) ? $_GET['filters']['owner_name'] : '' }}" placeholder="بحث بالاسم">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <label for="email-filter">بحث بالبريد الالكتروني</label>
                                        <input type="email" class="form-control" name="email" id="email-filter" value="{{ isset($_GET['filters']['owner_email']) ? $_GET['filters']['owner_email'] : '' }}" placeholder="بحث بالبريد الالكتروني">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <label for="mobile-filter">بحث برقم الجوال</label>
                                        <input type="text" class="form-control" name="mobile" id="mobile-filter" value="{{ isset($_GET['filters']['owner_phone']) ? $_GET['filters']['owner_phone'] : '' }}" placeholder="بحث برقم الجوال">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <label for="date-filter">بحث بالتاريخ</label>
                                        <select class="form-control" name="date" id="date-filter">
                                            <option disabled="">بحث بالتاريخ</option>
                                            <option value="">الكل</option>
                                            <option {{ isset($_GET['filters']['date']) && $_GET['filters']['date'] == 1 ? 'selected=""' : '' }} value="1">اخبار السنة</option>
                                            <option {{ isset($_GET['filters']['date']) && $_GET['filters']['date'] == 2 ? 'selected=""' : '' }} value="2">اخبار الشهر</option>
                                            <option {{ isset($_GET['filters']['date']) && $_GET['filters']['date'] == 3 ? 'selected=""' : '' }} value="3">اخبار اخر 3 اشهر</option>
                                            <option {{ isset($_GET['filters']['date']) && $_GET['filters']['date'] == 4 ? 'selected=""' : '' }} value="4">اخبار اخر 6 اشهر</option>

                                        </select>
                                        <div class="invalid-tooltip">
                                            بحث بالتاريخ
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-2 mt-3 mb-auto">
                                    <div class="p-1 d-block d-md-block d-lg-none"></div>
                                    <button type="submit" onclick="filter_data()" class="btn btn-primary rounded-pill py-2 w-100">بحث</button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table m-0 text-center">
                                    <thead>
                                    <tr>
                                        <th scope="col">عنوان</th>
                                        <th scope="col">وصف</th>
                                        <th scope="col">الناشر</th>
                                        <th scope="col">الصورة</th>
                                        <th scope="col">التاريخ</th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($newborns->count() > 0)
                                        @foreach($newborns as $newborn)
                                            <tr>
                                                <td class="align-middle">{{ $newborn->title }}</td>
                                                <td class="align-middle">{!! $newborn->short_body !!}</td>
                                                <td class="align-middle"><a href="{{ route('admin.users.show', $newborn->owner_id) }}">{{ $newborn->owner->name }}</a></td>
                                                <td class="align-middle">
                                                    <img src="{{ isset($newborn->image->file) ? $newborn->image->file : url('default.png') }}" class="img-thumbnail" alt="صورة المولود" style="height: 80px;">
                                                </td>
                                                <td class="align-middle" dir="ltr">{{ date('Y-m-d', strtotime($newborn->newborns_date)) }}</td>
                                                <td class="align-middle">
                                                    <div class="d-flex justify-center">
                                                        @can('newborns.update')
                                                        <a class="btn btn-outline-warning rounded-pill m-1 px-3" href="{{ route('admin.newborns.edit', $newborn) }}"><i class="ri-edit-2-fill"></i></a>
                                                        @endcan
                                                        @can('newborns.delete')
                                                            <button type="button" onclick="openDeleteModel(`{{ route('admin.newborns.destroy', $newborn) }}`)"  data-toggle="modal" data-target=".deleteModel" class="btn btn-outline-danger rounded-pill m-1 px-3"><i class="ri-delete-back-2-fill"></i></button>
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

                            @if($newborns->lastPage() > 1)
                                <hr class="pt-0 mt-0" />
                            @endif

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

    <div class="modal fade deleteModel " tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-modal="true" >
        <div class="modal-dialog " role="document">
            <div class="modal-content shadow">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="deleteModalLabel">هل ترغب في الازالة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form id="DeleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <p>سيتم مسح الخبر .</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger" >مسح الخبر</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('add-scripts')

<script>
    function openDeleteModel(data){
        $('#DeleteForm').attr('action', data)
    }

    function filter_data(){
        title_filter = $('#title-filter').val();
        body_filter = $('#body-filter').val();
        name_filter = $('#name-filter').val();
        email_filter = $('#email-filter').val();
        mobile_filter = $('#mobile-filter').val();
        date_filter = $('#date-filter').val();
        relatives_filter = $('#relatives-filter').is(':checked')
        quary_string = "";
        if(title_filter){
            quary_string += `filters[title]=${title_filter}&`;
        }
        if(body_filter){
            quary_string += `filters[body]=${body_filter}&`;
        }
        if(name_filter){
            quary_string += `filters[owner_name]=${name_filter}&`;
        }
        if(email_filter){
            quary_string += `filters[owner_email]=${email_filter}&`;
        }
        if(mobile_filter){
            quary_string += `filters[owner_phone]=${mobile_filter}&`;
        }
        if(date_filter){
            quary_string += `filters[date]=${date_filter}&`;
        }
        if(relatives_filter){
                quary_string += `filters[relatives]=${relatives_filter}&`;
            }
            window.location = 'newborns?' + quary_string;
    }
</script>
@endsection
