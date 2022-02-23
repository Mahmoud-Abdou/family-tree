@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-image-2-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('home')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-image-2-line"> </i> {{ $menuTitle }}</h5>
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <input type="text" class="form-control" name="title" id="title-filter" value="{{ isset($_GET['filters']['title']) ? $_GET['filters']['title'] : '' }}" placeholder="بحث  بالعنوان">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <input type="text" class="form-control" name="name" id="name-filter" value="{{ isset($_GET['filters']['owner_name']) ? $_GET['filters']['owner_name'] : '' }}" placeholder="بحث برقم الجوال">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <input type="email" class="form-control" name="email" id="email-filter" value="{{ isset($_GET['filters']['owner_email']) ? $_GET['filters']['owner_email'] : '' }}" placeholder="بحث بالبريد الالكتروني">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <input type="text" class="form-control" name="mobile" id="mobile-filter" value="{{ isset($_GET['filters']['owner_phone']) ? $_GET['filters']['owner_phone'] : '' }}" placeholder="بحث برقم الجوال">
                                    </div>
                                </div>

                                <div class="col-md-1">
                                    <div class="form-group my-auto">
                                    <select class="form-control" name="category" id="category-filter">
                                        <option disabled="">حدد النوع</option>
                                        <option {{ isset($_GET['filters']['category']) && $_GET['filters']['category'] == '' ? 'selected=""' : '' }} value="">الكل</option>
                                        @foreach($categories as $category)
                                            <option {{ isset($_GET['filters']['category']) && $category->id == $_GET['filters']['category'] ? 'selected=""' : '' }} value="{{ $category->id }}">{{ $category->name_ar }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-tooltip">
                                        حدد النوع
                                    </div>
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
                                <table class="table m-0 px-2" id="media_table">
                                    <thead>
                                    <tr>
                                        <th scope="col">العنوان</th>
                                        <th scope="col">الصورة</th>
                                        <th scope="col">النوع</th>
                                        <th scope="col">الناشر</th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($media->count() > 0)
                                        @foreach($media as $row_media)
                                            <tr>
                                                <td>{{ $row_media->title }}</td>
                                                <td>
                                                    <img src="{{ $row_media->file }}" alt="" style="height: 100px;width: 100px;">
                                                </td>
                                                <td>{{ $row_media->category->name_ar }}</td>
                                                <td><a href="{{ route('admin.users.show', $row_media->owner_id) }}">{{ $row_media->owner->name }}</a></td>
                                                <td>
                                                    <div class="d-flex justify-center">
{{--                                                        @can('media.update')--}}
{{--                                                            <a class="btn btn-outline-warning rounded-pill mx-1" href="{{ route('admin.media.destroy', $row_media) }}"><i class="ri-edit-2-fill"> </i></a>--}}
{{--                                                        @endcan--}}
                                                        @can('media.delete')
                                                            <button type="button" class="btn btn-outline-danger rounded-pill m-1" data-toggle="modal" data-target="#deleteModal" onclick="modalDelete(`{{ route('admin.media.destroy', $row_media) }}`)"><i class="ri-delete-back-2-fill"> </i> حذف </button>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center p-5"> لا توجد بيانات </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

{{--                            @if($media->hasMorePages())--}}
                            @if($media->lastPage() > 1)
                                <hr class="pt-0 mt-0" />
                            @endif

                            <div class="d-flex justify-content-around">{{ $media->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark" id = "total_count">{{ $media->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @can('media.delete')
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title" id="deleteModalLabel">حذف الصورة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form id="deleteMediaForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">

                        <p>سيتم حذف الصورة بشكل نهائي.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button id="roleFormBtn" type="submit" class="btn btn-danger">حذف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endcan
@endsection

@section('add-scripts')
    <script>
        function modalDelete(deleteRoute) {
            $('#deleteMediaForm').attr('action', deleteRoute);
        }

        function filter_data(){
        title_filter = $('#title-filter').val();
        body_filter = $('#body-filter').val();
        name_filter = $('#name-filter').val();
        email_filter = $('#email-filter').val();
        mobile_filter = $('#mobile-filter').val();
        city_filter = $('#city-filter').val();
        category_filter = $('#category-filter').val();
        date_filter = $('#date-filter').val();
        approved_filter = $('#approved-filter').val();
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
        if(city_filter){
            quary_string += `filters[city]=${city_filter}&`;
        }
        if(category_filter){
            quary_string += `filters[category]=${category_filter}&`;
        }
        if(date_filter){
            quary_string += `filters[date]=${date_filter}&`;
        }
        if(approved_filter){
            quary_string += `filters[approved]=${approved_filter}&`;
        }
        window.location = 'media?' + quary_string;
    }

        function ChangeCategory(value){
            $.ajax({
                url: 'get_media/' + value,
                contentType: "application/json",
                dataType: 'json',
                success: function(result){
                    // console.log(result);
                    $('#media_table tbody').empty();
                    $('#total_count').html(result.length)
                    if(result.length == 0){
                        $('#media_table tbody').append(`
                        <tr>
                            <td colspan="7" class="text-center"> لا توجد بيانات </td>
                        </tr>
                    `)
                    }
                    else{
                        result.forEach(function(row) {
                            $('#media_table tbody').append(`
                            <tr>
                                <td>
                                    <img src="${row.file}" alt="" style="height: 100px;width: 100px;">
                                </td>
                                <td>${row.category}</td>

                            </tr>
                        `)
                        })
                    }
                }
            })
        }
    </script>
@endsection
