@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-home-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('home')],]])
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
                            <select name="category_id" id="category_id" onchange="ChangeCategory(this.value)" class=" rounded-pill float-right" >
                                <option selected="selected" disabled>اختر النوع</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{ $category->name_ar }}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="card-body p-0">

                            <div class="table-responsive">
                                <table class="table m-0 px-2" id="media_table">
                                    <thead>
                                    <tr>
                                        <th scope="col">العنوان</th>
                                        <th scope="col">الصورة</th>
                                        <th scope="col">النوع</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($media->count() > 0)
                                        @foreach($media as $row_media)
                                            <tr>
                                                <td>{{ $row_media->title }}</td>
                                                <td>
                                                    <img src="{{ $row_media->file }}" alt="" style="height: 100px;width: 100px;">
                                                </td>
                                                <td>{{ $row_media->category->name_ar }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center p-5"> لا توجد بيانات </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-around">{{ $media->links() }}</div>
                        </div>

                        <div class="card-footer text-muted">
                            مجموع عدد السجلات
                            <span class="badge badge-pill border border-dark text-dark" id = "total_count">{{ $media->count() }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

<script>
    function ChangeCategory(value){
        $.ajax({
            url: 'get_media/' + value,
            contentType: "application/json",
            dataType: 'json',
            success: function(result){
                console.log(result);
                $('#media_table tbody').empty();
                $('#total_count').html(result.length)
                if(result.length == 0){
                    $('#media_table tbody').append(`
                        <tr>
                            <td colspan="7" class="text-center"> لا توجد بيانات </td>
                        </tr>
                    `)
                }
                else{
                    result.forEach(function(row) {
                        $('#media_table tbody').append(`
                            <tr>
                                <td>
                                    <img src="${row.file}" alt="" style="height: 100px;width: 100px;">
                                </td>
                                <td>${row.category}</td>

                            </tr>
                        `)
                    })
                }
            }
        })
    }
</script>
