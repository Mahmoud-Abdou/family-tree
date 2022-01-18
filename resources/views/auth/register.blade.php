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
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" name="name" class="form-control mb-0" id="name" tabindex="1" placeholder="{{ __('Your Name') }}" value="{{ old('name') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="father_name">{{ __('Father Name') }}</label>
                            <input type="text" name="father_name" class="form-control mb-0" id="father_name" tabindex="2" placeholder="{{ __('Father Name') }}" value="{{ old('father_name') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="gender">{{ __('Gender') }}</label>
                            <select id="gender" name="gender" tabindex="3" class="form-control mb-0" value="{{ old('gender') }}" required autofocus>
                                <option value="male">{{ __('Male') }}</option>
                                <option value="female">{{ __('Female') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mobile">{{ __('Mobile') }}</label>
                            <input type="text" name="mobile" class="form-control mb-0" id="mobile" tabindex="4" placeholder="Enter Mobile Number" value="{{ old('mobile') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control mb-0" id="email" tabindex="5" placeholder="Enter Email" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input type="password" name="password" class="form-control mb-0" id="password" tabindex="6" placeholder="{{ __('Password') }}" required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control mb-0" id="password_confirmation" tabindex="7" placeholder="{{ __('Confirm Password') }}" required>
                        </div>
                        <div class="d-inline-block w-100">
                            <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1 float-right">
                                <input type="checkbox" name="terms" class="custom-control-input" id="terms" required {{ old('terms') == 'on' ? 'checked' : '' }} >
                                <label class="custom-control-label" for="terms">I accept <a href="{{ route('terms') }}">Terms and Conditions</a></label>
                            </div>
                            <button type="submit" class="btn btn-primary float-left py-2 px-4" tabindex="9">Sign Up</button>
                        </div>
                        <div class="sign-info">
                            <span class="dark-color d-inline-block line-height-2">Already Have Account ? <a href="{{ route('login') }}">Log In</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@include('partials._body_footer')
