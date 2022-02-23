@include('partials._body_style')

<section class="sign-in-page bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters bg-white">
            <div class="col-sm-6 text-center d-none d-md-block">
                @include('partials._app_auth_info')
            </div>

            <div class="col-sm-6 align-self-center">
                <div class="text-center d-block d-md-none">
                    <a class="sign-in-logo mt-5" href="#">
                        <img src="{{ Helper::GeneralSettings('app_logo') }}" class="img-fluid" alt="{{ Helper::GeneralSettings('app_title_ar') }}">
                        <h4 class="mb-1 text-dark">{{ Helper::GeneralSettings('app_title_ar') }}</h4>
                    </a>
                </div>

                <div class="sign-in-from">
                    <h1 class="mb-0">@lang('auth.sign_in')</h1>
                    <p>@lang('auth.sign_in_message')</p>

                    <x-auth-validation-errors dir="rtl" class="alert alert-danger mb-4" role="alert" :errors="$errors" />

                    <form dir="rtl" class="mt-4" method="POST" action="{{ route('first_login') }}">
                        @csrf
 
                        <div class="form-group">
                            <label for="email">@lang('auth.username')</label>
                            <input type="text" name="email" class="form-control mb-0" id="email" tabindex="1" placeholder="" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password">@lang('auth.passwordField')</label>
                            
                            <input type="password" name="password" class="form-control mb-0" id="password" tabindex="2" placeholder="******" required >
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{ __('تأكيد كلمة المرور') }}</label>
                            <input type="password" name="password_confirmation" class="form-control mb-0" id="password_confirmation" tabindex="7" placeholder="{{ __('تأكيد كلمة المرور') }}" required>
                        </div>
                        <div class="d-inline-block w-100">
                            
                            <button type="submit" class="btn btn-primary float-left py-2 px-4" tabindex="4">@lang('auth.enter')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials._body_footer')
