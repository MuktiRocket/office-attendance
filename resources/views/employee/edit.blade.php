@extends('layouts.layout')

@section('pagename','Edit Employee')

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
                            <h3 class="box-title">Edit Employee</h3>
                        </div>
                        <div class="col-md-offset-11">
                            <a href="{{ route('employee_list') }}">
                                <button class="btn btn-block btn-primary pull-right" style="min-width: 150px;">Employee List</button>
                            </a>
                        </div>
                    </div><!-- /.box-header -->
                    <form id="edit" method="POST" action="{{ route('employee_edit') }}" role="form">
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
                                <input type="hidden" name="id" id='self_id' value="{{$employee->id}}">
    
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label>First Name</label>
                                            <input name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" placeholder="First name" value="{{$employee->first_name}}" autocomplete="off">
                                        </div>
                                        @error('first_name')
                                        <div class="form-group has-error">
                                            <span class="help-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label>Last Name</label>
                                            <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last name" value="{{$employee->last_name}}" autocomplete="off">
                                        </div>
                                        @error('last_name')
                                            <div class="form-group has-error">
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label>Email</label>
                                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{$employee->email}}" autocomplete="off">
                                        </div>
                                        @error('email')
                                            <div class="form-group has-error">
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
    
                                    </div>
    
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label>Phone Number</label>
                                            <input name="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Phone No." value="{{$employee->phone_number}}" autocomplete="off">
                                        </div>
                                        @error('phone_number')
                                            <div class="form-group has-error">
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                    
                                </div>
    
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label>Designations</label>
                                            <select id="designation" name="designation" class="form-control " style="width: 100%;" disabled>
                                                @foreach ($designations as $designation)
                                                    <option value="{{ $designation->id }}" @if($designation->id == $employee->designation_id) selected @endif>{{ $designation->designation }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('designation')
                                            <div class="form-group has-error">
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label id="name" style="display:none;">Password</label>
                                            <input type="hidden" name="oldPassword" value="{{$employee->password}}">
                                            <input name="password" id="password" type="text" class="form-control @error('password') is-invalid @enderror" placeholder="Password" autocomplete="off" style="display:none;">
                                            
                                        </div>
                                        @error('password')
                                        <div class="form-group has-error">
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                        </div>
                                        @enderror
                                        <button type="button" class="btn btn-secondary" id="passEdit" onclick="changePass()">Click to change Password</button>
                                    </div>
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label>Employee Id.</label>
                                            <input name="employee_id" type="text" class="form-control @error('employee_id') is-invalid @enderror" placeholder="Employee Id." value="{{$employee->employee_id}}" autocomplete="off">
                                        </div>
                                        @error('employee_id')
                                        <div class="form-group has-error">
                                        <span class="help-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                @if(!$flag['checkSuperAdmin'])
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label>Branch</label>
                                            <select id="branch" name="branch" class="form-control " style="width: 100%;">
                                                @foreach($branches as $branch)
                                                    <option value="{{ $branch->id }}" @if($branch->id == $employee->branch_id) selected @endif>{{ $branch->branch_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('branch')
                                            <div class="form-group has-error">
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @endif
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('employee_list') }}"><button type="button" class="btn btn-default">Cancel</button></a>
                                <button type="submit" class="btn btn-info pull-right" >Update a Employee</button>
                            </div><!-- /.box-footer -->
                        </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection
@section('js')
<script>
    function changePass(){
        $('#password').show();
        $('#name').show();
        $('#passEdit').hide();
    }
</script>
@endsection