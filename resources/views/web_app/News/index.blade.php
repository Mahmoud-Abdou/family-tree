@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-newspaper-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('news.index')],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">
            <div class="col-lg-12">
                    @include('partials.messages')

                    <div class="card iq-mb-3">
                        <div class="card-header">
                        <div class="col-md-4">
                            <div class="form-group my-auto">
                                <select class="form-control" name="status" id="status-filter" onchange="ChangeCategory(this.value)" value="2">
                                    <option disabled="">حدد النوع</option>
                                    <option value="-1" {{ Request::get("category_id") == null ? 'selected' : '' }}>الكل</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{ Request::get("category_id") == $category->id ? 'selected' : '' }}>{{ $category->name_ar }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </div>
                        <div class="card-body p-0">
                        @if($news->count() > 0)

                            @foreach($news as $row)
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
                        @else
                        <div class="col-sm-8">
                                    <div class="card iq-mb-3">
                                        <div class="card-body">

                                            
                                            <p class="card-text">لا توجد بيانات</p>
                                        </div>
                                        
                                    </div>
                                </div>
                        @endif
               

                            <div class="d-flex justify-content-around">{{ $news->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark">{{ $news->count() }}</span>
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
            window.location = "news";
        }
        else{
            window.location = "news?category_id=" + value;
        }
    }
</script>
@endsection
