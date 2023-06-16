@extends('layouts.layout')

@section('pagename','Branch')

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
                        <h3 class="box-title">Branch List</h3>
                    </div>
                    <div class="col-md-offset-11">
                        <a href="{{ route('branch_create_view') }}">
                            <button class="btn btn-block btn-primary pull-right">Create</button>
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

                    <div class="col-md-12 table-responsive" style="overflow: auto; max-height: 500px">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Branch Name</th>
                                    <th>Address</th>
                                    <th>Assigned Employees</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($branches as $branch)
                                <tr>
                                    <td>{{ $branch->branch_name }}</td>
                                    <td>{{ $branch->address }}</td>
                                    @if($branch->employee)
                                    <td>
                                        @foreach ($branch->employee as $emp)
                                        {{ $emp->first_name.' '.$emp->last_name }},
                                        @endforeach
                                    </td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td>{{(new DateTime($branch->created_at))->setTimezone(new DateTimeZone('Asia/Kolkata'))->format('d/m/Y')}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-xs" data-toggle="tooltip" title="Edit branch" href="{{ URL::to('branch/edit/'.Crypt::encrypt($branch->id)) }}"><i class="fa fa-fw fa-edit"></i></a>

                                        {{-- <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Delete branch"><i class="fa fa-fw fa-ban"></i></button> --}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer clearfix">
                    <ul class="pagination pagination-sm no-margin pull-right">
                        @if(isset($branches))
                            {{ $branches->links() }}
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="{{ asset('bower_components/sweetalert/sweetalert.js') }}"></script>
<script src="{{ asset('dist/js/custom.js') }}"></script>
@endsection