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
                            <h3 class="box-title">Create Employee</h3>
                        </div>
                        <div class="col-md-offset-10">
                            <a href="{{ route('employee_list') }}">
                                <button class="btn btn-block btn-primary ">Employee List</button>
                            </a>
                        </div>
                    </div><!-- /.box-header -->
                    <form action="{{route('employee_create')}}" id= "register" method="POST" role="form">
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
                                        <label>First Name</label>
                                        <input name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name" value="{{ old('first_name') }}" autocomplete="off">
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
                                        <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name" value="{{ old('last_name') }}" autocomplete="off">
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
                                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" autocomplete="off">
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
                                        <label>Phone No.</label>
                                        <input name="phone_number" type="text" class="form-control @error('phone_number') is-invalid @enderror" placeholder="Phone No." value="{{ old('phone_number') }}" autocomplete="off">
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
                                        <label>Password</label>
                                        <input name="password" type="text" class="form-control @error('password') is-invalid @enderror" placeholder="Password" value="{{ old('password') }}" autocomplete="off">
                                    </div>
                                    @error('password')
                                    <div class="form-group has-error">
                                    <span class="help-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label>Employee Id.</label>
                                        <input name="employee_id" type="text" class="form-control @error('employee_id') is-invalid @enderror" placeholder="Employee Id." value="{{ old('employee_id') }}" autocomplete="off">
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

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group has-feedback">
                                        <label>Designations</label>
                                        <select id="designation" name="designation" class="form-control " style="width: 100%;" @if($flag['checkSuperAdmin']) onchange="assignCompany()" @endif>
                                            <option value="{{ null }}">---Select a designation---</option>
                                            @foreach($designations as $designation)
                                                @if(old('designation')== $designation->id)
                                                    <option value="{{ $designation->id }}" selected>{{ $designation->designation }}</option>
                                                @else
                                                    <option value="{{ $designation->id }}">{{ $designation->designation }}</option>
                                                @endif
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

                                @if($flag['checkSuperAdmin'])
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label>Company</label>
                                            <select id="company" name="company" class="form-control " style="width: 100%;">
                                                <option value="{{ null }}">---Select an Company---</option>
                                            </select>
                                            @error('company')
                                                <div class="form-group has-error">
                                                    <span class="help-block" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if(!$flag['checkSuperAdmin'])
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group has-feedback">
                                            <label>Branch</label>
                                            <select id="branch" name="branch" class="form-control " style="width: 100%;">
                                                <option value="{{ null }}">---Select a branch---</option>
                                                @foreach($branches as $branch)
                                                    @if(old('branch')== $branch->id)
                                                        <option value="{{ $branch->id }}" selected>{{ $branch->branch_name }}</option>
                                                    @else
                                                        <option value="{{ $branch->id }}">{{ $branch->branch_name }}</option>
                                                    @endif
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

                        </div>
                        <div class="box-footer">
                            <a href="{{ route('employee_create_view') }}"><button type="button" class="btn btn-default">Cancel</button></a>
                            <button type="submit" class="btn btn-info pull-right">Register an Employee</button>
                        </div><!-- /.box-footer -->
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(()=>{
            assignCompany();
        });
        function assignCompany(){
            var designation_id = $('#designation').val();
            if(designation_id == 1 || designation_id == ''){
                $('#company').prop('disabled', true);
                $('#company').html(`<option value="{{ null }}">---Select an company---</option>`);
            }else{
                $.ajax({
                    url:'{{ route('search_company') }}',
                    async: true,
                    cache: false,
                    type: 'GET',
                    dataType: 'json',
                    success: function(result){
                        var company = '';
                        if(result.status === 'success') {
                            var data = result.data;
                            for (let i=0;i<data.length;i++) {
                                company += '<option value=' + data[i].id + '>' + data[i].name + '</option>';
                            }
                        }
                        $('#company').html(company);
                    },
                    error: function(){
                        alert('Something Went Wrong!!');
                    }
                });
                $('#company').prop('disabled', false);
                $('#company').prop('required', true);
            }
        }
    </script>
@endsection