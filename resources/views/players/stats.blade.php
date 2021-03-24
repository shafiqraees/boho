{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">Statistics
                </h3>
            </div>
        </div>

        <div class="card-body">

            <!--begin::Search Form-->
            <div class="row">
                <div class="col-lg-4 col-xl-4 col-md-4 mb-4">
                    <form method="GET" action="/stats">

                        <div class="form-group">
                            <label for="inputGame">Select Input Game</label>
                            <select id="inputGame" class="form-control" name="game">
                                @foreach($games as $k=> $gmName)
                                    <option value="{{ $k }}" {{request()->query('game') == $k ? 'selected' : ''}}>{{ $gmName }}</option>
                                @endforeach
                            </select>
                            @error('game')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="inputEvent">Event Type</label>

                            <select id="inputEvent" class="form-control" name="event">
                                @foreach($availableEventTypes as $k => $evName)
                                    <option value="{{ $k }}"
                                            id = {{ 'eventType-' . $k }}
                                        {{ $k == request()->query('event') ? 'selected' : '' }}>

                                        {{ $evName }}</option>
                                @endforeach
                            </select>

                            @error('eventType')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>



                        <div class="form-group">
                            <label for="inputFilter">Event Filter Type</label>

                            <select id="inputFiletr" class="form-control" name="filtertype">
                                <option value="">--</option>
                                @foreach($availableFilterTypes as $k => $evName)
                                    <option value="{{ $k }}"
                                            {{ $k == request()->query('filtertype') ? 'selected' : '' }}
                                            id = {{ 'eventFilterType-' . $k }}
                                    >{{ $evName }}</option>
                                @endforeach
                            </select>

                            @error('filtertype')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="inputFilterValue">Event Filter Value</label>
                            <input id="inputFilterValue" value= "{{ request()->query('filtervalue') }}" class="form-control" name="filtervalue">
                            @error('filtervalue')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="inputStartDate">Start Date & Time </label>
                            <div class="input-group">
                                <input id="inputStartDate" value= "{{ $startdate}}" class="form-control" name="startdate" type="date">
                                <div class="input-group-prepend">
                                    <input id="inputStartTime" value= "{{ $starttime }}" class="form-control" name="starttime" type="time">
                                </div>
                            </div>
                            @error('startdate')
                            <div class="text-danger">'Hello'</div>
                            @enderror
                            @error('starttime')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="inputEndTime">End Date & Time </label>
                            <div class="input-group">
                                <input id="inputEndTime" value= "{{ $enddate}}" class="form-control" name="enddate" type="date">
                                <div class="input-group-prepend">
                                    <input id="inputEndTime" value= "{{ $endtime }}" class="form-control" name="endtime" type="time">
                                </div>
                            </div>
                            @error('enddate')
                            <div class="text-danger">'Hello'</div>
                            @enderror
                            @error('endtime')
                            <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" >
                            <label for=""> &nbsp; </label>
                            <input type="submit" class="form-control btn btn-primary" value="Search">
                        </div>
                    </form>

                </div>
                <div class="col-lg-1"></div>
                <div class="col-lg-7 col-xl-7 col-md-7">
                    <div class="col-lg-10 col-md-10 col-sm-12">
                        <div class="card mb-4 mt-2">

                            <div class="card-header">
                                {{--<i class="fas fa-chart-bar mr-1"></i>
                                Stats Bar Chart--}}

                                <a href="{{request()->fullUrlWithQuery(['CSV' => 'YES']) }}" class="btn btn-primary btn-sm float-right" target="_blank" >
                                    Download CSV
                                </a>
                            </div>

                            <div class="card-body">
                                <div id="chartdiv"></div>
                                {{--<canvas id="myPieChart" width="70%" height="75"></canvas>--}}
                            </div>
                            <div class="card-footer small text-muted"></div>


                        </div>

                    </div>

                </div>

            </div>

            <!--end::Search Form-->
            {{--<div class="card card-custom gutter-b">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Pie Chart 2</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div id="kt_gchart_4" style="height:500px;"><div style="position: relative;"><div style="position: relative; width: 446px; height: 500px;" dir="ltr"><div style="position: absolute; left: 0px; top: 0px; width: 100%; height: 100%;" aria-label="A chart."><svg width="446" height="500" style="overflow: hidden;" aria-label="A chart."><defs id="_ABSTRACT_RENDERER_ID_5"><filter id="_ABSTRACT_RENDERER_ID_6"><feGaussianBlur in="SourceAlpha" stdDeviation="2"></feGaussianBlur><feOffset dx="1" dy="1"></feOffset><feComponentTransfer><feFuncA type="linear" slope="0.1"></feFuncA></feComponentTransfer><feMerge><feMergeNode></feMergeNode><feMergeNode in="SourceGraphic"></feMergeNode></feMerge></filter></defs><rect x="0" y="0" width="446" height="500" stroke="none" stroke-width="0" fill="#ffffff"></rect><g><rect x="275" y="96" width="86" height="88" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g column-id="Work"><rect x="275" y="96" width="86" height="12" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g><text text-anchor="start" x="292" y="106.2" font-family="Arial" font-size="12" stroke="none" stroke-width="0" fill="#222222">Work</text></g><circle cx="281" cy="102" r="6" stroke="none" stroke-width="0" fill="#fe3995"></circle></g><g column-id="Eat"><rect x="275" y="115" width="86" height="12" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g><text text-anchor="start" x="292" y="125.2" font-family="Arial" font-size="12" stroke="none" stroke-width="0" fill="#222222">Eat</text></g><circle cx="281" cy="121" r="6" stroke="none" stroke-width="0" fill="#f6aa33"></circle></g><g column-id="Commute"><rect x="275" y="134" width="86" height="12" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g><text text-anchor="start" x="292" y="144.2" font-family="Arial" font-size="12" stroke="none" stroke-width="0" fill="#222222">Commute</text></g><circle cx="281" cy="140" r="6" stroke="none" stroke-width="0" fill="#6e4ff5"></circle></g><g column-id="Watch TV"><rect x="275" y="153" width="86" height="12" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g><text text-anchor="start" x="292" y="163.2" font-family="Arial" font-size="12" stroke="none" stroke-width="0" fill="#222222">Watch TV</text></g><circle cx="281" cy="159" r="6" stroke="none" stroke-width="0" fill="#2abe81"></circle></g><g column-id="Sleep"><rect x="275" y="172" width="86" height="12" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g><text text-anchor="start" x="292" y="182.2" font-family="Arial" font-size="12" stroke="none" stroke-width="0" fill="#222222">Sleep</text></g><circle cx="281" cy="178" r="6" stroke="none" stroke-width="0" fill="#c7d2e7"></circle></g></g><g><path d="M171,217L171,166A85,85,0,0,1,192.99961883371427,333.1036952345708L179.79984753348572,283.8414780938283A34,34,0,0,0,171,217" stroke="#ffffff" stroke-width="1" fill="#fe3995"></path><text text-anchor="start" x="207.80592162956316" y="248.05048978368262" font-family="Arial" font-size="12" stroke="none" stroke-width="0" fill="#ffffff">45.8%</text></g><g><path d="M138.15852190617167,259.7998475334857L88.8963047654292,272.9996188337143A85,85,0,0,1,171,166L171,217A34,34,0,0,0,138.15852190617167,259.7998475334857" stroke="#ffffff" stroke-width="1" fill="#c7d2e7"></path><path d="M85.03260146027293,274.03489501412434A89,89,0,0,1,171,162" stroke="#c7d2e7" stroke-width="2" fill-opacity="1" fill="none"></path><text text-anchor="start" x="109.68667831592705" y="221.58085583880703" font-family="Arial" font-size="12" stroke="none" stroke-width="0" fill="#ffffff">29.2%</text></g><g><path d="M146.9583694396574,275.04163056034264L110.89592359914346,311.10407640085657A85,85,0,0,1,88.8963047654292,272.9996188337143L138.15852190617167,259.7998475334857A34,34,0,0,0,146.9583694396574,275.04163056034264" stroke="#ffffff" stroke-width="1" fill="#2abe81"></path></g><g><path d="M162.20015246651428,283.8414780938283L149.00038116628573,333.1036952345708A85,85,0,0,1,110.89592359914346,311.10407640085657L146.9583694396574,275.04163056034264A34,34,0,0,0,162.20015246651428,283.8414780938283" stroke="#ffffff" stroke-width="1" fill="#6e4ff5"></path></g><g><path d="M179.79984753348572,283.8414780938283L192.99961883371427,333.1036952345708A85,85,0,0,1,149.00038116628573,333.1036952345708L162.20015246651428,283.8414780938283A34,34,0,0,0,179.79984753348572,283.8414780938283" stroke="#ffffff" stroke-width="1" fill="#f6aa33"></path></g><g></g></svg><div aria-label="A tabular representation of the data in the chart." style="position: absolute; left: -10000px; top: auto; width: 1px; height: 1px; overflow: hidden;"><table><thead><tr><th>Task</th><th>Hours per Day</th></tr></thead><tbody><tr><td>Work</td><td>11</td></tr><tr><td>Eat</td><td>2</td></tr><tr><td>Commute</td><td>2</td></tr><tr><td>Watch TV</td><td>2</td></tr><tr><td>Sleep</td><td>7</td></tr></tbody></table></div></div></div><div style="display: none; position: absolute; top: 510px; left: 456px; white-space: nowrap; font-family: Arial; font-size: 12px;" aria-hidden="true">Commute</div><div></div></div></div>
                </div>
            </div>--}}
        </div>

    </div>

@endsection

{{-- Styles Section --}}
@section('styles')

    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }
    </style>

    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection


