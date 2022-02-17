<div class="navbar-breadcrumb">
    <h5 class="mb-0">{!! $pageTitle !!}</h5>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">

            @if(isset(request()->segments()[0]) && request()->segments()[0] == env('APP_ADMIN_URI', 'admin'))
                <li class="breadcrumb-item m-1">
                    <a class="" href="{{ route('admin.dashboard') }}">
                        <i class="ri-dashboard-fill"> </i>&nbsp; لوحة التحكم
                    </a>
                </li>
            @else
                <li class="breadcrumb-item m-1">
                    <a class="" href="{{ route('home') }}">
                        <i class="ri-home-line"> </i>&nbsp; الرئيسية
                    </a>
                </li>
            @endif

            @if (isset($slots) && !is_null($slots))
                @foreach($slots as $keySlot => $slot)
                    <i class="ri-arrow-left-s-line m-1"></i>
                @if(count($slots) -1 == $keySlot)
                    <li class="breadcrumb-item m-1 active" aria-current="page"> {{ $slot['title'] }}</li>
                @else
                    <li class="breadcrumb-item m-1"><a href="{{ $slot['link'] }}"> {{ $slot['title'] }}</a></li>
                @endif
                @endforeach
            @endif

        </ul>
    </nav>
</div>
