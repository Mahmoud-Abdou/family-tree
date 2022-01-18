{{--<!-- Sidebar  -->--}}
<div class="iq-sidebar">
    <div class="iq-sidebar-logo d-flex justify-content-between">
        <a href="{{ route('home') }}">
            <img src="{{ Helper::GeneralSettings('app_logo') }}" class="img-fluid" alt="{{ Helper::GeneralSettings('app_title_ar') }}">
            <h5 class="my-auto mx-3">{{ Helper::GeneralSettings('app_title_ar') }}</h5>
        </a>
        <div class="iq-menu-bt align-self-center">
            <div class="wrapper-menu">
                <div class="line-menu half start"></div>
                <div class="line-menu"></div>
                <div class="line-menu half end"></div>
            </div>
        </div>
    </div>

{{--    <hr class="mb-0">--}}
    <div id="sidebar-scrollbar">
{{--    <div id="sidebar-scrollbar" data-scrollbar="true" tabindex="-1" style="overflow: hidden; outline: none;">--}}
        <div class="scroll-content">
        <nav class="iq-sidebar-menu">
            <ul id="iq-sidebar-toggle" class="iq-menu">

                <li class="iq-menu-title bg-cobalt-blue">
                    <i class="ri-separator"></i>
                    <span>{{ $menuTitle }}</span>
                </li>

                @foreach($appMenu as $menu)
                    @can($menu['permission'])
                    @isset($menu['child'])
                        <li>
                            <a href="#{{ $menu['link'] }}" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="{{ $menu['icon'] }}"></i>
                                <span>{{ $menu['title_ar'] }}</span>
                                <i class="ri-arrow-right-s-line iq-arrow-right"></i>
                            </a>
                            <ul id="{{ $menu['link'] }}" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
                                @foreach($menu['child'] as $menuChild)
                                    <li class="{{ $menuChild['link'] == Route::currentRouteName() ? 'active' : '' }}">
                                        <a href="{{ route($menuChild['link']) }}" class="iq-waves-effect">
                                            <i class="{{ $menuChild['icon'] }}"></i>
                                            <span>{{ $menuChild['title_ar'] }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="{{ $menu['link'] == Route::currentRouteName() ? 'active' : '' }}">
                            <a href="{{ route($menu['link']) }}" class="iq-waves-effect">
                                <i class="{{ $menu['icon'] }}"></i>
                                <span>{{ $menu['title_ar'] }}</span>
                            </a>
                        </li>
                    @endisset
                    @endcan
                @endforeach

            </ul>
        </nav>
        <div class="p-3"></div>
    </div>
    </div>
</div>
