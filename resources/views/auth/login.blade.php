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

                    @include('partials.messages')
                    <x-auth-validation-errors dir="rtl" class="alert alert-danger mb-4" role="alert" :errors="$errors" />

                    <form dir="rtl" class="mt-4" method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email">@lang('auth.username')</label>
                            <input type="text" name="email" class="form-control mb-0" id="email" tabindex="1" placeholder="" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password">@lang('auth.passwordField')</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="float-right">@lang('auth.forgot_password')</a>
                            @endif
                            <input type="password" name="password" class="form-control mb-0" id="password" tabindex="2" placeholder="******" required autocomplete="current-password">
                        </div>
                        <div class="d-inline-block w-100">
                            <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1 float-right">
                                <input type="checkbox" name="remember" id="remember_me" tabindex="3" class="custom-control-input">
                                <label class="custom-control-label" for="remember_me">@lang('auth.remember_me')</label>
                            </div>
                            <button type="submit" class="btn btn-primary float-left py-3 px-5" tabindex="4">@lang('auth.enter')</button>
                        </div>
                        <div class="sign-info">
                            <span class="dark-color d-inline-block line-height-2 my-auto w-100">
                                <span>@lang('auth.no_have_account')</span>
                                <a href="{{ route('register') }}" class="mx-3 py-3 px-5 btn btn-outline-primary">@lang('auth.sign_up')</a>
                                <br>

                                @if(Helper::GeneralSettings('app_first_registration'))
                                    <a href="{{ route('first_login') }}" class="mt-3 py-3 px-5 btn btn-outline-secondary w-100">الدخول بالبريد المسجل مسبقاً</a>
                                @endif
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials._body_footer')
