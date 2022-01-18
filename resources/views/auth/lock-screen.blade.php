@include('partials._body_style')

<section class="sign-in-page bg-white">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-sm-6 text-center d-none d-md-block" style="height: 100vh;">
                @include('partials._app_auth_info')
            </div>

            <div class="col-sm-6 align-self-center">
                <div class="sign-in-from">
                    <img src={{asset("assets/images/user/1.jpg")}} alt="user-image" class="rounded-circle">
                            <h4 class="mt-3 mb-0">Hi ! Michael Smith</h4>
                            <p>Enter your password to access the admin.</p>
                    <form class="mt-4">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="Password" class="form-control mb-0" id="exampleInputEmail1"  placeholder="Password">
                        </div>

                        <div class="d-inline-block w-100">
                            <button type="submit" class="btn btn-primary float-right">Log In</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>
@include('partials._body_footer')
