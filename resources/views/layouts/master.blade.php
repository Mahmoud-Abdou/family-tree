<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ str_replace('_', '-', app()->getLocale()) == 'ar' ? 'rtl' : 'ltr' }}">
    @include('partials._body_style')
    <body>
        @include('partials._app_loader')
        @include('partials._app_body')
    </body>
</html>
