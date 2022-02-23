@include('partials._body_style')

<section class="sign-in-page bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters bg-white">
            <div class="col-sm-6 text-center d-none d-md-block" style="height: 100vh;">
                @include('partials._app_auth_info')
            </div>

            <div class="col-sm-6 align-self-center register-scroll">
                <div class="text-center d-block d-md-none">
                    <a class="sign-in-logo mb-5" href="#">
                        <img src="{{ Helper::GeneralSettings('app_logo') }}" class="img-fluid" alt="{{ Helper::GeneralSettings('app_title_ar') }}">
                    </a>
                    <h4 class="mb-1 text-dark">{{ Helper::GeneralSettings('app_title_ar') }}</h4>
                </div>

                <div class="sign-in-from">
                    <h1 class="mb-0">@lang('auth.sign_up')</h1>
                    <p>@lang('auth.sign_up_message')</p>

                    <x-auth-validation-errors dir="rtl" class="alert alert-danger mb-4" role="alert" :errors="$errors" />

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
                            <label for="gender">{{ __('النوع') }}</label>
                            <select id="gender" name="gender" tabindex="3" class="form-control mb-0" value="{{ old('gender') }}" required autofocus>
                                <option value="male">{{ __('ذكر') }}</option>
                                <option value="female">{{ __('أنثى') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mobileNumber">{{ __('رقم الجوال') }}</label>
                            <input type="number" name="mobile" class="form-control numeric mb-0" id="mobileNumber" tabindex="4" placeholder="أدخل رقم الجوال"  required>
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
                            <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1 float-right my-2">
                                <input type="checkbox" name="terms" class="custom-control-input" id="terms" required {{ old('terms') == 'on' ? 'checked' : '' }} >
                                <label class="custom-control-label" for="terms"> عند الاشتراك فانت توافق على </label>
                                <a href="#" class="mx-1" data-toggle="modal" data-target="#termsModal">شروط الاستخدام </a>
                            </div>
                            <button type="submit" class="btn btn-primary float-left py-3 px-5" tabindex="9">اشتراك</button>
                        </div>
                        <div class="sign-info">
                            <span class="dark-color d-inline-block line-height-2">لديك حساب بالفعل؟
                                <a href="{{ route('login') }}" class="mx-3 py-3 px-5 btn btn-outline-primary">دخول</a>
                            </span>
                        </div>
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials._body_footer')

<div dir="rtl" class="modal fade bd-example-modal-xl fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalTitle" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="termsModalTitle">الشروط و حقوق الاستخدام</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 pb-2 text-center border-bottom">
                        <a href="{{ route('home') }}">
                            <img src="{{ Helper::GeneralSettings('app_logo') }}" class="img-fluid" width="120" alt="{{ Helper::GeneralSettings('app_title_ar') }}">
                            <h5 class="my-auto mx-3">{{ Helper::GeneralSettings('app_title_ar') }}</h5>
                        </a>
                    </div>

                    <div class="col-lg-12 p-5">
                        {!! Helper::GeneralSettings('app_terms_ar') !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
