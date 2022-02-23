{{--<!-- TOP Nav Bar -->--}}
<div class="iq-top-navbar" style="max-height: 75px;">
    <div class="iq-navbar-custom">
        <div class="iq-sidebar-logo">
            <div class="top-logo">
                <a href="{{ route('home') }}" class="logo">
                    <img src="{{ Helper::GeneralSettings('app_logo') }}" class="img-fluid" alt="{{ Helper::GeneralSettings('app_title_ar') }}">
                    <span>{{ Helper::GeneralSettings('app_title_ar') }}</span>
                </a>
            </div>
        </div>

        @yield('breadcrumb')

        <nav class="navbar navbar-expand-lg navbar-light p-0">

            <button class="navbar-toggler mr-1" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <i class="ri-menu-2-line"></i>
            </button>

            <div id="sidebarMainMenu" class="iq-menu-bt align-self-center">
                <div class="wrapper-menu">
                    <div class="line-menu half start"></div>
                    <div class="line-menu"></div>
                    <div class="line-menu half end"></div>
                </div>
            </div>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto navbar-list">

                    @can('dashboard.read|dashboard.update')
                        @if(isset(request()->segments()[0]) && request()->segments()[0] == env('APP_ADMIN_URI', 'admin'))
                            <li class="nav-item">
                                <a class="btn iq-waves-effect" href="{{ route('home') }}"> التطبيق <i class="ri-global-fill"></i></a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn iq-waves-effect" href="{{ route('admin.dashboard') }}"> لوحة التحكم <i class="ri-dashboard-fill"></i></a>
                            </li>
                        @endif
                    @endcan

                    <li class="nav-item">
                        <a class="search-toggle iq-waves-effect" href="#">
                            <i class="ri-search-line"></i>
                        </a>
                        <form method="POST" action="{{ route('search') }}" class="search-box">
                            @csrf

                            <div class="inline-flex">
                            <input id="searchForm" type="text" name="search" class="text search-input" value="{{ old('search') }}" placeholder="اكتب هنا للبحث..." />
                            </div>
                        </form>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="search-toggle iq-waves-effect">
                            <i class="ri-notification-2-line"></i>
                            @if(count(auth()->user()->unreadNotifications) > 0)
                                <span class="bg-danger dots"></span>
                            @endif
                        </a>
                        <div class="iq-sub-dropdown">
                            <div class="iq-card shadow-none m-0">
                                <div class="iq-card-body p-0 ">
                                    <div class="bg-danger p-3">
                                        <h5 class="mb-0 text-white">الاشعارات<small class="badge badge-light float-right pt-1">{{ count(auth()->user()->unreadNotifications) }}</small></h5>
                                    </div>

                                    @if(count(auth()->user()->unreadNotifications) > 0)
                                        @foreach(auth()->user()->unreadNotifications as $notification)
                                            <a onclick="markNotificationRead('{{ $notification->id }}', `{{ isset($notification->data['url']) ? $notification->data['url'] : '#' }}`)"  class="iq-sub-card" >
                                                <div class="media align-items-center">
                                                    <div class="media-body ml-3">
                                                        <h6 class="mb-0 ">{{ isset($notification->data['title']) ? $notification->data['title'] : 'Title' }}</h6>
                                                        <small class="float-right font-size-12">{{ $notification->created_at }}</small>
                                                        <p class="mb-0">{!! isset($notification->data['body']) ? $notification->data['body'] : 'Body' !!}</p>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                        <div class="media-pl m-3" onclick="markNotificationRead('-1', '')">
                                            <a href="#" class="text-danger"><i class="ri-delete-bin-5-line"> </i> مسح </a>
                                        </div>
                                    @else
                                        <div class="iq-sub-card media align-items-center">
                                            <div class="media-body ml-3 text-center">
                                                لا توجد اشعارات
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item iq-full-screen"><a href="#" class="iq-waves-effect" id="btnFullscreen"><i class="ri-fullscreen-line"></i></a></li>
                </ul>
            </div>
            <ul class="navbar-list">
                <li>
                    <a href="{{ route('profile') }}" class="search-toggle iq-waves-effect bg-primary text-white">
                        <img src="{{ isset(auth()->user()->profile) ? auth()->user()->profile->photo : secure_asset('assets/images/user/1.jpg') }}" class="img-fluid rounded" alt="{{ auth()->user()->name }}">
                    </a>
                    <div class="iq-sub-dropdown iq-user-dropdown" style="left: 0 !important;">
                        <div class="iq-card shadow-none m-0">
                            <div class="iq-card-body p-0 ">
                                <div class="bg-primary p-3">
                                    <h5 class="mb-0 text-white line-height">{{ isset(auth()->user()->profile) ? auth()->user()->profile->full_name : auth()->user()->name }}</h5>
                                </div>
                                <a href="{{ route('profile') }}" class="iq-sub-card iq-bg-primary-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-primary">
                                            <i class="ri-file-user-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">الملف الشخصي</h6>
                                            <p class="mb-0 font-size-12">عرض تفاصيل الملف الشخصي.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('profile.edit') }}" class="iq-sub-card iq-bg-primary-success-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-success">
                                            <i class="ri-profile-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">تعديل الملف الشخصي</h6>
                                            <p class="mb-0 font-size-12">تعديل بياناتك الشخصية.</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('profile').'?tab=family' }}" class="iq-sub-card iq-bg-primary-danger-hover">
                                    <div class="media align-items-center">
                                        <div class="rounded iq-card-icon iq-bg-danger">
                                            <i class="ri-account-box-line"></i>
                                        </div>
                                        <div class="media-body ml-3">
                                            <h6 class="mb-0 ">العائلة</h6>
                                            <p class="mb-0 font-size-12">اعداد و تفاصيل العائلة.</p>
                                        </div>
                                    </div>
                                </a>

                                <div class="d-inline-block w-100 text-center p-3">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="iq-bg-danger iq-sign-btn w-100" role="button"> تسجيل خروج <i class="ri-login-box-line ml-2"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>
{{--<!-- TOP Nav Bar END -->--}}

<script>
    function markNotificationRead(id, url){
        $.ajax({
            url: 'read-notification?id=' + id,
            contentType: "application/json",
            success: function(result){
                if(result == "1"){
                    window.location = url;
                }
                else{
                    window.location = "";
                }
            }
        })
    }
</script>
