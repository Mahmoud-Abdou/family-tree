@include('partials._body_style')
<section class="sign-in-page bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters bg-white">
            <div class="col-sm-6 text-center d-none d-md-block" style="height: 100vh;">
                @include('partials._app_auth_info')
            </div>

            <div class="col-sm-6 align-self-center">
                <div class="sign-in-from">
                    <h1 class="mb-0">Confirm Password</h1>
                    <p>{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>

                    {{--                    <!-- Validation Errors -->--}}
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />

                    <form class="mt-4" method="POST" action="{{ route('password.confirm') }}">
                        @csrf

{{--                        <!-- Password -->--}}
                        <div class="form-group">
                            <label for="password">{{ __('Email') }}</label>
                            <input type="password" name="password" class="form-control mb-0" id="password" required autocomplete="current-password" >
                        </div>

                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-left py-2 px-4">{{ __('Confirm') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@include('partials._body_footer')
