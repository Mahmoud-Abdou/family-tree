@extends('layouts.master')

@section('page-title', $pageTitle)

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

                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-group-2-line"> </i> {{ $menuTitle }}</h5>
                        </div>

                        <form dir="rtl" method="POST" action="{{ route('admin.families.store') }}">
                            <div class="card-body">
                                @csrf

                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="familyName">اسم العائلة</label>
                                        <input type="text" name="name" id="familyName" value="{{ old('name') }}" class="d-block w-100">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="selectFather">ابحث و حدد الأب</label>
                                        <select id="selectFather" name="father_id" class="js-states form-control" style="width: 100%;">
                                            @foreach($fathers as $father)
                                                <option value="{{$father->id}}">{{$father->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="selectMother">ابحث و حدد الأم</label>
                                        <select id="selectMother" name="mother_id" class="js-states form-control" style="width: 100%;">
                                            @foreach($mothers as $mother)
                                                <option value="{{$mother->id}}">{{$mother->full_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="selectGrandFather">ابحث و حدد عائلة الجد</label>
                                        <select id="selectGrandFather" name="gf_family_id" class="js-states form-control" style="width: 100%;">
                                            @foreach($families as $fam)
                                                <option value="{{$fam->id}}">{{$fam->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="children">عدد الأولاد</label>
                                        <input type="number" name="children_count" id="children" class="d-block w-100" value="{{ old('children_count') }}">
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
        });
    </script>
@endsection
