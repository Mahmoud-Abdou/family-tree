{{--<!-- Footer -->--}}
<footer class="bg-white iq-footer mx-0">
    <div class="container-fluid mx-auto">
        <div class="row">
            <div class="col-lg-3 text-center">
                <ul class="list-inline mb-0">
{{--                    <li class="list-inline-item"><a href="{{ route('terms') }}">Privacy Policy</a></li>--}}
                    <li class="list-inline-item"><a href="{{ route('terms') }}">شروط الاستخدام</a></li>
                </ul>
            </div>
            <div class="col-lg-3">
            </div>
            <div class="col-lg-6 text-center">
                حقوق النشر 2021 - {{ date('Y') }} @<a href="https://www.alflk.sa/ar"> عالم الفلك لتقنية المعلومات </a> جميع الحقوق محفوظة.
            </div>
        </div>
    </div>
</footer>
{{--<!-- Footer END -->--}}
{{--<!-- Optional JavaScript -->--}}
@include('partials._body_scripts')
@yield('body_bottom')
@yield('add-scripts')
