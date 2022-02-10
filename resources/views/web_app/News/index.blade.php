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
                                        <select class="form-control" name="city" id="city-filter">
                                            <option disabled="">حدد المدينة</option>
                                            <option {{ isset($_GET['filters']['city']) && $_GET['filters']['city'] == '' ? 'selected=""' : '' }} value="">الكل</option>
                                            @foreach($cities as $city)
                                                <option {{ isset($_GET['filters']['city']) && $city->id == $_GET['filters']['city'] ? 'selected=""' : '' }} value="{{ $city->id }}">{{ $city->name_ar }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-tooltip">
                                            حدد المدينة
                                        </div>
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
                        @if($news->count() > 0)
                            @foreach($news as $row)
                                <div class="col-sm-4">
                                <a href="{{ route('news.show', $row->id) }}">
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
                                                <p class="card-text m-0"><i class="ri-map-pin-2-fill"> </i><small class="text-muted">{{ $row->category->name_ar }}</small></p>
                                            
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
               

                            <div class="d-flex justify-content-around">{{ $news->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $news->count() }}</span>
                        </div>
                    </div>
                </div>

            <div class="col-md-2">
                
            </div>
      

            </div>
        </div>
    </div>
@endsection
@section('add-scripts')

<script>
    function submit_form(form){
        if(confirm('Are you sure?')){
            $(form).parent().submit()
        }
    }

    function ChangeCategory(value){
        if(value == -1){
            window.location = "news";
        }
        else{
            window.location = "news?category_id=" + value;
        }
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
        window.location = 'news?' + quary_string;
    }
</script>
@endsection
