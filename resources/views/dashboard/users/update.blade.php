@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-user-2-fill"> </i>'.$menuTitle, 'slots' => [['title' => 'المستخدمين', 'link' => route('admin.users.index')],['title' => $menuTitle, 'link' => route('admin.users.create')],]])
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
                            <h5 class="float-left my-auto"><i class="ri-user-2-fill"> </i> {{ $menuTitle }}</h5>
                        </div>
                        <form dir="rtl" method="POST" action="{{ route('admin.users.update_user') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="name">{{ __('الاسم') }}</label>
                                        <input type="text" name="name" class="form-control mb-0" id="name" tabindex="1" placeholder="{{ __('الاسم') }}" value="{{ $person->first_name }}" required autofocus>
                                    </div>
                                    <div class="form-group col-lg-6 my-3">
                                        <label>حدد هذا الخيار اذا كان الشخص متوفي</label>
                                        <div class="d-inline-flex">
                                            <div class="custom-control custom-radio mx-4">
                                                <input type="checkbox" id="is_alive" name="is_alive" class="custom-control-input" onclick=showDate()>
                                                <label class="custom-control-label" for="is_alive"> متوفي </label>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="person_id" value="{{ $person->id }}">
                                    @if($person->is_live == 1)
                                        <div class="form-group col-lg-6 d-none" id="death_date">
                                            <label for="date">تاريخ الوفاه</label>
                                            <input type="date" name="death_date" class="form-control mb-0" id="date" value="{{ $person->death_date }}">
                                        </div>
                                    @else
                                        <div class="form-group col-lg-6 d-block" id="death_date">
                                            <label for="date">تاريخ الوفاه</label>
                                            <input type="date" name="death_date" class="form-control mb-0" id="date" value="{{ $person->death_date }}">
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-footer text-muted">
                                <button type="submit" class="btn px-5 btn-primary rounded-pill "
                                        tabindex="5"><i class="ri-save-2-fill"> </i>حفظ
                                </button>
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

    function showDate(){
        if($("#death_date").hasClass('d-none'))
            $('#death_date').removeClass('d-none').addClass('d-block');
        else
            $('#death_date').removeClass('d-block').addClass('d-none');

    }

</script>
@endsection
