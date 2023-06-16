@extends('layouts.layout')

@section('pagename','Company')

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
                            <h3 class="box-title">Company List</h3>
                        </div>
                        <div class="col-md-offset-11">
                            <a href="{{ route('company_create_view') }}">
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

                        <div class="col-md-12 table-responsive" style="overflow: auto; max-height: 500px">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Created Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($companies as $company)
                                        <tr>
                                            <td>{{ $company->name }}</td>
                                            <td>{{(new DateTime($company->created_at))->setTimezone(new DateTimeZone('Asia/Kolkata'))->format('d/m/Y')}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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