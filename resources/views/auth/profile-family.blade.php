<div class="tab-pane fade {{ isset($_GET['tab']) && $_GET['tab'] == 'family' ? 'active show' : '' }}" id="profile-family" role="tabpanel">
    @isset($person->belongsToFamily)
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height shadow">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title"><i class="ri-group-2-fill"> </i>عائلة الأب</h4>
            </div>
        </div>
        <div class="iq-card-body">
            <h6 class="text-center">الوالدان</h6>
            <div class="list-group list-group-horizontal text-center">
                <a href="#" class="list-group-item list-group-item-action list-group-item-primary">{{ $person->belongsToFamily->father->full_name }}</a>
                <a href="#" class="list-group-item list-group-item-action list-group-item-danger">{{ $person->belongsToFamily->mother->full_name }}</a>
            </div>
            <br>
            <h6 class="text-center">الأولاد</h6>
            <div class="list-group text-center">
                @foreach($person->belongsToFamily->members as $member)
                    <a href="#" class="list-group-item list-group-item-action list-group-item-{{ $member->gender == 'male' ? 'primary' : 'danger' }}">{{ $member->full_name }}</a>
                @endforeach
            </div>

        </div>
        <div class="card-footer">
            <p class="m-0 p-0"> عدد أفراد العائلة  <span class="badge badge-pill border border-dark text-dark">{{ $person->belongsToFamily->children_count }}</span></p>
        </div>
    </div>
    @endif

    @if($person->has_family)
        @foreach($person->ownFamily as $ownFamily)
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"><i class="ri-group-2-fill"> </i>العائلة</h4>
                    </div>
                    <div class="iq-card-header-toolbar d-flex align-items-center">
                        <button class="btn btn-outline-primary rounded-pill"> اضافة فرد للعائلة </button>
                    </div>
                </div>
                <div class="iq-card-body">
                    <h6 class="text-center">الوالدان</h6>
                    <div class="list-group list-group-horizontal text-center">
                        <a href="#" class="list-group-item list-group-item-action list-group-item-primary">{{ $ownFamily->father->full_name }}</a>
                        <a href="#" class="list-group-item list-group-item-action list-group-item-danger">{{ $ownFamily->mother->full_name }}</a>
                    </div>
                    <br>
                    <h6 class="text-center">الأولاد</h6>
                    <div class="list-group text-center">
                        @foreach($ownFamily->members as $member)
                        <a href="#" class="list-group-item list-group-item-action list-group-item-{{ $member->gender == 'male' ? 'primary' : 'danger' }}">{{ $member->full_name }}</a>
                        @endforeach
                    </div>

                </div>
                <div class="card-footer">
                    <p class="m-0 p-0"> عدد أفراد العائلة  <span class="badge badge-pill border border-dark text-dark">{{ $ownFamily->children_count }}</span></p>
                </div>
            </div>
        @endforeach
    @endif
</div>
