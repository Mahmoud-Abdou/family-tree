
@extends('layouts.master')
@section('page-title', $pageTitle)

@section('add-styles')
    <style>
        #familyImg {
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            display: block;
            margin-left: auto;
            margin-right: auto
        }

        #familyImg:hover {opacity: 0.7;}

        /* The Modal (background) */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 99999; /* Sit on top */
            padding-top: 100px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
        }

        /* Modal Content (image) */
        .modal-content {
            margin: auto;
            display: block;
            width: 75%;
        //max-width: 75%;
        }

        /* Caption of Modal Image */
        #caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #ccc;
            padding: 10px 0;
            height: 150px;
        }

        @-webkit-keyframes zoom {
            from {-webkit-transform:scale(1)}
            to {-webkit-transform:scale(2)}
        }
        @keyframes zoom {
            from {transform:scale(0.4)}
            to {transform:scale(1)}
        }

        @-webkit-keyframes zoom-out {
            from {transform:scale(1)}
            to {transform:scale(0)}
        }
        @keyframes zoom-out {
            from {transform:scale(1)}
            to {transform:scale(0)}
        }

        /* Add Animation */
        .modal-content, #caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
        }

        .out {
            animation-name: zoom-out;
            animation-duration: 0.6s;
        }

        /* 100% Image Width on Smaller Screens */
        @media only screen and (max-width: 700px){
            .modal-content {
                width: 100%;
            }
        }
    </style>
@endsection

@section('breadcrumb')
    @include('partials.breadcrumb', ['pageTitle' => '<i class="ri-group-2-line"> </i>'.$menuTitle, 'slots' => [['title' => $menuTitle, 'link' => route('home')],]])
@endsection

@section('content')

    <div id="content-page" class="content-page">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card iq-mb-3 shadow-sm">
                        <div class="card-header">
                            <h5 class="float-left my-auto">
                                <i class="ri-group-2-line"> </i>
                                {{ $menuTitle }}
                            </h5>

                            <a href="{{ route('family.tree.render') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-group-2-line"> </i>النسخة الالكترونية</a>
                        </div>
                        <div class="card-body p-0 m-0">
                        <img id="familyImg" src="{{ $content }}"
                        data-zoom-image="{{ $content }}"
                        class="img-fluid max-width"/>
                            <!-- <img id="familyImg" src="{{ $content }}"  data-zoom-image="{{ $content }}" class="img-fluid max-width" alt="family tree"> -->
                        </div>
                        <div class="card-footer text-muted">
                            <span>آخر تعديل في : </span>
                            <span dir="ltr">{{ $time }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="imageModal" class="modal">
        <!-- <img class="modal-content" id="img01"
            src="{{ $content }}"
                        data-zoom-image="{{ $content }}"> -->
                        <!-- <img id="zoom_mw" src="{{ $content }}"
                        data-zoom-image="{{ $content }}"
                        class="img-fluid max-width"/> -->
{{--        <div id="caption"></div>--}}
    </div>
@endsection


<script>
    
</script>
@section('add-scripts')
<script type="text/javascript" src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.6/src/jquery.ez-plus.js"></script>

    <script>
        var ez_plus_exist = 1;
        // Get the modal
        var modal = document.getElementById('imageModal');
        // Get the image and insert it inside the modal - use its "alt" text as a caption
        var img = document.getElementById('familyImg');
        // var modalImg = document.getElementById("img01");
        // var captionText = document.getElementById("caption");
        img.onclick = function(){
            ez_plus_exist = !ez_plus_exist;
            if(ez_plus_exist == 1){
                $('.zoomContainer').remove();
            }
            else{
                $('#familyImg').ezPlus({
                    scrollZoom: true,
                    zoomType: 'inner',
                    cursor: 'crosshair',
                    // easing: true,
                });
            }
            // alert(ez_plus_exist)
            // modal.style.display = "block";
            
            // modalImg.src = this.src;
            // modalImg.alt = this.alt;
            // captionText.innerHTML = this.alt;
        }

        // When the user clicks on <span> (x), close the modal
        // modal.onclick = function() {
        //     img01.className += " out";
        //     setTimeout(function() {
        //         modal.style.display = "none";
        //         img01.className = "modal-content";
        //     }, 400);

        // }

    </script>
@endsection
