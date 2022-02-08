@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-marriagespaper-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('marriages.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
            <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto"><i class="ri-user-smile-line"> </i> {{ $menuTitle }}</h5>
                            @can('marriages.create')
                                <a href="{{ route('marriages.create') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-add-fill"> </i>اضافة</a>
                            @endcan
                        </div>
                        <div class="card-body p-0">
                        @if($marriages->count() > 0)

                            @foreach($marriages as $row)
                                <div class="col-sm-8">
                                    <div class="card iq-mb-3">
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $row->title }}</h4>
                                            <hr />
                                            <p class="card-text">{!! $row->body !!}</p>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between" dir="ltr">
                                                <p class="card-text m-0"><i class="ri-user-2-fill"> </i><small class="text-muted">{{ $row->owner->name }}</small></p>
                                                @if($row->owner_id == auth()->user()->id)
                                                    @can('marriages.update')
                                                    
                                                        <a href="{{ route('marriages.edit', $row) }}" class="card-text m-0"><i class="ri-edit-2-fill"> </i><small class="text-muted"></small></p>
                                                    @endcan
                                                    @can('marriages.delete')
                                                    <form action="{{ route('marriages.destroy', $row) }}" method="POST">
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
                        @else
                        <div class="col-sm-8">
                                    <div class="card iq-mb-3">
                                        <div class="card-body">

                                            
                                            <p class="card-text">لا توجد بيانات</p>
                                        </div>
                                        
                                    </div>
                                </div>
                        @endif
               

                            <div class="d-flex justify-content-around">{{ $marriages->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $marriages->count() }}</span>
                        </div>
                    </div>
                </div>

            <div class="col-md-2">
                
            </div>
      

            </div>
        </div>
    </div>
@endsection
@section('add-scripts')

<script>
    function submit_form(form){
        if(confirm('Are you sure?')){
            $(form).parent().submit()
        }
    }

    function ChangeCategory(value){
        if(value == -1){
            window.location = "marriages";
        }
        else{
            window.location = "marriages?category_id=" + value;
        }
    }
</script>
@endsection
