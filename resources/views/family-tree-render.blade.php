@extends('layouts.master')

@section('page-title', $pageTitle)

@section('add-styles')
    <link rel="stylesheet" href="{{ secure_asset('css/jquery.orgchart.min.css') }}">
    <style type="text/css">
        .orgchart .linkNode {
            box-sizing: border-box;
            display: inline-block;
            position: relative;
            margin: 0;
            text-align: center;
            width: 130px;
        }
        .orgchart .linkNode .linkLine {
            background-color: rgba(38, 38, 38, 0.8) !important;
            height: 50px;
            width: 2px;
            margin: 0 auto;
        }
        .orgchart .hierarchy::before { border-color: rgba(38, 38, 38, 0.8) !important;}
        .orgchart .node::after { background-color: rgba(38, 38, 38, 0.8) !important;}
        .orgchart .node::before { background-color: rgba(38, 38, 38, 0.8) !important;}
        .orgchart { background: #fff; }
        .orgchart td.left, .orgchart td.right, .orgchart td.top { border-color: #aaa; }
        .orgchart td>.down { background-color: #aaa; }
        .orgchart .middle-level .title { background-color: #006699; }
        .orgchart .middle-level .content { border-color: #006699; }
        .orgchart .product-dept .title { background-color: #009933; }
        .orgchart .product-dept .content { border-color: #009933; }
        .orgchart .rd-dept .title { background-color: #993366; }
        .orgchart .rd-dept .content { border-color: #993366; }
        .orgchart .pipeline1 .title { background-color: #996633; }
        .orgchart .pipeline1 .content { border-color: #996633; }
        .orgchart .frontend1 .title { background-color: #cc0066; }
        .orgchart .frontend1 .content { border-color: #cc0066; }
        .orgchart .boy .title { background-color: #006699; }
        .orgchart .boy .content { border-color: #006699; }
        .orgchart .girl .title { background-color: #cc0066; }
        .orgchart .girl .content { border-color: #cc0066; }
        .orgchart .dead .title { background-color: #ffab00; }
        .orgchart .dead .content { border-color: #ffab00; }
        .orgchart .wife-in .title { background-color: #993366; }
        .orgchart .wife-in .content { border-color: #993366; }
        .orgchart .wife-out .title { background-color: #7c0553; }
        .orgchart .wife-out .content { border-color: #7c0553; }
        .orgchart .man-father .title { background-color: #154175; }
        .orgchart .man-father .content { border-color: #154175; }
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

                            <a href="{{ route('family.tree') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-group-2-line"> </i>النسخة المطبوعة</a>
                        </div>
                        <div class="card-body text-center p-0">

                            <div dir="ltr" style="width:100%;" id="family-tree-div"></div>

                        </div>
                        <div class="card-footer text-muted">
                            <span>عدد العائلات : </span>
                            <span class="badge badge-pill border border-dark text-dark">{{ $familiesCount }}</span>
                            &nbsp;
                            <span>عدد الأفراد : </span>
                            <span class="badge badge-pill border border-dark text-dark">{{ $personsCount }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('add-scripts')
    <script type="text/javascript" src="{{ secure_asset('js/html2canvas.min.js') }}"></script>
    <script type="text/javascript" src="{{ secure_asset('js/jquery.orgchart.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {

            $.ajax({
                type: 'GET',
                url: "{{ route('family.tree.render') }}",
                dataType: 'json',
                success: function (response) {
                    renderData(response[0]);
                }
            });

            function renderData(data) {
                var datascource = data;

                var nodeTemplate = function(data) {
                    return `
{{--                        <div class="wife-node">
                            <span class="office">${data.wife}</span>
                        </div>--}}

                    <img src="${data.photo}" class="rounded-circle float-left" style="margin-right: -45px;width: 40px;" alt="">
                    <div class="title"><i class="${data.fatherSymbol} float-right"> </i> ${data.name}</div>
                        <div class="content"> <i class="${data.motherSymbol} float-right"> </i>${data.wife}</div>
                    `;
                };

                var oc = $('#family-tree-div').orgchart({
                    'data' : datascource,
                    'direction': 't2b',
                    'nodeContent': 'title',
                    'visibleLevel': 1, // 999
                    'nodeTitle': 'name',
                    'nodeId': 'id',
                    'nodeTemplate': nodeTemplate,
                    'toggleSiblingsResp': false,
                    'draggable': false,
                    'collapsed': true,
                    'pan': true,
                    'zoom': true,
                    'zoominLimit': 7,
                    'zoomoutLimit': 0.3,
                    'chartClass': '',
                    'className': 'top-level',
                    'parentNodeSymbol': '',
                    // 'exportButton': true,
                    // 'exportFileextension': 'png',
                    // 'exportFilename': 'Export PDF'
                });

                oc.$chartContainer.on('touchmove', function(event) {
                    event.preventDefault();
                });

                $(window).resize(function() {
                    var width = $(window).width();
                    if(width > 576) {
                        oc.init({'verticalLevel': undefined});
                    } else {
                        oc.init({'verticalLevel': 2});
                    }
                });

            }

        });
    </script>
@endsection
