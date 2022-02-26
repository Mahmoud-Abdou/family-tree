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

                    <form name="registerForm" dir="rtl" class="mt-4" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">{{ __('الاسم') }}</label>
                            <input type="text" name="name" class="form-control mb-0" id="name" tabindex="1" placeholder="{{ __('الاسم') }}" value="{{ old('name') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="father_name">{{ __('اسم الأب') }}</label>
                            <input type="text" name="father_name" class="form-control mb-0" id="father_name" tabindex="2" placeholder="{{ __('اسم الأب') }}" value="{{ old('father_name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="gender">{{ __('النوع') }}</label>
                            <select id="gender" name="gender" tabindex="3" class="form-control mb-0" required>
                                <option value="male"{{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('ذكر') }}</option>
                                <option value="female"{{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('أنثى') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="has_family">الحالة الاجتماعية</label>
                            <select id="has_family" name="has_family" tabindex="4" class="form-control mb-0" onchange="changeSelect(this.value)" required>
                                <option value="0"{{ old('has_family') == '0' ? 'selected' : ''  }}>غير متزوج</option>
                                <option value="1"{{ old('has_family') == '1' ? 'selected' : ''  }}>متزوج</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mobileNumber">{{ __('رقم الجوال') }}</label>
                            <input type="text" name="mobile" class="form-control numeric mb-0" id="mobileNumber" tabindex="5" placeholder="أدخل رقم الجوال" value="{{ old('mobile') }}"  required>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('البريد الإلكتروني') }}</label>
                            <input type="email" name="email" class="form-control mb-0" id="email" tabindex="6" placeholder="أدخل البريد الإلكتروني" value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('كلمة المرور') }}</label>
                            <input type="password" name="password" class="form-control mb-0" id="password" tabindex="7" placeholder="{{ __('كلمة المرور') }}" required autocomplete="new-password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">{{ __('تأكيد كلمة المرور') }}</label>
                            <input type="password" name="password_confirmation" class="form-control mb-0" id="password_confirmation" tabindex="8" placeholder="{{ __('تأكيد كلمة المرور') }}" required>
                        </div>
                        <div class="d-inline-block w-100">
                            <div class="custom-control custom-checkbox d-inline-block mt-2 pt-1 float-right my-2">
                                <input type="checkbox" name="terms" class="custom-control-input" id="terms" tabindex="9" required {{ old('terms') == 'on' ? 'checked' : '' }} >
                                <label class="custom-control-label" for="terms"> عند الاشتراك فانت توافق على </label>
                                <a href="#" class="mx-1" data-toggle="modal" data-target="#termsModal">شروط الاستخدام </a>
                            </div>
                            <button type="submit" class="btn btn-primary float-left py-3 px-5" tabindex="10">اشتراك</button>
                        </div>
                        <div class="sign-info">
                            <span class="dark-color d-inline-block line-height-2">لديك حساب بالفعل؟
                                <a href="{{ route('login') }}" class="mx-3 py-3 px-5 btn btn-outline-primary">دخول</a>
                            </span>
                        </div>
                        <div class="modal fade" id="FamilyModel" tabindex="-1" role="dialog" aria-labelledby="FamilyModelLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="FamilyModelLabel"><i class="ri-user-fill"> </i>ادخال بيانات الزوج/ة </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group col-lg-12">
                                            <label for="partner_first_name">{{ __('الاسم') }}</label>
                                            <input type="text" name="partner_first_name" class="form-control mb-0" id="partner_first_name" value="{{ old('partner_first_name') }}">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partner_father_name">{{ __('اسم الأب') }}</label>
                                            <input type="text" name="partner_father_name" class="form-control mb-0" id="partner_father_name" value="{{ old('partner_father_name') }}">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partner_email">{{ __('البريد الإلكتروني') }}</label>
                                            <input type="email" name="partner_email" class="form-control mb-0" id="partner_email" value="{{ old('partner_email') }}" placeholder="أدخل البريد الإلكتروني">
                                        </div>
                                        <div class="form-group col-lg-12">
                                            <label for="partnerMobile">{{ __('رقم الجوال') }}</label>
                                            <input type="text" name="partner_mobile" class="form-control numeric mb-0" id="partnerMobile" placeholder="أدخل رقم الجوال" value="{{ old('partner_mobile') }}"  required>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-primary w-100 py-2">موافق</button>
                                    </div>
                                </div>
                            </div>
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

<script>
    function phoneFormat(input){
        // Strip all characters from the input except digits
        input = input.replace(/\D/g,'');

        // Trim the remaining input to ten characters, to preserve phone number format
        input = input.substring(0,10);

        // Based upon the length of the string, we add formatting as necessary
        // var size = input.length;
        // if(size == 0){
        //     input = input;
        // }else if(size < 4){
        //     input = '('+input;
        // }else if(size < 7){
        //     input = '('+input.substring(0,3)+') '+input.substring(3,6);
        // }else{
        //     input = '('+input.substring(0,3)+') '+input.substring(3,6)+' - '+input.substring(6,10);
        // }
        return input;
    }

    function changeSelect(value){
        if(value == 1){
            $("#FamilyModel").modal('show')
        }
    }

    document.getElementById('mobileNumber').addEventListener('keyup',function(evt){
        var phoneNumber = document.getElementById('mobileNumber');
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        phoneNumber.value = phoneFormat(phoneNumber.value);
    });

    document.getElementById('partnerMobile').addEventListener('keyup',function(evt){
        var phoneNumber = document.getElementById('partnerMobile');
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        phoneNumber.value = phoneFormat(phoneNumber.value);
    });
</script>
