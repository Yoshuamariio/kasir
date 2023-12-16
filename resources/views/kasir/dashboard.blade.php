@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body text-center">
                <h1>Selamat Datang</h1>
                <br><br>
                <a href="{{ route('rolling.index') }}" class="btn btn-success btn-lg">Sistem Rolling</a>
                <a href="{{ route('laporan.index') }}" class="btn btn-success btn-lg">Laporan</a>
                <br><br><br>
            </div>
        </div>
    </div>
</div>
<!-- /.row (main row) -->
@endsection