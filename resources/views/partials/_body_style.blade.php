<head>
    <meta charset="utf-8">
    <meta name="description" content="{{ Helper::GeneralSettings('app_description_ar') }}">
    <meta name="author" content="عالم الفلك لتقنية المعلومات">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ Helper::GeneralSettings('app_title_ar') }} | @yield('page-title')</title>
    <link rel="shortcut icon" href="{{ Helper::GeneralSettings('app_icon') }}"/>
    @if(app()->getLocale() == 'ar')
    <link rel="stylesheet" href="{{ secure_asset('assets/css/bootstrap-rtl.min.css') }}"/>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/style-rtl.css') }}"/>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/responsive-rtl.css') }}"/>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/typography-rtl.css') }}"/>
    @else
    <link rel="stylesheet" href="{{ secure_asset('assets/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/responsive.css') }}"/>
    <link rel="stylesheet" href="{{ secure_asset('assets/css/typography.css') }}"/>
    @endif
    <link rel="stylesheet" href="{{ secure_asset('assets/css/custom.css') }}"/>

    @yield('add-styles')

    @laravelPWA
{{--    <link rel="manifest" href="{{ secure_asset('manifest.json') }}">--}}
</head>
