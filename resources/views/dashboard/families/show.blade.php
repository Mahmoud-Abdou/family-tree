@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-group-2-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الأسر', 'link' => route('admin.families.index')], ['title' => $menuTitle, 'link' => route('admin.families.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

                <div class="col-sm-12">

                    <div class="iq-card iq-card-block iq-card-stretch iq-card-height shadow">
                        <div class="card-header d-flex justify-content-between">
                            <div class="iq-header-title">
                                <h4 class="card-title"><i class="ri-group-2-fill"> </i>{{ $menuTitle }}</h4>
                            </div>
{{--                            @if(auth()->user()->profile->id == $family->father->id || auth()->user()->profile->id == $family->mother->id)--}}
                                <div class="iq-card-header-toolbar d-flex align-items-center">
                                    <button type="button" class="btn btn-primary rounded-pill m-1" data-toggle="modal" data-target="#familyModal" onclick="modalFamily({{ $family->id }})"><i class="ri-add-fill"> </i>فرد للعائلة</button>
                                    <button type="button" class="btn btn-primary rounded-pill m-1" data-toggle="modal" data-target="#fosterFamilyModal" onclick="modalFosterFamily({{ $family->id }})"><i class="ri-add-fill"> </i>أخ في الرضاعة</button>
                                </div>
{{--                            @endif--}}
                        </div>

                        <div class="iq-card-body">
                            <h6 class="text-center">الوالدان</h6>
                            <div class="list-group list-group-horizontal text-center">
                                <a href="{{ route('admin.users.show', $family->father->user->id) }}" class="list-group-item list-group-item-action list-group-item-primary">{{ $family->father->full_name }}</a>
                                <a href="{{ route('admin.users.show', $family->mother->user->id) }}" class="list-group-item list-group-item-action list-group-item-danger">{{ $family->mother->full_name }}</a>
                            </div>
                            <br>
                            <h6 class="text-center">الأولاد</h6>
                            <div class="list-group text-center">
                                @foreach($family->members as $member)
                                    <a href="{{ route('admin.users.show', $member->id) }}" class="list-group-item list-group-item-action list-group-item-{{ $member->gender == 'male' ? 'primary' : 'danger' }}">{{ $member->full_name }}</a>
                                @endforeach
                            </div>

                            @if($family->fosterBrothers->count() > 0)
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
                            <p class="m-0 p-0"> عدد أفراد العائلة <span class="badge badge-pill border border-dark text-dark">{{ $family->children_count }}</span></p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

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
                                <option disabled selected>ابحث و حدد الشخص</option>
                                @foreach($allPersons as $per)
                                    <option value="{{$per->id}}">{{$per->full_name}}</option>
                                @endforeach
                            </select>
                            <br>
                            <br>
                            <button type="button" data-dismiss="modal" class="btn btn-primary rounded-pill m-1" data-toggle="modal" data-target="#newPersonModal" onclick="modalNewPerson({{ isset($ownFamily->id) ? $ownFamily->id : null }})"><i class="ri-add-fill"> </i>اضف شخص غير موجود</button>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-primary"><i class="ri-add-fill"> </i>اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                                    <option disabled selected>ابحث و حدد الشخص</option>
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
                            <button type="submit" class="btn btn-primary"><i class="ri-add-fill"> </i>اضافة</button>
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
                                    <input type="radio" id="male" name="gender" value="male" class="custom-control-input">
                                    <label class="custom-control-label" for="male"> ذكر </label>
                                </div>
                                <div class="custom-control custom-radio mx-4">
                                    <input type="radio" id="female" name="gender" value="female" class="custom-control-input">
                                    <label class="custom-control-label" for="female"> أنثى </label>
                                </div>
                            </div>
                        </div>
                        <br>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-primary"><i class="ri-add-fill"> </i>اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newPersonModal" tabindex="-1" role="dialog" aria-labelledby="newPersonModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title" id="newPersonModalLabel"><i class="ri-group-2-fill"> </i>اضافة اخ في الرضاعة للعائلة</h5>
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
                        <div class="form-group">
                            <label for="mobileNumber">{{ __('رقم الجوال') }}</label>
                            <input type="text" name="mobile" class="form-control numeric mb-0" id="mobileNumber" placeholder="أدخل رقم الجوال" value="{{ old('mobile') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('البريد الإلكتروني') }}</label>
                            <input type="email" name="email" class="form-control mb-0" id="email" placeholder="أدخل البريد الإلكتروني" value="{{ old('email') }}" >
                        </div>
                        <div>
                            <label>النوع</label>
                            <br>
                            <div class="d-inline-flex">
                                <div class="custom-control custom-radio mx-4">
                                    <input type="radio" id="male" name="gender" value="male" class="custom-control-input">
                                    <label class="custom-control-label" for="male"> ذكر </label>
                                </div>
                                <div class="custom-control custom-radio mx-5">
                                    <input type="radio" id="female" name="gender" value="female" class="custom-control-input">
                                    <label class="custom-control-label" for="female"> أنثى </label>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-primary"><i class="ri-add-fill"> </i>اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('add-scripts')
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
        function modalNewPerson(familyId) {
            $('#newPersonFamilyId').val(familyId);
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