@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-4-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('home')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3 shadow-sm">
                        <div class="card-header" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                            <h5 class="float-left my-auto"><i class="ri-user-4-line"> </i> {{ $menuTitle }}</h5>
                            <span class="ml-5"><i class="ri-filter-2-line"> </i>البحث في النتائج</span>
                            @can('deaths.create')
                                <a href="{{ route('deaths.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                            @endcan
                        </div>
                        <div class="collapse" id="collapseFilters">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group my-auto">
                                            <label for="title-filter">بحث بالعنوان</label>
                                            <input type="text" class="form-control" name="title" id="title-filter" value="{{ isset($_GET['filters']['title']) ? $_GET['filters']['title'] : '' }}" placeholder="بحث  بالعنوان">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group my-auto">
                                            <label for="body-filter">بحث بالوصف</label>
                                            <input type="text" class="form-control" name="body" id="body-filter" value="{{ isset($_GET['filters']['body']) ? $_GET['filters']['body'] : '' }}" placeholder="بحث بالوصف">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group my-auto">
                                            <label for="body-filter">بحث بالاسم</label>
                                            <input type="text" class="form-control" name="name" id="name-filter" value="{{ isset($_GET['filters']['owner_name']) ? $_GET['filters']['owner_name'] : '' }}" placeholder="بحث بالاسم ">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group my-auto">
                                            <label for="body-filter">بحث بالبريد الالكتروني</label>
                                            <input type="email" class="form-control" name="email" id="email-filter" value="{{ isset($_GET['filters']['owner_email']) ? $_GET['filters']['owner_email'] : '' }}" placeholder="بحث بالبريد الالكتروني">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group my-auto">
                                            <label for="body-filter">بحث برقم الجوال</label>
                                            <input type="text" class="form-control" name="mobile" id="mobile-filter" value="{{ isset($_GET['filters']['owner_phone']) ? $_GET['filters']['owner_phone'] : '' }}" placeholder="بحث برقم الجوال">
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
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

                                    <div class="col-lg-3 my-auto">
                                        <button type="submit" onclick="filter_data()" class="btn btn-primary rounded-pill py-2 w-100">فلتر البيانات</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($deaths->count() > 0)
                    @foreach($deaths as $row)
                        <div class="col-sm-4">
                            <a href="{{ route('deaths.show', $row->id) }}">
                                <div class="card iq-mb-3 shadow iq-bg-primary-hover">
                                    <img src="{{ isset($row->image->file) ? $row->image->file : 'default.png' }}" class="card-img-top img-fluid w-auto" alt="{{ $row->title }}">
                                    <div class="card-body">
                                        <h4 class="card-title">{{ $row->title }}</h4>
                                        <hr />
                                        <p class="card-text">{!! $row->short_body !!}</p>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-between" dir="ltr">
                                            <p class="card-text m-0"><i class="ri-timer-2-fill"> </i><small class="text-muted">{{ date('Y-m-d | H:i', strtotime($row->date)) }}</small></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-12">
                        <div class="card iq-mb-3 shadow p-5">
                            <div class="card-body text-center">
                                لا توجد بيانات
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-sm-12 my-4 d-flex justify-content-around">{{ $deaths->links() }}</div>

            </div>
        </div>
    </div>
@endsection

@section('add-scripts')
<script>
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
