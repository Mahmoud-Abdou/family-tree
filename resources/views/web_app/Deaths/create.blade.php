@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-map-2-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الوفيات', 'link' => route('deaths.index')],['title' => $menuTitle, 'link' => route('deaths.create')],]])
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
                        <h5 class="float-left my-auto"><i class="ri-map-2-line"> </i> {{ $menuTitle }}</h5>
                    </div>
                    <div class="card-body">
                    <form dir="rtl" method="POST" action="{{ route('deaths.store') }}" enctype="multipart/form-data">
                        @csrf
                            
                        <div class="row">

                            
                            <div class="form-group col-lg-6">
                                <label for="person_id">المتوفي</label>
                                <select name="person_id" id="person_id" class="form-control mb-0" required>
                                    <option disabled>اختر الشخص</option>
                                    @foreach($persons as $person)
                                        <option value="{{$person->id}}" >{{ $person->first_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="title">العنوان</label>
                                <input type="text" name="title" class="form-control mb-0" id="title" tabindex="2" required autofocus>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="body">الوصف</label>
                                <input type="text" name="body" class="form-control mb-0" id="body" tabindex="3"  required autofocus>
                            </div>
                            
                            <div class="form-group col-lg-6">
                                <label for="date">تاريخ الوفاة</label>
                                <input type="date" name="date" class="form-control mb-0" id="date" tabindex="8"  required autofocus>
                            </div>

                            
                            <div class="form-group col-lg-6">
                                <label for="app-icon">الصورة</label>
                                <input id="app-icon" class="file-upload-input" type="file" name="image"  accept="image/png,image/jpeg,image/jpg,image/icon" />
                                <div class="drag-text">
                                    <h3 class="m-4"><i class="ri-upload-2-line"> </i>اضغط أو اسحب صورة لرفعها</h3>
                                </div>
                            </div>
                            
                            <div class="form-group col-lg-6">
                                <div class="row flex inline-flex p-2 mx-2">
                                    <button type="submit" class="btn px-5 btn-primary rounded-pill " tabindex="6"><i class="ri-save-2-fill"> </i>حفظ </button>
                                </div>
                            </div>
                        </div>

                    </form>
                    </div>

                    <div class="card-footer text-muted"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
