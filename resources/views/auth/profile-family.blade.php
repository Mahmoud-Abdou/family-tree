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
                <a href="{{ route('admin.users.show', $person->belongsToFamily->father->user->id) }}" class="list-group-item list-group-item-action list-group-item-primary">{{ $person->belongsToFamily->father->full_name }}</a>
                <a href="{{ route('admin.users.show', $person->belongsToFamily->mother->user->id) }}" class="list-group-item list-group-item-action list-group-item-danger">{{ $person->belongsToFamily->mother->full_name }}</a>
            </div>
            <br>
            <h6 class="text-center">الأولاد</h6>
            <div class="list-group text-center">
                @foreach($person->belongsToFamily->members as $member)
                    <a href="{{ route('admin.users.show', $member->user->id) }}" class="list-group-item list-group-item-action list-group-item-{{ $member->gender == 'male' ? 'primary' : 'danger' }}">{{ $member->full_name }}</a>
                @endforeach
            </div>
            @if($person->belongsToFamily->fosterBrothers->count() > 0)
                <br>
                <h6 class="text-center">الاخوة في الرضاعة</h6>
                <div class="list-group text-center">
                    @foreach($person->belongsToFamily->fosterBrothers as $member)
                        <a href="#" class="list-group-item list-group-item-action list-group-item-{{ $member->person->gender == 'male' ? 'primary' : 'danger' }}">{{ $member->person->full_name }}</a>
                    @endforeach
                </div>
            @endif

        </div>
        <div class="card-footer">
            <p class="m-0 p-0"> عدد أفراد العائلة <span class="badge badge-pill border border-dark text-dark">{{ $person->belongsToFamily->children_count }}</span></p>
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
                    @if(auth()->user()->profile->id == $ownFamily->father->id || auth()->user()->profile->id == $ownFamily->mother->id)
                    <div class="iq-card-header-toolbar d-flex align-items-center">
                        <button type="button" class="btn btn-primary rounded-pill m-1" data-toggle="modal" data-target="#familyModal" onclick="modalFamily({{ $ownFamily->id }})"><i class="ri-add-fill"> </i>اضافة فرد للعائلة</button>
                        <button type="button" class="btn btn-primary rounded-pill m-1" data-toggle="modal" data-target="#fosterFamilyModal" onclick="modalFosterFamily({{ $ownFamily->id }})"><i class="ri-add-fill"> </i>اضافة اخ في الرضاعة للعائلة</button>
                    </div>
                    @endif
                </div>

                <div class="iq-card-body">
                    <h6 class="text-center">الوالدان</h6>
                    <div class="list-group list-group-horizontal text-center">
                        <a href="{{ route('admin.users.show', $ownFamily->father->user->id) }}" class="list-group-item list-group-item-action list-group-item-primary">{{ $ownFamily->father->full_name }}</a>
                        <a href="{{ route('admin.users.show', $ownFamily->mother->user->id) }}" class="list-group-item list-group-item-action list-group-item-danger">{{ $ownFamily->mother->full_name }}</a>
                    </div>
                    <br>
                    <h6 class="text-center">الأولاد</h6>
                    <div class="list-group text-center">
                        @foreach($ownFamily->members as $member)
                        <a href="{{ route('admin.users.show', $member->user->id) }}" class="list-group-item list-group-item-action list-group-item-{{ $member->gender == 'male' ? 'primary' : 'danger' }}">{{ $member->full_name }}</a>
                        @endforeach
                    </div>
                    @if($ownFamily->fosterBrothers->count() > 0)
                        <br>
                        <h6 class="text-center">الاخوة في الرضاعة</h6>
                        <div class="list-group text-center">
                            @foreach($ownFamily->fosterBrothers as $member)
                            <a href="#" class="list-group-item list-group-item-action list-group-item-{{ $member->person->gender == 'male' ? 'primary' : 'danger' }}">{{ $member->person->full_name }}</a>
                            @endforeach
                        </div>
                    @endif

                </div>
                <div class="card-footer">
                    <p class="m-0 p-0"> عدد أفراد العائلة <span class="badge badge-pill border border-dark text-dark">{{ $ownFamily->children_count }}</span></p>
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

    @if(isset($ownFamily->id))
    <div class="modal fade" id="fosterFamilyModal" tabindex="-1" role="dialog" aria-labelledby="fosterFamilyModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="familyModalLabel"><i class="ri-group-2-fill"> </i>اضافة اخ في الرضاعة للعائلة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                @isset($fosterPersonsData)
                <form method="POST" action="{{ route('user.foster_family') }}">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <input id="fosterFamilyId" type="hidden" name="family_id">

                        <div class="form-group">
                            <label for="selectUser2">ابحث و اختر الشخص، ليتم اضافته</label>
                            <select id="selectUser2" name="person_id" class="js-states form-control" style="width: 100%;">
                                @foreach($fosterPersonsData as $foster)
                                    <option value="{{$foster->id}}">{{$foster->full_name}}</option>
                                @endforeach
                            </select>
                            <br>
                            <br>
                            <button type="button" data-dismiss="modal" class="btn btn-primary rounded-pill m-1" data-toggle="modal" data-target="#newFosterFamilyModal" onclick="modalNewFosterFamily({{ $ownFamily->id }})"><i class="ri-add-fill"> </i>اضف شخص غير موجود</button>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button id="roleFormBtn" type="submit" class="btn btn-primary"><i class="ri-add-fill"> </i>اضافة</button>
                    </div>
                </form>
                @endisset
            </div>
        </div>
    </div>

    <div class="modal fade" id="newFosterFamilyModal" tabindex="-1" role="dialog" aria-labelledby="newFosterFamilyModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="newFosterFamilyModalLabel"><i class="ri-group-2-fill"> </i>اضافة اخ في الرضاعة للعائلة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('user.new_foster_family') }}">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <input id="newFosterFamilyId" type="hidden" name="family_id">

                        <label for="foster_first_name">الاسم</label>
                        <input id="foster_first_name" type="text" class="form-control" name="first_name"  placeholder="الاسم">
                        <br>
                        <label for="foster_father_name">اسم الاب</label>
                        <input id="foster_father_name" type="text" class="form-control" name="father_name" placeholder="اسم الاب">
                        <br>
                        <div>
                            <label>النوع</label>
                            <br>
                            <div class="d-inline-flex">
                                <div class="custom-control custom-radio mx-4">
                                    <input type="radio" id="male" name="gender" value="male" class="custom-control-input" {{ $person->gender == 'male' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="male"> رجل </label>
                                </div>
                                <div class="custom-control custom-radio mx-4">
                                    <input type="radio" id="female" name="gender" value="female" class="custom-control-input" {{ $person->gender == 'female' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="female"> أنثى </label>
                                </div>
                            </div>
                        </div>
                        <br>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button id="roleFormBtn" type="submit" class="btn btn-primary"><i class="ri-add-fill"> </i>اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{--<!-- Select2 JavaScript -->--}}
    <script>
        function modalFamily(familyId) {
            $('#familyId').val(familyId);
        }
        function modalFosterFamily(familyId) {
            $('#fosterFamilyId').val(familyId);
        }
        function modalNewFosterFamily(familyId) {
            $('#newFosterFamilyId').val(familyId);
        }

        $(document).ready(function() {
            $('#selectUser').select2({
                placeholder: 'حدد الفرد',
                closeOnSelect: true,
                dir: 'rtl',
                language: 'ar',
                width: '100%',
            });

            $('#selectUser2').select2({
                placeholder: 'حدد الفرد',
                closeOnSelect: true,
                dir: 'rtl',
                language: 'ar',
                width: '100%',
            });

        });
    </script>
@endsection
