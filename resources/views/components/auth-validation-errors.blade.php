@props(['errors'])

@if ($errors->any())
    <div {{ $attributes }}>
        <i class="ri-information-line"> </i>
        <div class="iq-alert-text"><b>فشلت العملية.</b>

            @if($errors->count() > 1)
                <ul class="p-0">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
                </ul>
            @else
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            @endif

        </div>
        <button type="button" class="close text-danger" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line"></i>
        </button>
    </div>
@endif
