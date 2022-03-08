@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-guide-fill"> </i>'.$menuTitle, 'slots' => [['title' => 'الصلاحيات', 'link' => route('admin.roles.index')],['title' => $menuTitle, 'link' => null],]])
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
                        <h5 class="float-left my-auto"><i class="ri-guide-fill"> </i> {{ $menuTitle }}</h5>
                    </div>

                    <form dir="rtl" class="mt-4" method="POST" action="{{ route('admin.roles.update', $role->id) }}">
                    <div class="card-body">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="form-group col-lg-6">
                                <label for="name">الاسم (إنجليزي)</label>
                                <input type="text" name="name" class="form-control mb-0" id="name" tabindex="1" placeholder="الاسم (إنجليزي)" value="{{ old('name') ? old('name') : $role->name }}" required autofocus>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="name_ar">الاسم (عربي)</label>
                                <input type="text" name="name_ar" class="form-control mb-0" id="name_ar" tabindex="2" placeholder="الاسم (عربي)" value="{{ old('name_ar') ? old('name_ar') : $role->name_ar }}" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="description">وصف قصير</label>
                                <input type="text" name="description" class="form-control mb-0" id="description" tabindex="3" placeholder="وصف قصير" value="{{ old('description') ? old('description') : $role->description }}" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="cities">المدينة</label>
                                <select class="form-control" id="cities" name="cities" tabindex="4">
                                    <option disabled="">حدد المدينة</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ $role->cities == $city->id ? 'selected' : '' }}>{{ $city->name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12">
                                <p>الاذونات المرتبطة بالصلاحية</p>
                                <hr>

                                <div class="row">
                                @foreach($roles as $key => $role)
                                    <div class="col-lg-12">
                                    <lable><i class="ri-check-double-fill"> </i> {{ $role['name_ar'] }}</lable>
                                        <br>
                                    @foreach($permissions[$key] as $keyP => $permission)
                                        <div class="custom-control custom-checkbox custom-control-inline">
                                            <input type="checkbox" class="custom-control-input" name="permissions[]" id="{{ $permission['name'] }}" value="{{ $permission['name'] }}" {{in_array($permission['name'], $rolePermissions, true) ? 'checked': ''}}>
                                            <label class="custom-control-label" for="{{ $permission['name'] }}">{{ $permission['name_ar'] }}</label>
                                        </div>
                                    @endforeach
                                        <hr>
                                    </div>
                                @endforeach
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-muted">
                        @can('roles.update')
                        <div class="row flex inline-flex p-2 mx-2">
                            <button type="submit" class="btn px-5 btn-primary rounded-pill"><i class="ri-save-2-fill"> </i>حفظ</button>
                        </div>
                        @endcan
                    </div>
                    </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
