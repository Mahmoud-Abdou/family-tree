@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-calendar-event-line"> </i>'.$menuTitle, 'slots' => [['title' => 'الاخبار', 'link' => route('media.index')],['title' => $menuTitle, 'link' => null],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @include('partials.messages')
                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-map-2-line"> </i> {{ $menuTitle }}</h5>
                            @can('news.create')
                                <a href="{{ route('news.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                            @endcan
                        </div>
                        <div class="card-body p-0">
                            <div class="row text-center">
                                @foreach($news as $row)
                                    <div class="col-sm-4">
                                        <div class="card iq-mb-3">
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $row->title }}</h4>
                                                <hr />
                                                <p class="card-text">{!! $row->body !!}</p>
                                            </div>
                                            <div class="card-footer">
                                                <div class="d-flex justify-content-between" dir="ltr">
                                                    <p class="card-text m-0"><i class="ri-user-2-fill"> </i><small class="text-muted">{{ $row->owner->name }}</small></p>
                                                    <p class="card-text m-0"><i class="ri-map-pin-2-fill"> </i><small class="text-muted">{{ $row->city->name_ar }}</small></p>
                                                    @if($row->owner_id == auth()->user()->id)
                                                        @can('news.update')
                                                        
                                                            <a href="{{ route('news.edit', $row) }}" class="card-text m-0"><i class="ri-edit-2-fill"> </i><small class="text-muted"></small></p>
                                                        @endcan
                                                        @can('news.delete')
                                                        <form action="{{ route('news.destroy', $row) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')

                                                            <a onclick= "submit_form(this)" class="card-text m-0"><i class="ri-delete-back-2-fill"></i></a>
                                                        </form>
                                                        @endcan
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                @endforeach
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function submit_form(form){
        if(confirm('Are you sure?')){
            $(form).parent().submit()
        }
    }
</script>