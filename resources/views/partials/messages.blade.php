@if(session()->has('error'))
    <div class="alert alert-danger" role="alert">
        <i class="ri-information-line"> </i>
        <div class="iq-alert-text"><b>فشلت العملية.</b> {{ session()->get('error') }}</div>
        <button type="button" class="close text-danger" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
@endif

@if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        <i class="ri-information-line"> </i>
        <div class="iq-alert-text"><b>تمت العملية بنجاح.</b> {{ session()->get('success') }}</div>
        <button type="button" class="close text-success" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
@endif

@if(session()->has('warning'))
    <div class="alert alert-warning" role="alert">
        <i class="ri-information-line"> </i>
        <div class="iq-alert-text"><b>تنبيه: </b> {{ session()->get('warning') }}</div>
        <button type="button" class="close text-warning" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
@endif

@php
    session()->forget(['warning', 'success', 'error']);
@endphp
