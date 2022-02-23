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
                    <x-auth-validation-errors dir="rtl" class="alert alert-danger mb-4" role="alert" :errors="$errors" />

                    <form class="mt-4" method="POST" action="{{ route('password.update') }}">
                        @csrf

{{--                        <!-- Password Reset Token -->--}}
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

{{--                        <!-- Email Address -->--}}
                        <div class="form-group">
                            <label for="email">{{ __('البريد الإلكتروني') }}</label>
                            <input type="email" name="email" class="form-control mb-0" id="email" placeholder="أدخل البريد الإلكتروني" value="{{old('email', $request->email)}}" required autofocus >
                        </div>

{{--                        <!-- Password -->--}}
                        <div class="form-group">
                            <label for="password">{{ __('كلمة المرور') }}</label>
                            <input type="password" name="password" class="form-control mb-0" id="password" required >
                        </div>

{{--                        <!-- Confirm Password -->--}}
                        <div class="form-group">
                            <label for="password_confirmation">{{ __('تأكيد كلمة المرور') }}</label>
                            <input type="password" name="password_confirmation" class="form-control mb-0" id="password_confirmation" required >
                        </div>

                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-left py-2 px-4">{{ __('إعادة تعيين كلمة المرور') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('partials._body_footer')
