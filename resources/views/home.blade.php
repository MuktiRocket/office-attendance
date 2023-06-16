@extends('layouts.layout')

@section('pagename', 'Dashboard')

@section('main-content')

<section class="content">
    <!-- Info boxes -->
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Employee</span>
                    <span class="info-box-number">{{ $employees }}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
    </div>
</section>

@endsection

@section('js')
    <script src="{{ asset('bower_components/sweetalert/sweetalert.js') }}"></script>
    <script src="{{ asset('dist/js/custom.js') }}"></script>
@endsection

