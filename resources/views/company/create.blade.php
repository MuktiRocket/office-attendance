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
                            <h3 class="box-title">Register Company</h3>
                        </div>
                        <div class="col-md-offset-10">
                            <a href="{{ route('company_list') }}">
                                <button class="btn btn-block btn-primary ">Company List</button>
                            </a>
                        </div>
                    </div><!-- /.box-header -->
                    <form action="{{route('create_company')}}" id= "register" method="POST" role="form">
                        @csrf
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
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label>Company Name</label>
                                        <input name="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" placeholder="Company Name" value="{{ old('company_name') }}" autocomplete="off">
                                    </div>
                                    @error('company_name')
                                    <div class="form-group has-error">
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <a href="{{ route('company_create_view') }}"><button type="button" class="btn btn-default">Cancel</button></a>
                            <button type="submit" class="btn btn-info pull-right">Register a Company</button>
                        </div><!-- /.box-footer -->
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection