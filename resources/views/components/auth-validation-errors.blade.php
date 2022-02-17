@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <i class="ri-information-line"> </i>
        <div class="iq-alert-text"><b>فشلت العملية.</b>
            @foreach ($errors->all() as $error)
                @if($errors->count() > 0)
                    <ul>{{ $error }}</ul>
                @else
                    <p>{{ $error }}</p>
                @endif
            @endforeach
        </div>
        <button type="button" class="close text-danger" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
@endif
