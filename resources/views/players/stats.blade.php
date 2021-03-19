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
                                <i class="fas fa-chart-bar mr-1"></i>
                                Stats Bar Chart

                                <a href="{{request()->fullUrlWithQuery(['CSV' => 'YES']) }}" class="btn btn-primary btn-sm float-right" target="_blank" >
                                    Download CSV
                                </a>
                            </div>

{{--                            <div class="card-body"><canvas id="myPieChart" width="70%" height="75"></canvas></div>--}}
{{--                            <div class="card-footer small text-muted"></div>--}}
                            <div id="chartContainer" style="height: 300px; width: 100%;">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--end::Search Form-->

        </div>

    </div>

@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection


{{-- Scripts Section --}}
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
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

    </script>

    <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


@endsection
