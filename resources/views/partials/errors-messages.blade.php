@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <i class="ri-information-line m-1"> </i>
        <div class="iq-alert-text"><b>فشلت العملية.</b>
            <div class="">
                <ul class="m-0 p-0">
                    @foreach ($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="close text-danger my-auto" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line m-1"></i>
        </button>
    </div>
@endif
