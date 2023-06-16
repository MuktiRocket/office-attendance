@extends('layouts.layout')

@section('pagename','Employee')

@section('script')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
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
                        <h3 class="box-title">Employee List</h3>
                    </div>
                    <div class="col-md-offset-11">
                        <a href="{{ route('employee_create_view') }}">
                            <button class="btn btn-block btn-primary pull-right">Register</button>
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

                    <form method="GET" action="{{ route('employee_list') }}">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <label>Search For Employee</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="search_data" class="form-control"
                                        value="@isset($request->search_data) {{ $request->search_data }} @endisset"
                                        autocomplete="off">
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ route('employee_list') }}"><button type="button"
                                            class="btn btn-primary">Reset</button></a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <br><br>

                    <div class="col-md-12 table-responsive" style="overflow: auto; max-height: 500px">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Employee Id.</th>
                                    <th>Phone Number</th>
                                    <th>Designation</th>
                                    @if($flag['checkSuperAdmin'])
                                    <th>Company</th>
                                    @endif
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employees as $employee)
                                <tr>
                                    <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->employee_id }}</td>
                                    <td>{{ $employee->phone_number }}</td>
                                    <td>{{ $employee->user_designation->designation }}</td>
                                    @if($flag['checkSuperAdmin'])
                                    <td>{{ $employee->user_company->name ?? '' }}</td>
                                    @endif
                                    <td>
                                        @if($employee->active_status == 1)
                                        <button class="btn btn-danger btn-xs" data-toggle="tooltip"
                                            title="Deactivate User"
                                            onclick="deactivateFunction('{{URL::to('employee/deactivate/'.Crypt::encrypt($employee->id))}}')"><i
                                                class="fa fa-fw fa-ban"></i></button>
                                        @else
                                        <button class="btn btn-success btn-xs" data-toggle="tooltip"
                                            title="Reactivate User"
                                            onclick="reactivateFunction('{{URL::to('employee/reactivate/'.Crypt::encrypt($employee->id))}}')"><i
                                                class="fa fa-fw fa-check"></i></button>
                                        @endif
                                        <a class="btn btn-primary btn-xs"
                                            href="{{ URL::to('employee/edit/'.Crypt::encrypt($employee->id)) }}"><i
                                                class="fa fa-fw fa-edit"></i></a>
                                        <button class="btn btn-danger btn-xs" data-toggle="tooltip"
                                            title="Delete Employee"
                                            onclick="deleteEmployee('{{URL::to('employee/delete/'.Crypt::encrypt($employee->id))}}')"><i
                                                class="fa fa-fw fa-remove"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        @if(isset($employees))
                        @if(isset($request))
                        {{ $employees->appends(['search_data' => $request->search_data])->links() }}
                        @else
                        {{ $employees->links() }}
                        @endif
                        @endif
                    </ul>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>

@endsection

@section('js')
<script src="{{ asset('bower_components/sweetalert/sweetalert.js') }}"></script>
<script>
    function processFunction(link, callback, payload) {
        var result = {};
        $.ajax({
            url: link,
            async: true,
            cache: false,
            type: 'get',
            data: payload,
            success: function (data) {
                result = JSON.parse(data);
                callback(result);
            },
            error: function () {
                result['status'] = 'error';
                result['message'] = 'Something went wrong';
                callback(result);
            }
        });

    }
    var deleteEmployee = (link) => {
        event.preventDefault(); // prevent form submit
        swal({
            title: "Are you sure?",
            text: "You want to delete this user!",
            icon: "warning",
            buttons: true,
            dangerMode: false,
        })
            .then((willDelete) => {
                if (willDelete) {
                    processFunction(link, function (result) {
                        if (result) {
                            if (result.status === 'success') {
                                swal("Poof! Deletion successful", {
                                    icon: "success",
                                });
                                setTimeout(function () {
                                    window.location.href = window.location.origin + '/employee/list';
                                }, 1500);
                            } else if (result.status === 'error') {
                                swal(result.message, {
                                    icon: "error",
                                });
                            }
                        }
                    });
                } else {
                    swal("Your request is cancelled");
                }
            });
    }

</script>
@endsection