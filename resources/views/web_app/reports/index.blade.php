@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-smile-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('home')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-user-smile-line"> </i> {{ $menuTitle }}</h5>
                            @can('deaths.create')
                                <a href="{{ route('deaths.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                            @endcan

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




                                <div class="form-group col-lg-4">
                                        <br>
                                        <br>
                                        <div class="d-inline-flex">
                                            <div class="custom-control mx-4 custom-switch">
                                                <input type="checkbox" id="relatives-filter" name="relatives-filter" class="custom-control-input" {{ isset($_GET['filters']['relatives']) && $_GET['filters']['relatives'] == true ? 'checked=""' : '' }}>
                                                <label class="custom-control-label" for="relatives-filter"> بحث بالاقارب </label>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-2 my-auto">
                                    <button type="submit" onclick="filter_data()" class="btn btn-primary rounded-pill py-2 w-100">بحث</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">
                        @if($deaths->count() > 0)

                            @foreach($deaths as $row)
                            <div class="col-sm-4">
                                <a href="{{ route('deaths.show', $row->id) }}">
                                    <div class="card iq-mb-3 shadow iq-bg-primary-hover">
                                        <img src="{{ isset($row->image->file) ? $row->image->file : url('default.png') }}" class="card-img-top img-fluid w-auto" alt="{{ $row->title }}">
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $row->title }}</h4>
                                            <hr />
                                            <p class="card-text">{!! $row->short_body !!}</p>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between" dir="ltr">
                                                <p class="card-text m-0"><i class="ri-timer-2-fill"> </i><small class="text-muted">{{ date('Y-m-d', strtotime($row->date)) }}</small></p>
                                                @if($row->owner_id == auth()->id())
                                                    @can('deaths.update')

                                                        <a href="{{ route('deaths.edit', $row) }}" class="card-text m-0"><i class="ri-edit-2-fill"> </i><small class="text-muted"></small></a>
                                                    @endcan
                                                    @can('deaths.delete')
                                                    <form action="{{ route('deaths.destroy', $row) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <a onclick= "submit_form(this)" class="card-text m-0"><i class="ri-delete-back-2-fill"></i></a>
                                                    </form>
                                                    @endcan
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            @endforeach
                        @else
                        <div class="col-sm-8">
                                    <div class="card iq-mb-3">
                                        <div class="card-body">


                                            <p class="card-text">لا توجد بيانات</p>
                                        </div>

                                    </div>
                                </div>
                        @endif


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
@endsection

<script>
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
        window.location = 'deaths?' + quary_string;
    }
</script>
