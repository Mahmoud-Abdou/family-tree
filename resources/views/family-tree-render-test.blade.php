@extends('layouts.master')

@section('page-title', $pageTitle)

@section('add-styles')
    <style>
        table {
            border-collapse: inherit !important;
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
                    <div class="card iq-mb-3">
                        <div class="card-header">
                            <h5 class="float-left my-auto">
                                <i class="ri-group-2-line"> </i>
                                {{ $menuTitle }}
                            </h5>

                            <a href="{{ route('family.tree') }}" class="btn btn-primary rounded-pill float-right"><i class="ri-group-2-line"> </i>النسخة المطبوعة</a>
                        </div>
                        <div class="card-body">

                            <div id="family-tree_div"></div>

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
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {packages:["orgchart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('string', 'Manager');
            data.addColumn('string', 'ToolTip');

            // For each orgchart box, provide the name, manager, and tooltip to show.
            data.addRows([

                ['Alice', 'Mike', ''],
                ['Bob', 'Jim', 'Bob Sponge'],
                ['Carol', 'Bob', ''],
                ['Loai', 'Bob', ''],
                ['ssss', 'Bob', ''],
                ['eeeee', 'ssss', ''],
                ['ddd', 'Alice', '123'],

            ]);

            data.addRows([
                ['123', 'ddd', ''],
            ]);

            data.setRowProperty(2, 'selectedStyle', 'background-color:#00FF00');

            data.setRowProperty(1, 'style', 'border: 1px solid green');

            // Create the chart.
            var chart = new google.visualization.OrgChart(document.getElementById('family-tree_div'));
            // Draw the chart, setting the allowHtml option to true for the tooltips.
            chart.draw(data,
                {'allowHtml': true, allowCollapse: true, size: 'medium', nodeClass: 'text-secondary border'}
            );
        }
    </script>
@endsection
