@include('partials._body_style')
<section class="sign-in-page bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters bg-white">
            <div class="col-sm-6 text-center d-none d-md-block" style="height: 100vh;">
                @include('partials._app_auth_info')
            </div>

            <div class="col-sm-6 align-self-center">
                <div class="sign-in-from">
                    <h1 class="mb-0">Reset Password</h1>
                    <p>Enter your email address and we'll send you an email with instructions to reset your password.</p>

{{--                    <!-- Session Status -->--}}
                    <x-auth-session-status class="mb-4" :status="session('status')" />

{{--                    <!-- Validation Errors -->--}}
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form class="mt-4" method="POST" action="{{ route('password.email') }}">
                        @csrf

{{--                        <!-- Email Address -->--}}
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control mb-0" id="email" placeholder="Enter email" value="{{ old('email') }}" required autofocus >
                        </div>

                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-left py-2 px-4">{{ __('Email Password Reset Link') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('partials._body_footer')