{{-- Scripts Section  \features\charts--}}
@section('scripts')
    {{--<script src="//www.google.com/jsapi"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    {{--<script src="{{ asset('js/pages/features/charts/google-charts.js') }}" type="text/javascript"></script>--}}
    <script src="https://www.amcharts.com/lib/4/core.js"></script>
    <script src="https://www.amcharts.com/lib/4/charts.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
    <script>

        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer");

            chart.options.axisY = { prefix: "", suffix: "" };
            chart.options.title = { text: "" };

            var series1 = { //dataSeries - first quarter
                type: "column",
                name: "First Quarter",
                showInLegend: true
            };

            chart.options.data = [];
            chart.options.data.push(series1);
            // chart.options.data.push(series2);
            // chart.options.data.push(series3);


            series1.dataPoints = [
                { label: "Total Users", y: {{ isset($data['totalusers']) ? $data['totalusers'] : 0 }} },
                { label: "Total Events", y: {{ isset($data['totalevents']) ? $data['totalevents'] : 0 }} },
                { label: "Best Score", y: {{ isset($data['bestScore']) ? $data['bestScore'] : 0 }} },
                { label: "Session Time", y: {{ isset($data['sessionTime']) ? $data['sessionTime'] : 0 }} },
                { label: "Score", y: {{ isset($data['score']) ? $data['score'] : 0 }} }
            ];

            // series2.dataPoints = [
            //     { label: "banana", y: 63 },
            //     { label: "orange", y: 73 },
            //     { label: "apple", y: 88 },
            //     { label: "mango", y: 77 },
            //     { label: "grape", y: 60 }
            // ];
            //
            // series3.dataPoints = [
            //     { label: "banana", y: 45 },
            //     { label: "orange", y: 73 },
            //     { label: "apple", y: 88 },
            //     { label: "mango", y: 77 },
            //     { label: "grape", y: 60 }
            // ];

            chart.render();
        }
        /*var demoPieCharts = function() {
            var data = google.visualization.arrayToDataTable([
                ['Task', 'Hours per Day'],
                ['Work', 11],
                ['Eat', 2],
                ['Commute', 2],
                ['Watch TV', 2],
                ['Sleep', 7]
            ]);

            var options = {
                title: 'My Daily Activities',
                colors: ['#fe3995', '#f6aa33', '#6e4ff5', '#2abe81', '#c7d2e7', '#593ae1']
            };

            var chart = new google.visualization.PieChart(document.getElementById('kt_gchart_3'));
            chart.draw(data, options);

            var options = {
                pieHole: 0.4,
                colors: ['#fe3995', '#f6aa33', '#6e4ff5', '#2abe81', '#c7d2e7', '#593ae1']
            };

            var chart = new google.visualization.PieChart(document.getElementById('kt_gchart_4'));
            chart.draw(data, options);
        }*/
        /**
         * ---------------------------------------
         * This demo was created using amCharts 4.
         *
         * For more information visit:
         * https://www.amcharts.com/
         *
         * Documentation is available at:
         * https://www.amcharts.com/docs/v4/
         * ---------------------------------------
         */

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv", am4charts.PieChart);

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "litres";
        pieSeries.dataFields.category = "country";

        // Let's cut a hole in our Pie chart the size of 30% the radius
        chart.innerRadius = am4core.percent(30);

        // Put a thick white border around each Slice
        pieSeries.slices.template.stroke = am4core.color("#fff");
        pieSeries.slices.template.strokeWidth = 2;
        pieSeries.slices.template.strokeOpacity = 1;
        pieSeries.slices.template
            // change the cursor on hover to make it apparent the object can be interacted with
            .cursorOverStyle = [
            {
                "property": "cursor",
                "value": "pointer"
            }
        ];

        pieSeries.alignLabels = false;
        pieSeries.labels.template.bent = true;
        pieSeries.labels.template.radius = 3;
        pieSeries.labels.template.padding(0,0,0,0);

        pieSeries.ticks.template.disabled = true;

        // Create a base filter effect (as if it's not there) for the hover to return to
        var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
        shadow.opacity = 0;

        // Create hover state
        var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

        // Slightly shift the shadow and make it more prominent on hover
        var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
        hoverShadow.opacity = 0.7;
        hoverShadow.blur = 5;

        // Add a legend
        chart.legend = new am4charts.Legend();
        chart.legend.position = "right";
        chart.legend.markers.template.children.getIndex(0).cornerRadius(30, 30, 30, 30);
        chart.legend.labels.template.textAlign = "end"
        chart.legend.labels.template.events.on("parentset", function(event){
            event.target.toBack();
        })

        chart.data = [{
            "country": "Total User",
            "litres": {{ isset($data['totalusers']) ? $data['totalusers'] : 0 }}
        }, {
            "country": "Total Events",
            "litres": {{ isset($data['totalevents']) ? $data['totalevents'] : 0 }}
        }, {
            "country": "Best Score",
            "litres": {{ isset($data['bestScore']) ? $data['bestScore'] : 0 }}
        }];
    </script>

    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


@endsection
