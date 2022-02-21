<div class="tab-pane fade {{ isset($_GET['tab']) && $_GET['tab'] == 'family' ? 'active show' : '' }}" id="profile-family" role="tabpanel">
    @isset($person->belongsToFamily)
    <div class="iq-card iq-card-block iq-card-stretch iq-card-height shadow">
        <div class="iq-card-header d-flex justify-content-between">
            <div class="iq-header-title">
                <h4 class="card-title my-auto"><i class="ri-group-2-fill"> </i>عائلة الأب</h4>
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
                    @if(auth()->id() == $ownFamily->father->id || auth()->id() == $ownFamily->mother->id)
                    <div class="iq-card-header-toolbar d-flex align-items-center">
                        <button type="button" class="btn btn-primary rounded-pill m-1" data-toggle="modal" data-target="#familyModal" onclick="modalFamily({{ $ownFamily->id }})"><i class="ri-add-fill"> </i>اضافة فرد للعائلة</button>
                    </div>
                    @endif
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

@section('add-scripts')
    <div class="modal fade" id="familyModal" tabindex="-1" role="dialog" aria-labelledby="familyModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="familyModalLabel"><i class="ri-group-2-fill"> </i>اضافة فرد للعائلة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
{{--                // TODO: handel form action #--}}
                <form method="POST" action="{{ route('user.family') }}">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <input id="familyId" type="hidden" name="family_id">

                        <div class="form-group">
                            <label for="selectUser">ابحث و اختر الشخص، ليتم اضافته</label>
                            <select id="selectUser" name="user_id" class="js-states form-control" style="width: 100%;">
                                @foreach($personsData as $per)
                                    <option value="{{$per->id}}">{{$per->full_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button id="roleFormBtn" type="submit" class="btn btn-primary"><i class="ri-add-fill"> </i>اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--<!-- Select2 JavaScript -->--}}
    <script>
        function modalFamily(familyId) {
            $('#familyId').val(familyId);
        }

        $(document).ready(function() {
            $('#selectUser').select2({
                placeholder: 'حدد الفرد',
                closeOnSelect: true,
                dir: 'rtl',
                language: 'ar',
                width: '100%',
            });
        });
    </script>
@endsection
