{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')

    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">HTML Table
                    <div class="text-muted pt-2 font-size-sm">Datatable initialized from HTML table</div>
                </h3>
            </div>
        </div>

        <div class="card-body">

            <!--begin::Search Form-->
            <form method="GET" id="search-form">
                @csrf
            <div class="mt-2 mb-5 mt-lg-5 mb-lg-10">
                <div class="row align-items-center">
                    <div class="col-lg-9 col-xl-8">
                        <div class="row align-items-center">
                            <div class="col-md-4 my-2 my-md-0">
                                <input type="button" value="<< Previous" id="subs" class="btn btn-default pull-left" style="margin-right: 2%" />&nbsp;
                                <input type="hidden" style="width: 410px;text-align: center; margin: 0px;" class="onlyNumber form-control pull-left" id="noOfRoom" value="1" name="noOfRoom" />&nbsp;
                                <input type="button" value="Next >>" id="adds" class="btn btn-default" />
                            </div>

                            <div class="col-md-4 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Select Input Game:</label>
                                    <select class="form-control" name="game" id="kt_datatable_search_status">
                                        @foreach($games as $k=> $gmName)
                                            <option value="{{ $k }}" {{request()->query('game') == $k ? 'selected' : ''}}>{{ $gmName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 my-2 my-md-0">
                                <div class="d-flex align-items-center">
                                    <label class="mr-3 mb-0 d-none d-md-block">Size:</label>
                                    <select class="form-control" name="size" id="kt_datatable_search_type">
                                        @foreach($availableSizes as $k => $szName)
                                            <option value="{{ $k }}" {{ $k == $pageSize ? 'selected' : '' }}>{{ $szName }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xl-4 mt-5 mt-lg-0">
                        {{--<a href="#" class="btn btn-light-primary px-6 font-weight-bold">
                            Search
                        </a>--}}
                        <button type="submit" class="btn btn-light-primary px-6 font-weight-bold">Search</button>
                    </div>
                </div>
            </div>
            </form>
            <!--end::Search Form-->

{{--            <table class="table table-bordered table-hover" id="kt_datatable">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th>S/N</th>--}}
{{--                    <th>UserID</th>--}}
{{--                    <th>Dislay Name</th>--}}
{{--                    <th>Email</th>--}}
{{--                    <th>Best Score</th>--}}
{{--                    <th>Opt In</th>--}}
{{--                    <th>Time Stamp</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                @foreach($players as $i => $pl)--}}
{{--                    <tr>--}}
{{--                        <td>{{ ($i + 1 + $pageDiff ) }}</td>--}}
{{--                        <td>{{ isset($pl['userid']) ?  $pl['userid'] : '-'}}</td>--}}
{{--                        <td>{{ isset($pl['displayName']) ?  $pl['displayName'] : '-'}}</td>--}}
{{--                        <td> {{ isset($pl['email']) ? $pl['email'] : '-' }} </td>--}}
{{--                        <td> {{ isset($pl['bestScore']) ? $pl['bestScore']  : ''}} </td>--}}
{{--                        <td> {{ isset($pl['optin']) ? $pl['optin'] : '-' }} </td>--}}
{{--                       <td> {{ isset($pl['timestamp']) ?  date('d M, Y; H:i a', ($pl['timestamp'] /1000) ) : '-'}} </td>--}}
{{--                        <td nowrap></td>--}}
{{--                    </tr>--}}
{{--                @endforeach--}}


{{--                </tbody>--}}
{{--            </table>--}}


            <table class="table table-bordered data-table">
                <thead>
                <tr>
                    <th>Sr#</th>
                    <th>UserID</th>
                    <th>Display Name</th>
                    <th>Email</th>
                    <th>Opt In</th>
                    <th>Time Stamp</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>

    </div>

@endsection

{{-- Styles Section --}}
@section('styles')
{{--    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>--}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
@endsection


{{-- Scripts Section --}}
@section('scripts')
    {{-- vendors --}}
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>

     page scripts
    <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>

    <script>

        var offset = $('#noOfRoom').val();

        $(function () {
            var size = $('#kt_datatable_search_type').val();
            var game = $('#kt_datatable_search_status').val();
            var otable = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    data: function (d) {
                        d.size = size;
                        d.game = game;
                        d.offset = offset;
                    },
                    url: "{{ route('player') }}"
                },
                columns: [
                    {data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false},
                    {data: 'userid', name: 'userid', searchable: true},
                    {data: 'displayName', name: 'displayName', searchable: true},
                    {data: 'email', name: 'email', searchable: true},
                    {data: 'optin', name: 'optin', searchable: true},
                    {data: 'timestamp', name: 'timestamp', searchable: true}
                ]
            });
            $('#search-form').on('submit', function(e) {
                otable.draw();
                e.preventDefault();
            });

            $('#adds').click(function add() {
                var $rooms = $("#noOfRoom");
                var a = $rooms.val();

                a++;
                $("#subs").prop("disabled", !a);
                $rooms.val(a);
                offset = a;
                otable.draw();
                e.preventDefault();
                alert(a);
            });

            $('#subs').click(function subst() {
                var $rooms = $("#noOfRoom");
                var b = $rooms.val();
                if (b >= 1) {
                    b--;
                    $rooms.val(b);
                    offset = b;
                }
                else {
                    $("#subs").prop("disabled", true);
                }
                otable.draw();
                e.preventDefault();
            });

        });

    </script>
@endsection
