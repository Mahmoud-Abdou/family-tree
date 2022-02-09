<div class="tab-pane fade" id="profile-activity" role="tabpanel">
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height shadow">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title"><i class="ri-shield-star-fill"> </i>سجل الدخول</h4>
            </div>
            <div class="iq-card-header-toolbar d-flex align-items-center">
                <a href="{{ route('admin.log.destroy') }}" class="btn btn-danger rounded-pill float-right"><i class="ri-delete-back-2-fill"> </i>حذف السجل</a>
            </div>
        </div>
        <div class="iq-card-body">
            <ul class="iq-timeline">
                @foreach($histories as $history)
                <li>
                    <div class="timeline-dots border-success"></div>
                    <div class="card iq-mb-3">
                        <div class="row no-gutters">

                            <div class="col-md-10">
                                <div class="card-body">
{{--                                    <h4 class="card-title">تسجيل دخول </h4>--}}
                                    <p class="card-title">تسجيل دخول من المتصفح ({{ $history->browser }}) <img src="{{ $history->browser_image }}" width="40" alt="browser image"></p>
                                    <p class="card-text"><small class="text-muted">التاريخ: {{ date('Y-m-d', strtotime($history->last_login)) }}</small> | <small> الوقت: {{ date('H:i:s', strtotime($history->last_login)) }}</small></p>
                                </div>
                            </div>
                            <div class="col-md-2">
{{--                                <img src="{{ $history->os_image }}" class="img-thumbnail" alt="os image">--}}
                                <img src="{{ $history->os_image }}" width="120" class="rounded-circle" alt="os image">
                            </div>

                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
