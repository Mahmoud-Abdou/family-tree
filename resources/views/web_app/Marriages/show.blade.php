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
                            
                        </div>
                        <div class="card-body p-0">
                            <div class="row text-center">
                                    <div class="col-sm-4">
                                        <div class="card iq-mb-3">
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $marriage->title }}</h4>
                                                <hr />
                                                <p class="card-text">{!! $marriage->body !!}</p>
                                                <hr />
                                                <p class="card-text">{!! $marriage->father->first_name !!}</p>
                                                <hr />
                                                <p class="card-text">{!! $marriage->mother->first_name !!}</p>
                                            </div>
                                            <div class="card-footer">
                                                <div class="d-flex justify-content-between" dir="ltr">
                                                    <p class="card-text m-0"><i class="ri-user-2-fill"> </i><small class="text-muted">{{ $marriage->owner->name }}</small></p>
                                                    @if($marriage->owner_id == auth()->user()->id)
                                                        @can('marriages.update')
                                                        
                                                            <a href="{{ route('marriages.edit', $marriage) }}" class="card-text m-0"><i class="ri-edit-2-fill"> </i><small class="text-muted"></small></p>
                                                        @endcan
                                                        @can('marriages.delete')
                                                        <form action="{{ route('marriages.destroy', $marriage) }}" method="POST">
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