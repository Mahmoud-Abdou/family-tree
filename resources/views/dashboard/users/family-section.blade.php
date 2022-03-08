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
                <a href="{{ route('admin.users.show', $person->belongsToFamily->father->id) }}" class="list-group-item list-group-item-action list-group-item-primary">{{ $person->belongsToFamily->father->full_name }}</a>
                @isset($person->belongsToFamily->mother)
                    <a href="{{ route('admin.users.show', $person->belongsToFamily->mother->id) }}" class="list-group-item list-group-item-action list-group-item-danger">{{ $person->belongsToFamily->mother->full_name }}</a>
                @else
                    <a href="#" class="list-group-item list-group-item-action list-group-item-danger">-----</a>
                @endisset
            </div>
            <br>
            <h6 class="text-center">الأولاد</h6>
            <div class="list-group text-center">
                @foreach($person->belongsToFamily->members as $member)
                    <a href="{{ route('admin.users.show', $member->id) }}" class="list-group-item list-group-item-action list-group-item-{{ $member->gender == 'male' ? 'primary' : 'danger' }}">{{ $member->full_name }}</a>
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
            <div class="iq-card iq-card-block iq-card-stretch iq-card-height shadow">
                <div class="iq-card-header d-flex justify-content-between">
                    <div class="iq-header-title">
                        <h4 class="card-title"><i class="ri-group-2-fill"> </i>العائلة</h4>
                    </div>
                    <div class="iq-card-header-toolbar d-flex align-items-center">
                        <button type="button" class="btn btn-primary rounded-pill m-1" data-toggle="modal" data-target="#familyModal" onclick="modalFamily({{ $ownFamily->id }})"><i class="ri-add-fill"> </i>فرد للعائلة</button>
                        <button type="button" class="btn btn-primary rounded-pill m-1" data-toggle="modal" data-target="#newFosterFamilyModal" onclick="modalNewFosterFamily({{ $ownFamily->id }})"><i class="ri-add-fill"> </i>أخ في الرضاعة</button>
{{--                        <button type="button" class="btn btn-primary rounded-pill m-1" data-toggle="modal" data-target="#fosterFamilyModal" onclick="modalFosterFamily({{ $ownFamily->id }})"><i class="ri-add-fill"> </i>أخ في الرضاعة</button>--}}
                    </div>
                </div>

                <div class="iq-card-body">
                    <h6 class="text-center">الوالدان</h6>
                    <div class="list-group list-group-horizontal text-center">
                        @isset($ownFamily->father)
                        <a href="{{ route('search.result', [$ownFamily->father->first_name, $ownFamily->father->id]) }}" class="list-group-item list-group-item-action list-group-item-primary">{{ $ownFamily->father->full_name }}</a>
                        @else
                            <a href="#" class="list-group-item list-group-item-action list-group-item-primary">{{ $ownFamily->father->full_name }}</a>
                        @endisset
                        @isset($ownFamily->mother)
                            <a href="{{ route('search.result', [$ownFamily->mother->first_name, $ownFamily->mother->id]) }}" class="list-group-item list-group-item-action list-group-item-danger">{{ $ownFamily->mother->full_name }}</a>
                        @else
                            <a href="#" class="list-group-item list-group-item-action list-group-item-danger">{{ isset($ownFamily->mother) ? $ownFamily->mother->full_name : '-----' }}</a>
                        @endisset
                    </div>
                    <br>
                    <h6 class="text-center">الأولاد</h6>
                    <div class="list-group text-center">
                        @foreach($ownFamily->members as $member)
                        <a href="{{ route('search.result', [$member->first_name, $member->id]) }}" class="list-group-item list-group-item-action list-group-item-{{ $member->gender == 'male' ? 'primary' : 'danger' }}">{{ $member->full_name }}</a>
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
                            <label for="selectUser">ابحث و اختر الأشخاص، ليتم اضافتهم</label>
                            <select id="selectUser" name="users[]" class="js-states form-control" multiple="multiple" style="width: 100%;">
                                @foreach($personsData as $per)
                                    <option value="{{$per->id}}" $>{{$per->full_name}}</option>
                                @endforeach
                            </select>
                            <br>
                            <br>
                            <button type="button" data-dismiss="modal" class="btn btn-primary rounded-pill m-1" data-toggle="modal" data-target="#newPersonModal" onclick="modalNewPerson()"><i class="ri-add-fill"> </i>اضف شخص غير موجود</button>
                            <br>
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

    <div class="modal fade" id="newPersonModal" tabindex="-1" role="dialog" aria-labelledby="newPersonModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="newPersonModalLabel"><i class="ri-group-2-fill"> </i>اضافة فرد للعائلة</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <form method="POST" action="{{ route('user.new_person') }}">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <input id="newPersonFamilyId" type="hidden" name="family_id">

                        <label for="name">الاسم</label>
                        <input id="name" type="text" class="form-control" name="name"  placeholder="الاسم" value="{{ old('first_name') }}">
                        <br>
                        <div>
                            <label>النوع</label>
                            <br>
                            <div class="d-inline-flex">
                                <div class="custom-control custom-radio mx-4">
                                    <input type="radio" id="male_new" name="gender" value="male" class="custom-control-input" {{ old('gender') == 'male' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="male_new"> ذكر </label>
                                </div>
                                <div class="custom-control custom-radio mx-4">
                                    <input type="radio" id="female_new" name="gender" value="female" class="custom-control-input" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="female_new"> أنثى </label>
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

    @if(isset($ownFamily->id))
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
                        <input id="foster_father_name" type="text" class="form-control" name="father_name" placeholder="اسم الاب" value="{{ old('father_name') }}">
                        <br>
                        <label for="foster_grand_father_name">اسم الجد</label>
                        <input id="foster_grand_father_name" type="text" class="form-control" name="grand_father_name"  placeholder="اسم الجد" value="{{ old('grand_father_name') }}">
                        <br>
                        <label for="foster_surname">الكنية</label>
                        <input id="foster_surname" type="text" class="form-control" name="surname"  placeholder="الكنية" value="{{ old('surname') }}">
                        <br>
                        <div>
                            <label>النوع</label>
                            <br>
                            <div class="d-inline-flex">
                                <div class="custom-control custom-radio mx-4">
                                    <input type="radio" id="male" name="gender" value="male" class="custom-control-input" {{ old('gender') == 'male' ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="male"> ذكر </label>
                                </div>
                                <div class="custom-control custom-radio mx-4">
                                    <input type="radio" id="female" name="gender" value="female" class="custom-control-input" {{ old('gender') == 'female' ? 'checked' : '' }}>
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

    {{--<!-- JavaScript -->--}}
    <script>
        function modalFamily(familyId) {
            $('#familyId').val(familyId);
        }
        function modalNewFosterFamily(familyId) {
            $('#newFosterFamilyId').val(familyId);
        }
        function modalNewPerson() {
            $('#newPersonFamilyId').val($('#familyId').val());
        }

        $(document).ready(function() {
            $('#selectUser').select2({
                placeholder: 'حدد الفرد',
                closeOnSelect: true,
                allowClear: true,
                dir: 'rtl',
                language: 'ar',
                width: '100%',
            });

            $('#selectUser2').select2({
                placeholder: 'حدد الفرد',
                closeOnSelect: true,
                allowClear: true,
                dir: 'rtl',
                language: 'ar',
                width: '100%',
            });

        });
    </script>
@endsection
