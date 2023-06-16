@extends('layouts.layout')

@section('pagename','Attendance List')

@section('script')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
    <!-- Mapbox -->
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css' rel='stylesheet' />
    <style>
        .example-modal .modal {
            position: relative;
            top: auto;
            bottom: auto;
            right: auto;
            left: auto;
            display: block;
            z-index: 1;
        }

        .example-modal .modal {
            background: transparent !important;
        }

        #map { 
            height: 450px; 
            width: 900px; 
        }
    </style>
@endsection

@section('main-content')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <div class="col-md-11">
                            <div class="row">
                                <h3 class="box-title">Employee Attendance</h3>
                            </div>

                        </div>
                        <div class="col-md-offset-11">
                            <a href="{{ route('attendance_list') }}">
                                <button class="btn btn-block btn-primary pull-right">Reset</button>
                            </a>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        @if(Session::has('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                            </div>
                        @endif
                        @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h4><i class="icon fa fa-ban"></i>{{ session('error') }}</h4>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-10">
                                <form class="form" method="post" action="{{ route('employee_attendance_list') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="col-md-3">
                                                <label for="designation" class="col-sm-2 control-label">Designation Name</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select id='designation' name="designation" class="form-control select2" style="width: 100%;">
                                                    <option>---Select a designation---</option>
                                                    <option value="ALL">ALL</option>
                                                    @isset($designations)
                                                        @foreach($designations as $designation)
                                                            <option value="{{ $designation->id }}">{{ $designation->designation }}</option>
                                                        @endforeach
                                                    @endisset
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="col-md-3">
                                                    <label for="employee_name" class="col-md-2 control-label">Employee Name</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <select id='employee_id'name="employee_id" class="form-control select2" style="width: 100%;">
                                                        <option>---Select an employee---</option>
                                                        @isset($employees)
                                                            @foreach($employees as $employee)
                                                                <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                            @endforeach
                                                        @endisset
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-3">
                                                    <label>Date range:</label>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" name="daterange" class="form-control pull-right" id="reservation">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="row">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-2">
                                @isset($request)
                                    @if($attendance !=null)
                                        <input type="hidden"  id="id" name="employee_id" value="{{ $request->employee_id }}"/>
                                        <input type="hidden"  id="date" name="daterange" value="{{ $request->daterange }}"/>
                                    @endif
                                @endisset
                            </div>
                        </div>


                            @isset($attendance)
                            <div class="col-md-12 table-responsive" style="overflow: auto; max-height: 500px">
                                @if(!$attendance->isEmpty())
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Profile Image</th>
                                                    {{-- <th>Out Image</th> --}}
                                                    <th>User Name</th>
                                                    <th>Date Time</th>
                                                    <th>Address</th>
                                                    <th>Category</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($attendance as $a)
                                                    <tr>
                                                        <td> 
                                                            <img src="{{ asset('uploads/users/'.$a->in_profile_image) }}" class="img-responsive" data-toggle="modal" data-target="#modal-default" data-image="{{ asset('uploads/users/'.$a->in_profile_image) }}" style="height: 50px; width: 120px;">
                                                        </td>
                                                        {{-- <td> 
                                                            <img src="{{ asset('uploads/users/'.$a->out_profile_image) }}" class="img-responsive" data-toggle="modal" data-target="#modal-default" data-image="{{ asset('uploads/users/'.$a->out_profile_image) }}" style="height: 50px; width: 120px;">
                                                        </td> --}}
                                                        <td>
                                                            {{ $a->employee->first_name }} {{ $a->employee->last_name }}
                                                        </td>
                                                        <td>
                                                            {{(new DateTime($a->created_at))->setTimezone(new DateTimeZone('Asia/Kolkata'))->format('d/m/Y')}}, {{(new DateTime($a->created_at))->setTimezone(new DateTimeZone('Asia/Kolkata'))->format('H:i')}}
                                                        </td>
                                                        <td>
                                                            {{ $a->address }}
                                                        </td>
                                                        <td>
                                                            {{ $a->category->category_name }}
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-info btn-xs" href="{{ route('attendance.download', $a->id) }}"><i class="fa fa-fw fa-download"></i></a>
                                                            @if ($a->attendance_given == 'SIGNED OUT')
                                                                <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal-lg" data-id="{{$a->id}}"><i class="fa fa-globe"></i></a>
                                                            @endif
                                                        </td>
                                                        <input type="hidden" id="lat_long_{{$a->id}}" value="{{$a->lat_long_history}}">
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                @else
                                    <tr>
                                        No data available
                                    </tr>
                                @endif
                            </div>
                            @endisset
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer clearfix">
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
@isset($attendance)
    @if(!$attendance->isEmpty())
        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Image</h4>
                    </div>
                    <div class="modal-body">

                        <img src="" class="img-responsive">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="modal-lg">
            <div class="modal-dialog modal-dialog-scrollable modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Map View</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="map">
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    @endif
@endisset
@section('js')
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js'></script>
    <script>
        $('#employee_id').select2();
        $('#employee_id').val($("#id").val()).trigger('change');
        $('#reservation').val($('#date').val());
        $('#designation').select2();
        $('#reservation').daterangepicker();
        $('#designation').on("select2:select", function (event) {
            var designation_id = $("#designation option:selected").val();
            $.ajax({
                url: '{{ route('search_employee_according_designation') }}',
                data:  {
                    _token: "{{ csrf_token() }}",
                    designation_id,
                },
                type: 'POST',
                cache: false,
                dataType: "json",
                success: function (result) {
                    var employee = '';
                    if(result.status === 'success') {
                        var data = result.data;
                        for (let i=0;i<data.length;i++) {
                            employee += '<option value=' + data[i].id + '>' + data[i].first_name + " " + data[i].last_name + '</option>';
                        }
                    }
                    $('#employee_id').html(employee);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });

        @isset($attendance)
            @if(!$attendance->isEmpty())
                $('#modal-default').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var recipient = button.data('image') // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var modal = $(this)
                    modal.find('.modal-body img').attr('src',recipient)
                })
            @endif
        @endisset

        $('#modal-lg').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var id = button.data('id'); // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var latLong = JSON.parse(($("#lat_long_"+id).val()));
                    mapView(latLong);
                })

        function mapView(latLongArr){
            var arrLength = latLongArr.length;
            mapboxgl.accessToken = '{{ env('MAPBOX_ACCESS_TOKEN') }}';
            const map = new mapboxgl.Map({
                        container: 'map', // container ID
                        style: 'mapbox://styles/mapbox/streets-v12', // style URL
                        center: [latLongArr[0][0], latLongArr[0][1]], // starting position [lng, lat]
                        zoom: 11, // starting zoom
                    });
            
            map.on("render", () => map.resize());

            map.on('load', () => {
                map.addSource('route', {
                    'type': 'geojson',
                    'data': {
                        'type': 'Feature',
                        'properties': {},
                        'geometry': {
                            'type': 'LineString',
                            'coordinates': latLongArr
                        }
                    }
                });
                map.addLayer({
                    'id': 'route',
                    'type': 'line',
                    'source': 'route',
                    'layout': {
                        'line-join': 'round',
                        'line-cap': 'round'
                    },
                    'paint': {
                        'line-color': '#888',
                        'line-width': 4
                    }
                });
            });
            const marker = new mapboxgl.Marker({
                                    color: "#00FF00"
                                })
                                .setLngLat([latLongArr[0][0], latLongArr[0][1]])
                                .addTo(map);
            
            const marker1 = new mapboxgl.Marker({
                                    color: "#FF0000"
                                })
                                .setLngLat([latLongArr[--arrLength][0],latLongArr[arrLength][1]])
                                .addTo(map);

            map.addControl(new mapboxgl.FullscreenControl());
            map.addControl(new mapboxgl.NavigationControl());
        }
    </script>
@endsection