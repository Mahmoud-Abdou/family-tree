@include('partials._body_style')
<section class="sign-in-page bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters bg-white">
            <div class="col-sm-6 text-center d-none d-md-block" style="height: 100vh;">
                @include('partials._app_auth_info')
            </div>

            <div class="col-sm-6 align-self-center">
                <div class="sign-in-from">
                    <h1 class="mb-0">إعادة تعيين كلمة المرور</h1>
                    <p>أدخل عنوان بريدك الإلكتروني وسنرسل إليك بريدًا إلكترونيًا يحتوي على تعليمات لإعادة تعيين كلمة المرور الخاصة بك.</p>

{{--                    <!-- Session Status -->--}}
                    <x-auth-session-status class="mb-4" :status="session('status')" />

{{--                    <!-- Validation Errors -->--}}
                    <x-auth-validation-errors dir="rtl" class="alert alert-danger mb-4" role="alert" :errors="$errors" />

                    <form class="mt-4" method="POST" action="{{ route('password.email') }}">
                        @csrf

{{--                        <!-- Email Address -->--}}
                        <div class="form-group">
                            <label for="email">{{ __('البريد الإلكتروني') }}</label>
                            <input type="email" name="email" class="form-control mb-0" id="email" placeholder="أدخل البريد الإلكتروني" value="{{ old('email') }}" required autofocus >
                        </div>

                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-left py-2 px-4">{{ __('ارسال') }}</button>
                            <a href="{{ route('login') }}" class="float-right my-auto py-2 btn btn-outline-primary">عودة لتسجيل الدخول </a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('partials._body_footer')
