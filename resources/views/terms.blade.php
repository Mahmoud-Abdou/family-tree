<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ str_replace('_', '-', app()->getLocale()) == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="description" content="{{ Helper::GeneralSettings('app_description_ar') }}">
    <meta name="author" content="عالم الفلك لتقنية المعلومات">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ Helper::GeneralSettings('app_title_ar') }} | @yield('page-title')</title>
    <link rel="shortcut icon" href="{{ Helper::GeneralSettings('app_icon') }}"/>

    <link rel="stylesheet" href="{{ secure_asset('assets/css/bootstrap-rtl.min.css') }}"/>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/style-rtl.css') }}"/>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/responsive-rtl.css') }}"/>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/typography-rtl.css') }}"/>

</head>
<body>
    <div class="wrapper">
        <div class="row">
            <div class="col-lg-12 m-5 text-center">
                <a href="{{ route('home') }}">
                    <img src="{{ Helper::GeneralSettings('app_logo') }}" class="img-fluid" width="120" alt="{{ Helper::GeneralSettings('app_title_ar') }}">
                    <h5 class="my-auto mx-3">{{ Helper::GeneralSettings('app_title_ar') }}</h5>
                </a>
            </div>
        </div>
        <div class="mx-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card iq-mb-3">
                        <div class="card-header">
                            {{ $menuTitle }}
                        </div>
                        <div class="card-body">
                            {!! $content !!}
                        </div>
                        <div class="card-footer text-muted">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
