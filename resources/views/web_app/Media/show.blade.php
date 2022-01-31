@extends('layouts.master')

@section('page-title', $pageTitle)

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-calendar-event-line"> </i>'.$menuTitle, 'slots' => [['title' => 'المعرض', 'link' => route('media.index')],['title' => $menuTitle, 'link' => null],]])
@endsection

@section('content')
    <div id="content-page" class="content-page">
        <div class="container-fluid">
            <div class="row">

            <div class="row text-center">
                @foreach($media as $row)
                    <div class="col-lg-4">
                        <img src="{{ $row->file }}" class="img-thumbnail" alt="">
                    </div>
                    
                @endforeach
                
            </div>

            </div>
        </div>
    </div>
@endsection
