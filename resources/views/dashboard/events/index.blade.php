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
                        </div>
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group my-auto">
                                        <input type="text" class="form-control" name="title" id="title-filter" value="{{ isset($_GET['filters']['title']) ? $_GET['filters']['title'] : '' }}" placeholder="بحث  بالعنوان">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group my-auto">
                                        <input type="text" class="form-control" name="body" id="body-filter" value="{{ isset($_GET['filters']['body']) ? $_GET['filters']['body'] : '' }}" placeholder="بحث بالوصف ">
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

                                <div class="col-md-1 my-auto">
                                    <button type="submit" onclick="filter_data()" class="btn btn-primary rounded-pill py-2 w-100">فلتر البيانات</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table m-0 px-2">

                                    <thead>
                                    <tr>
                                        <th scope="col">عنوان</th>
                                        <th scope="col">وصف</th>
                                        <th scope="col">المدينة</th>
                                        <th scope="col">الناشر</th>
                                        <th scope="col">الصورة</th>
                                        <th scope="col">التاريخ</th>
                                        <th scope="col">الإجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($events->count() > 0)
                                        @foreach($events as $event)
                                            <tr>
                                                <td>{{ $event->title }}</td>
                                                <td>{!! $event->short_body !!}</td>
                                                <td>{{ $event->city->name_ar }}</td>
                                                <td><a href="{{ route('admin.users.show', $event->owner_id) }}">{{ $event->owner->name }}</a></td>
                                                <td>
                                                    <img src="{{ isset($event->image->file) ? $event->image->file : 'default.png' }}" alt="{{ $event->title }}" style="height: 100px;width: 100px;">
                                                </td>
                                                <td dir="ltr">{{ date('Y-m-d | H:i', strtotime($event->event_date)) }}</td>
                                                <td>
                                                    <div class="d-flex justify-center">
                                                            @can('events.update')
                                                            <a class="btn btn-outline-warning rounded-pill m-1 px-3" href="{{ route('admin.events.edit', $event) }}"><i class="ri-edit-2-fill"></i></a>
                                                            @endcan
                                                            @can('events.delete')
                                                            <form action="{{ route('admin.events.destroy', $event) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" class="btn btn-outline-danger rounded-pill m-1 px-3"><i class="ri-delete-back-2-fill"></i></button>
                                                            </form>
                                                            @endcan
                                                            @if(!$event->approved)
                                                            <form method="POST" action="{{ route('admin.events.activate') }}">
                                                                @csrf
                                                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                                                <button type="submit" class="btn btn-outline-success rounded-pill m-1 px-3"><i class="ri-arrow-up-circle-line"></i></button>
                                                            </form>
                                                            @endif
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

                            @if($events->lastPage() > 1)
                                <hr class="pt-0 mt-0" />
                            @endif

                            <div class="d-flex justify-content-around">{{ $events->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $events->count() }}</span>
                        </div>
                    </div>
                </div>

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
        city_filter = $('#city-filter').val();
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
        if(city_filter){
            quary_string += `filters[city]=${city_filter}&`;
        }
        window.location = 'events?' + quary_string;
    }
</script>
@endsection
