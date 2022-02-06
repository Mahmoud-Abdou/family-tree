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
            background-color: rgba(38, 38, 38, 0.8);
            height: 50px;
            width: 2px;
            margin: 0 auto;
        }

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
                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto">
                                <i class="ri-group-2-line"> </i>
                                {{ $menuTitle }}
                            </h5>

                            <a href="{{ route('family.tree') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-group-2-line"> </i>النسخة المطبوعة</a>
                        </div>
                        <div class="card-body text-center">

                            <div dir="ltr" style="width:100%; min-height:600px;" id="family-tree-div"></div>

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
    <script type="text/javascript" src="{{ secure_asset('js/jquery.orgchart.min.js') }}"></script>

    <script type="text/javascript">
        $(function() {

            var datascource = {
                'name': 'Lao Lao',
                'title': 'general manager',
                'children': [
                    { 'name': 'Bo Miao', 'title': 'department manager', 'className': 'middle-level',
                        'children': [
                            { 'name': 'Li Xin', 'title': 'senior engineer',
                                'children': [
                                    { 'name': 'Fei Fei', 'title': 'engineer' },
                                    { 'name': 'Xuan Xuan', 'title': 'engineer' }
                                ]
                            }
                        ]
                    },
                    { 'name': 'Su Miao', 'title': 'department manager', 'linkNode': true, 'collapsed': true,
                        'children': [
                            { 'name': 'Hei Hei', 'title': 'senior engineer',
                                'children': [
                                    { 'name': 'Dan Dan', 'title': 'engineer' },
                                    { 'name': 'Zai Zai', 'title': 'engineer' }
                                ]
                            }
                        ]
                    },
                    { 'name': 'Su Miao', 'title': 'department manager', 'linkNode': true, 'office': 'test',
                        'children': [
                            { 'name': 'Hei Hei', 'title': 'senior engineer',
                                'children': [
                                    { 'name': 'Dan Dan', 'title': 'engineer' },
                                    { 'name': 'Zai Zai', 'title': 'engineer' },
                                    { 'name': 'Su Miao', 'title': 'department manager', 'linkNode': true,
                                        'children': [
                                            { 'name': 'Hei Hei', 'title': 'senior engineer',
                                                'children': [
                                                    { 'name': 'Dan Dan', 'title': 'engineer' },
                                                    { 'name': 'Zai Zai', 'title': 'engineer' },
                                                    { 'name': 'Su Miao', 'title': 'department manager',
                                                        'children': [
                                                            { 'name': 'Pang Pang', 'title': 'senior engineer' },
                                                            { 'name': 'Hei Hei', 'title': 'senior engineer', 'linkNode': true, 'collapsed': true,
                                                                'children': [
                                                                    { 'name': 'Xiang Xiang', 'title': 'UE engineer', 'className': 'slide-up' },
                                                                    { 'name': 'Dan Dan', 'title': 'engineer', 'className': 'slide-up' },
                                                                    { 'name': 'Zai Zai', 'title': 'engineer', 'className': 'slide-up' }
                                                                ]
                                                            }
                                                        ]
                                                    }
                                                ]
                                            }
                                        ]
                                    }
                                ]
                            }
                        ]
                    }
                ]
            };

            var nodeTemplate = function(data) {
                return `
<!--                    <span class="office">${data.office}</span>-->
                    <div class="title">${data.name}</div>
                    <div class="content">${data.title}</div>
                `;
            };

            var oc = $('#family-tree-div').orgchart({
                // 'data' : datascource,
                'nodeContent': 'title',
                'visibleLevel': 4,
                'nodeTemplate': nodeTemplate,
                'pan': true,
                'zoom': true,
                'exportButton': true,
                'exportFileextension': 'pdf',
                'exportFilename': 'MyOrgChart'
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

        });
    </script>
@endsection
