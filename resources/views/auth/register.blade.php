@include('partials._body_style')

<section class="sign-in-page bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters bg-white">
            <div class="col-sm-6 text-center d-none d-md-block" style="height: 100vh;">
                @include('partials._app_auth_info')
            </div>

            <div class="col-sm-6 align-self-center">
                <div class="text-center d-block d-md-none">
                    <a class="sign-in-logo mb-5" href="#">
                        <img src="{{ Helper::GeneralSettings('app_logo') }}" class="img-fluid" alt="{{ Helper::GeneralSettings('app_title_ar') }}">
                    </a>
                    <h4 class="mb-1 text-dark">{{ Helper::GeneralSettings('app_title_ar') }}</h4>
                </div>

                <div class="sign-in-from">
                    <h1 class="mb-0">@lang('auth.sign_up')</h1>
                    <p>@lang('auth.sign_up_message')</p>

                    @include('partials.messages')

                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form dir="rtl" class="mt-4" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('الاسم') }}</label>
                            <input type="text" name="name" class="form-control mb-0" id="name" tabindex="1" placeholder="{{ __('الاسم') }}" value="{{ old('name') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="father_name">{{ __('اسم الأب') }}</label>
                            <input type="text" name="father_name" class="form-control mb-0" id="father_name" tabindex="2" placeholder="{{ __('اسم الأب') }}" value="{{ old('father_name') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="gender">{{ __('نوع الجنس') }}</label>
                            <select id="gender" name="gender" tabindex="3" class="form-control mb-0" value="{{ old('gender') }}" required autofocus>
                                <option value="male">{{ __('ذكر') }}</option>
                                <option value="female">{{ __('أنثى') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mobile">{{ __('رقم الجوال') }}</label>
                            <input type="text" name="mobile" class="form-control mb-0" id="mobile" tabindex="4" placeholder="أدخل رقم الجوال" value="{{ old('mobile') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('البريد الإلكتروني') }}</label>
                            <input type="email" name="email" class="form-control mb-0" id="email" tabindex="5" placeholder="أدخل البريد الإلكتروني" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('كلمة المرور') }}</label>
                            <input type="password" name="password" class="form-control mb-0" id="password" tabindex="6" placeholder="{{ __('كلمة المرور') }}" required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{ __('تأكيد كلمة المرور') }}</label>
                            <input type="password" name="password_confirmation" class="form-control mb-0" id="password_confirmation" tabindex="7" placeholder="{{ __('تأكيد كلمة المرور') }}" required>
                        </div>
                        <div class="d-inline-block w-100">
                            <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1 float-right">
                                <input type="checkbox" name="terms" class="custom-control-input" id="terms" required {{ old('terms') == 'on' ? 'checked' : '' }} >
                                <label class="custom-control-label" for="terms"> عند الاشتراك فانت توافق على <a href="{{ route('terms') }}">شروط الاستخدام</a></label>
                            </div>
                            <button type="submit" class="btn btn-primary float-left py-2 px-4" tabindex="9">اشتراك</button>
                        </div>
                        <div class="sign-info">
                            <span class="dark-color d-inline-block line-height-2">لديك حساب بالفعل؟ <a href="{{ route('login') }}">دخول</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials._body_footer')
