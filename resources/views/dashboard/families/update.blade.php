@extends('layouts.master')

@section('page-title', $pageTitle)

@section('add-styles')
    <link rel="stylesheet" href="{{ secure_asset('assets/css/select2-rtl.min.css') }}"/>
@endsection

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-group-2-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الأسر', 'link' => route('admin.families.index')],['title' => $menuTitle, 'link' => route('admin.families.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">

                    @include('partials.messages')
                    @include('partials.errors-messages')

                    <div class="card iq-mb-3 shadow">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-group-2-line"> </i> {{ $menuTitle }}</h5>
                        </div>

                        <form dir="rtl" method="POST" action="{{ route('admin.families.update', $family->id) }}">
                            <div class="card-body">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="familyName">اسم العائلة</label>
                                        <input type="text" name="name" id="familyName" value="{{ $family->name }}" class="d-block w-100" style="height: 40px;">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="selectFather">الأب</label>
                                        <select id="selectFather" name="father_id" class="js-states form-control" style="width: 100%;">
                                            @foreach($fathers as $father)
                                                <option value="{{$father->id}}" {{$family->father->id == $father->id ? 'selected' : ''}}>{{$father->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="selectMother">ابحث و حدد الأم</label>
                                        <select id="selectMother" name="mother_id" class="js-states form-control" style="width: 100%;">
                                            <option value="none">لا يوجد</option>
                                            @foreach($mothers as $mother)
                                                <option value="{{$mother->id}}" {{ $family->mother_id == $mother->id ? 'selected' : '' }}>{{$mother->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="familyChildrenMale">الأولاد (الذكور)</label>
                                        <select id="familyChildrenMale" name="family_children_m[]" class="js-example-placeholder-multiple js-states form-control" multiple="multiple" style="width: 100%;">
                                            @foreach($fathers as $child)
                                                @if($boys->contains('id', $child->id))
                                                    <option value="{{$child->id}}" selected>{{$child->full_name}}</option>
                                                @else
                                                    <option value="{{$child->id}}">{{$child->full_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="familyChildrenFemale">الأولاد (الإناث)</label>
                                        <select id="familyChildrenFemale" name="family_children_f[]" class="js-example-placeholder-multiple js-states form-control" multiple="multiple" style="width: 100%;">
                                            @foreach($mothers as $child)
                                                @if($girls->contains('id', $child->id))
                                                    <option value="{{$child->id}}" selected>{{$child->full_name}}</option>
                                                @else
                                                    <option value="{{$child->id}}">{{$child->full_name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group col-lg-6">
                                        <label for="selectGrandFather">ابحث و حدد عائلة الجد</label>
                                        <select id="selectGrandFather" name="gf_family_id" class="js-states form-control" style="width: 100%;">
                                            <option value="none">لا يوجد</option>
                                            @foreach($families as $fam)
                                                <option value="{{$fam->id}}" {{ $family->gf_family_id == $fam->id ? 'selected' : '' }}>{{$fam->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer text-muted">
                                <div class="row flex inline-flex p-2 mx-2">
                                    <button type="submit" class="btn px-5 btn-primary rounded-pill w-25"><i class="ri-save-2-fill"> </i>حفظ</button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('add-scripts')
    <script>
        $(document).ready(function() {
            $('#selectFather').select2({
                placeholder: 'حدد الأب',
                closeOnSelect: true,
                dir: 'rtl',
                language: 'ar',
                width: '100%',
            });

            $('#selectMother').select2({
                placeholder: 'حدد الأم',
                closeOnSelect: true,
                tags: true,
                dir: 'rtl',
                language: 'ar',
                width: '100%',
            });

            $('#selectGrandFather').select2({
                placeholder: 'حدد الجد',
                closeOnSelect: true,
                dir: 'rtl',
                language: 'ar',
                width: '100%',
            });

            $('#familyChildrenMale').select2({
                placeholder: 'أضف الأولاد',
                closeOnSelect: true,
                allowClear: true,
                tags: true,
                dir: 'rtl',
                language: 'ar',
                width: '100%',
            });

            $('#familyChildrenFemale').select2({
                placeholder: 'أضف البنات',
                closeOnSelect: true,
                allowClear: true,
                tags: true,
                dir: 'rtl',
                language: 'ar',
                width: '100%',
            });

        });
    </script>
@endsection
