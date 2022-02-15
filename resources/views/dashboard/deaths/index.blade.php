@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-calendar-event-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('admin.dashboard')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-calendar-event-line"> </i> {{ $menuTitle }}</h5>
                            <div class="row">
                                <div class="col-md-1">
                                    <div class="form-group my-auto">
                                        <input type="text" class="form-control" name="title" id="title-filter" value="{{ isset($_GET['filters']['title']) ? $_GET['filters']['title'] : '' }}" placeholder="بحث  بالعنوان">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group my-auto">
                                        <input type="text" class="form-control" name="body" id="body-filter" value="{{ isset($_GET['filters']['body']) ? $_GET['filters']['body'] : '' }}" placeholder="بحث بالوصف ">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group my-auto">
                                        <input type="text" class="form-control" name="name" id="name-filter" value="{{ isset($_GET['filters']['owner_name']) ? $_GET['filters']['owner_name'] : '' }}" placeholder="بحث برقم الجوال">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group my-auto">
                                        <input type="email" class="form-control" name="email" id="email-filter" value="{{ isset($_GET['filters']['owner_email']) ? $_GET['filters']['owner_email'] : '' }}" placeholder="بحث بالبريد الالكتروني">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group my-auto">
                                        <input type="text" class="form-control" name="mobile" id="mobile-filter" value="{{ isset($_GET['filters']['owner_phone']) ? $_GET['filters']['owner_phone'] : '' }}" placeholder="بحث برقم الجوال">
                                    </div>
                                </div>

                                

                                

                                <div class="col-md-1">
                                    <div class="form-group my-auto">
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

                                

                                

                                <div class="col-md-2 my-auto">
                                    <button type="submit" onclick="filter_data()" class="btn btn-primary rounded-pill py-2 w-100">فلتر البيانات</button>
                                </div>
                            </div>
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
                                        <col span="1" style="width: 15%;">
                                        <col span="1" style="width: 15%;">
                                    </colgroup>

                                    <thead>
                                    <tr>
                                        <th scope="col">عنوان</th>
                                        <th scope="col">وصف </th>
                                        <th scope="col">الناشر </th>
                                        <th scope="col">الصورة</th>
                                        <th scope="col">التاريخ </th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($deaths->count() > 0)
                                        @foreach($deaths as $death)
                                            <tr>
                                                <td>{{ $death->title }}</td>
                                                <td>{!! $death->body !!}</td>
                                                <td>{{ $death->owner->name }}</td>
                                                <td>
                                                    <img src="{{ isset($death->image->file) ? $death->image->file : 'default.png' }}" alt="{{ $death->title }}" style="height: 100px;width: 100px;">
                                                </td>
                                                <td dir="ltr">{{ date('Y-m-d | H:i', strtotime($death->deaths_date)) }}</td>
                                                <td>
                                                    <div class="d-flex justify-center">
                                                        @can('deaths.update')
                                                        <a class="btn btn-outline-warning rounded-pill m-1 px-3" href="{{ route('admin.deaths.edit', $death) }}"><i class="ri-edit-2-fill"></i></a>
                                                        @endcan
                                                        @can('deaths.delete')
                                                        
                                                            <button type="button" onclick="openDeleteModel(`{{ route('admin.deaths.destroy', $death) }}`)"  data-toggle="modal" data-target=".deleteModel" class="btn btn-outline-danger rounded-pill m-1 px-3"><i class="ri-delete-back-2-fill"></i></button>
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

                            <div class="d-flex justify-content-around">{{ $deaths->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $deaths->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-xl deleteModel " tabindex="-1" role="dialog" aria-modal="true" >
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">هل ترغب في الازالة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                
                <form id="DeleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">لا</button>
                        <button type="submit" class="btn btn-primary" >نعم</button>
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
        window.location = 'deaths?' + quary_string;
    }
</script>
@endsection

