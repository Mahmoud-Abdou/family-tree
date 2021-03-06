@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-dashboard-line"> </i>'.$menuTitle, 'slots' => []])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-success"><i class="ri-group-line"></i></div>
                            <span class="float-right line-height-6">إجمالي المستخدمين</span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span class="counter">{{ $usersData['allUsersCount'] }}</span></h2>
{{--                                <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">30%</span> Increased</p>--}}
                            </div>
                        </div>
                        <div id="chart-3"></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-primary"><i class="ri-user-follow-line"></i></div>
                            <span class="float-right line-height-6">المستخدمين النشطين</span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span class="counter">{{ $usersData['activeUsers'] }}</span></h2>
{{--                                <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">10%</span> Increased</p>--}}
                            </div>
                        </div>
                        <div id="chart-1"></div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-warning"><i class="ri-user-add-line"></i></div>
                            <span class="float-right line-height-6">المستخدمون المسجلين</span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span class="counter">{{ $usersData['registeredUsers'] }}</span></h2>
{{--                                <p class="mb-0 text-secondary line-height"><i class="ri-arrow-up-line text-success mr-1"></i><span class="text-success">20%</span> Increased</p>--}}
                            </div>
                        </div>
                        <div id="chart-2"></div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height overflow-hidden">
                        <div class="iq-card-body pb-0">
                            <div class="rounded-circle iq-card-icon iq-bg-danger"><i class="ri-user-unfollow-line"></i></div>
                            <span class="float-right line-height-6">المحظورين</span>
                            <div class="clearfix"></div>
                            <div class="text-center">
                                <h2 class="mb-0"><span class="counter">{{ $usersData['blockedCount'] }}</span></h2>
{{--                                <p class="mb-0 text-secondary line-height"><i class="ri-arrow-down-line text-danger mr-1"></i><span class="text-danger">10%</span> Increased</p>--}}
                            </div>
                        </div>
                        <div id="chart-4"></div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-md-6">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height wow zoomIn" style="visibility: visible; animation-name: zoomIn;">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-2 d-flex justify-content-between">
                                    <div class="icon iq-icon-box rounded-circle iq-bg-secondary rounded-circle">
                                        <i class="ri-account-box-line"></i>
                                    </div>
                                    <div class="my-auto mx-auto text-center">
                                        <h6 class="card-title text-uppercase text-secondary text-center mb-0">الذكور</h6>
                                        <span class="h2 text-dark mb-0 counter">{{ $usersData['mealsCount'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-md-6">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height wow zoomIn" style="visibility: visible; animation-name: zoomIn;">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-2 d-flex justify-content-between">
                                    <div class="icon iq-icon-box rounded-circle iq-bg-pink rounded-circle">
                                        <i class="ri-user-5-line"></i>
                                    </div>
                                    <div class="my-auto mx-auto text-center">
                                        <h6 class="card-title text-uppercase text-secondary text-center mb-0">الإناث</h6>
                                        <span class="h2 text-dark mb-0 counter">{{ $usersData['femalesCount'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-md-6">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height wow zoomIn" style="visibility: visible; animation-name: zoomIn;">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-2 d-flex justify-content-between">
                                    <div class="icon iq-icon-box rounded-circle iq-bg-info rounded-circle">
                                        <i class="ri-parent-line"></i>
                                    </div>
                                    <div class="my-auto mx-auto text-center">
                                        <h6 class="card-title text-uppercase text-secondary text-center mb-0">المتزوجين</h6>
                                        <span class="h2 text-dark mb-0 counter">{{ $usersData['marriagesCount'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4 col-md-6">
                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height wow zoomIn" style="visibility: visible; animation-name: zoomIn;">
                        <div class="iq-card-body">
                            <div class="row">
                                <div class="col-lg-12 mb-2 d-flex justify-content-between">
                                    <div class="icon iq-icon-box rounded-circle iq-bg-warning rounded-circle">
                                        <i class="ri-user-4-line"></i>
                                    </div>
                                    <div class="m-auto mx-auto text-center">
                                        <h6 class="card-title text-uppercase text-secondary text-center mb-0">المتوفين</h6>
                                        <span class="h2 text-dark mb-0 counter">{{ $usersData['deathsCount'] }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

{{--                last users--}}
                @can('users.read|users.activate')
                    <div class="col-lg-12">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title"><i class="ri-user-fill"> </i>آخر المستخدمين المسجلين</h4>
                                </div>
                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                     <a href="{{ route('admin.users.index') }}" class="dropdown-toggle text-dark"><i class="ri-more-2-fill"></i></a>
                                </div>
                            </div>
                            <div class="iq-card-body p-0">
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
                                        @if($usersData['lastUsers']->count() > 0)
                                            @foreach($usersData['lastUsers'] as $user)
                                                <tr>
                                                    <td><a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a></td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>{{ $user->mobile }}</td>
                                                    <td>@isset($user->city) {{ $user->city->name_ar }} @else - @endisset</td>
                                                    <td>
                                                        {!! $user->statusHtml() !!}
                                                    </td>
                                                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                                    <td>
                                                        <form method="POST" action="{{ route('admin.users.activate') }}">
                                                            @csrf
                                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                            <button type="submit" class="btn btn-outline-success rounded-pill w-100 px-auto"><i class="ri-arrow-up-circle-line"> </i>تفعيل</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center"><p class="p-5"> لا توجد بيانات </p></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

{{--                last news--}}
                @can('news.read|news.update|news.delete')
                    <div class="col-lg-12">
                        <div class="iq-card">
                            <div class="iq-card-header d-flex justify-content-between">
                                <div class="iq-header-title">
                                    <h4 class="card-title"><i class="ri-newspaper-fill"> </i>آخر الأخبار</h4>
                                </div>
                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                    <a href="{{ route('admin.news.index') }}" class="dropdown-toggle text-dark"><i class="ri-more-2-fill"></i></a>
                                </div>
                            </div>
                            <div class="iq-card-body p-0">
                                <div class="table-responsive">
                                    <table class="table m-0">
                                        <thead>
                                        <tr>
                                            <th scope="col">العنوان</th>
                                            <th scope="col">المحتوى</th>
                                            <th scope="col">التصنيف</th>
                                            <th scope="col">الحالة</th>
                                            <th scope="col">المستخدم</th>
                                            <th scope="col">الإجراءات</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if($newsData['lastNews']->count() > 0)
                                            @foreach($newsData['lastNews'] as $news)
                                                <tr>
                                                    <td><a href="{{ route('news.show', $news->id) }}">{{ $news->title }}</a></td>
                                                    <td>{{ $news->short_body }}</td>
                                                    <td>{{ $news->category->name }}</td>
                                                    <td>
                                                        {!! $news->statusHtml() !!}
                                                    </td>
                                                    <td><a href="{{ route('admin.users.show', $news->owner->id) }}">{{ $news->owner->name }}</a></td>
                                                    <td>
                                                        @if($news->approved == 0)
                                                            <form method="POST" action="{{ route('admin.news.activate') }}">
                                                                @csrf
                                                                <input type="hidden" name="news_id" value="{{ $news->id }}">
                                                                <button type="submit" class="btn btn-outline-success rounded-pill w-100 px-auto"><i class="ri-arrow-up-circle-line"> </i>تفعيل</button>
                                                            </form>
                                                        @else
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                                                            </div>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center"><p class="p-5"> لا توجد بيانات </p></td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan

            </div>
        </div>
    </div>
@endsection
