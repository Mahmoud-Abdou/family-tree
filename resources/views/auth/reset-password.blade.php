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
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form class="mt-4" method="POST" action="{{ route('password.update') }}">
                        @csrf

{{--                        <!-- Password Reset Token -->--}}
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

{{--                        <!-- Email Address -->--}}
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" name="email" class="form-control mb-0" id="email" placeholder="Enter email" value="{{old('email', $request->email)}}" required autofocus >
                        </div>

{{--                        <!-- Password -->--}}
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input type="password" name="password" class="form-control mb-0" id="password" required >
                        </div>

{{--                        <!-- Confirm Password -->--}}
                        <div class="form-group">
                            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                            <input type="password" name="password_confirmation" class="form-control mb-0" id="password_confirmation" required >
                        </div>

                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-left py-2 px-4">{{ __('Reset Password') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('partials._body_footer')
