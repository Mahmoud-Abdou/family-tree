@include('partials._body_style')
<section class="sign-in-page bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters bg-white">
            <div class="col-sm-6 text-center d-none d-md-block" style="height: 100vh;">
                @include('partials._app_auth_info')
            </div>

            <div class="col-sm-6 align-self-center">
                <div class="sign-in-from">
                    <h1 class="mb-0">Verify Email</h1>
                    <div class="mb-4 text-sm text-gray-600">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                        </div>
                    @endif

                    <form class="mt-4" method="POST" action="{{ route('verification.send') }}">
                        @csrf

                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-left py-2 px-4">{{ __('Resend Verification Email') }}</button>
                        </div>
                    </form>

                    <form class="mt-4" method="POST" action="{{ route('logout') }}">
                        @csrf

                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-left py-2 px-4">{{ __('Log Out') }}</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>
@include('partials._body_footer')
