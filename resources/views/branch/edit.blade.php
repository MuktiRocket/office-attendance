@extends('layouts.layout')

@section('pagename','Edit Branch')

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
                            <h3 class="box-title">Edit Branch</h3>
                        </div>
                        <div class="col-md-offset-11">
                            <a href="{{ route('branch_list') }}">
                                <button class="btn btn-block btn-primary pull-right" style="min-width: 150px;">Branch List</button>
                            </a>
                        </div>
                    </div><!-- /.box-header -->
                    <form id="edit" method="POST" action="{{ route('branch_edit') }}" role="form">
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
                                <input type="hidden" name="id" id='self_id' value="{{$branch->id}}">
    
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label>Branch Name</label>
                                            <input name="branch_name" type="text" class="form-control @error('branch_name') is-invalid @enderror" placeholder="Branch name" autocomplete="off" value="{{$branch->branch_name}}">
                                        </div>
                                        @error('branch_name')
                                        <div class="form-group has-error">
                                            <span class="help-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label>Branch Address</label>
                                            <input name="branch_address" type="text" class="form-control @error('branch_address') is-invalid @enderror" placeholder="Last name" autocomplete="off" value="{{$branch->address}}">
                                        </div>
                                        @error('branch_address')
                                            <div class="form-group has-error">
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('branch_list') }}"><button type="button" class="btn btn-default">Cancel</button></a>
                                <button type="submit" class="btn btn-info pull-right" >Update a Branch</button>
                            </div><!-- /.box-footer -->
                        </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection