@extends('layouts.master')

@section('page-title', $pageTitle)r

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
                                                <h4 class="card-title">{{ $newborn->title }}</h4>
                                                <hr />
                                                <div class="col-sm-12">
                                                    <div class="card iq-mb-3">
                                                        <div class="card-body">
                                                            <img src="{{ isset($newborn->image->file) ? $newborn->image->file : 'default.jpg' }}" class="img-thumbnail" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                                
                                                <p class="card-text">{!! $newborn->body !!}</p>
                                            </div>
                                            <div class="card-footer">
                                                <div class="d-flex justify-content-between" dir="ltr">
                                                    <p class="card-text m-0"><i class="ri-user-2-fill"> </i><small class="text-muted">{{ $newborn->owner->name }}</small></p>
                                                    @if($newborn->owner_id == auth()->user()->id)
                                                        @can('newborns.update')
                                                        
                                                            <a href="{{ route('newborns.edit', $newborn) }}" class="card-text m-0"><i class="ri-edit-2-fill"> </i><small class="text-muted"></small></p>
                                                        @endcan
                                                        @can('newborns.delete')
                                                        <form action="{{ route('newborns.destroy', $newborn) }}" method="POST">
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