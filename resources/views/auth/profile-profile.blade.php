<div class="tab-pane fade active show" id="profile-profile" role="tabpanel">
    <div class="row">
        <div class="col-lg-3">
            <div class="iq-card iq-card-block iq-card-stretch">
                <div class="iq-card-header d-flex justify-content-between {{ $profile->gender == 'male' ? 'bg-cyan' : 'bg-pink' }}">
                    <div class="iq-header-title">
                        <h4 class="card-title">المعلومات الشخصية</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    <div class="about-info m-0 p-0">
                        <div class="row">
{{--                            <div class="col-12"><p>المعلومات الشخصية</p></div>--}}
                            <div class="col-3"><i class="ri-user-fill"> </i>:</div>
                            <div class="col-9">{{ $profile->full_name }}</div>
                            <div class="col-3"><i class="ri-user-smile-fill"> </i>:</div>
                            <div class="col-9">{{ $profile->status }}</div>
                            <div class="col-3"><i class="ri-time-line"> </i>:</div>
                            <div class="col-9">{{ $profile->age }}</div>
                            <div class="col-3"><i class="ri-award-fill"> </i>:</div>
                            <div class="col-9">{{ $profile->job }}</div>
                            <div class="col-3"><i class="ri-mail-fill"> </i>:</div>
                            <div class="col-9"><a href="mailto:{{ $profile->user->email }}"> {{ $profile->user->email }} </a></div>
                            <div class="col-3"><i class="ri-phone-fill"> </i>:</div>
                            <div class="col-9"><a href="tel:{{ $profile->user->mobile }}">{{ $profile->user->mobile }}</a></div>
                            <div class="col-3"><i class="ri-map-pin-2-fill"> </i>:</div>
                            <div class="col-9">{{ isset($profile->user->city) ? $profile->user->city->name_ar : '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"><i class="ri-information-line"> </i>السيرة الذاتية</h4>
                    </div>
                </div>
                <div class="iq-card-body">
                    @isset($profile->bio) {!! $profile->bio !!} @else <p class="text-center">لم يتم كتابة السيرة الذاتية</p> @endisset
                </div>
            </div>
        </div>
    </div>
</div>
