@extends('layouts.layout')

@section('pagename','Report Generation')

@section('script')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.css') }}">
@endsection

@section('main-content')
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">

                    <div class="box-header with-border">
                        <div class="col-md-3">
                            <h3 class="box-title">Attendance Report</h3>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form class="form" method="post" action="{{ route('export_attendance_report') }}">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="col-md-3">
                                            <label for="branch" class="col-sm-2 control-label">Branch</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select id='branch_id' name="branch_id" class="form-control select2" style="width: 100%;">
                                            <option value="all">ALL</option>
                                                @isset($branches)
                                                    @foreach($branches as $branch)
                                                        <option value="{{$branch->id}}">{{$branch->branch_name}}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="col-md-3">
                                            <label for="employee_name" class="col-sm-2 control-label">Employee Name</label>
                                        </div>
                                        <div class="col-md-8">
                                            <select id='employee_id' name="employee_id[]" class="form-control select2" style="width: 100%;" multiple="multiple">
                                                @isset($employees)
                                                    @foreach($employees as $employee)
                                                        <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                                                    @endforeach
                                                @endisset
                                            </select>
                                            <input type="button" id="select_all" name="select_all" value="Select All">
                                            @error('employee_id')
                                                <div class="form-group has-error">
                                                    <span class="help-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="col-md-3">
                                            <label>Daterange:</label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="daterange" class="form-control pull-right" id="reservation" autocomplete="off">
                                            </div>
                                        </div>
                                        @error('daterange')
                                            <div class="form-group has-error">
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <div class="row">
                                            <button type="submit" class="btn btn-primary">Export</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.box-body -->

                    <div class="box-footer clearfix">
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $('#employee_id').select2();
        $('#employee_id').val($('#id').val()).trigger('change');
        $('#reservation').daterangepicker();
        $('#reservation').val($('#date').val());
        $('#select_all').click(function() {
            $('#employee_id option').prop('selected', true);
            $("#employee_id").trigger("change");
        });
        $('#branch_id').on('change',function(){
            let branchId = $('#branch_id').val()
            $.ajax({
                url: '{{ route('get_attendance_report') }}',
                data:  {
                    branchId,
                },
                type: 'GET',
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

    </script>
@endsection



