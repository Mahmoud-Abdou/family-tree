<div class="tab-pane m-0 fade {{ isset($_GET['tab']) && $_GET['tab'] == 'favorite' ? 'active show' : '' }}" id="profile-favorite" role="tabpanel">
    <div class="row">
        @if($favorites->count() > 0)
            @foreach($favorites as $row)
                <div class="col-sm-4">
                    <a href="{{ route('news.show', $row->id) }}">
                        <div class="card iq-mb-3 shadow iq-bg-primary-hover">
                            <div class="card-body">
                                <h4 class="card-title">{{ $row->title }}</h4>
{{--                                <a href="{{ route('search.result', [$row->owner->name, $row->owner->id]) }}">{{ $row->owner->name }}</a>--}}
                                <hr />
                                <p class="card-text">{!! $row->short_body !!}</p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-between" dir="ltr">
                                    <p class="card-text m-0"><i class="ri-timer-2-fill"> </i><small class="text-muted">{{ date('Y-m-d', strtotime($row->date)) }}</small></p>
{{--                                    <p class="card-text m-0"><i class="ri-map-pin-2-fill"> </i><small class="text-muted">{{ $row->city->name_ar }}</small></p>--}}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        @else
            <div class="col-lg-12">
                <div class="card iq-mb-3 shadow p-5">
                    <div class="card-body text-center">
                        لا توجد بيانات
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
