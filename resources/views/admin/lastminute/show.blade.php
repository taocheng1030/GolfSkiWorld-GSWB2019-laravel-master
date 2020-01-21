@extends('layouts.admin')
@section('title', ':: ' . $controllerTitle)
@section('page-header')
    {{ $controllerTitle }}
@endsection
@section('breadcrumb')
    <li class="active">{{ $controllerTitle }}</li>
@endsection
@section('content')

    <div class="box box-default">

        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-th-list" aria-hidden="true"></i>
                View
            </h3>
        </div>

        <div class="box-body">

        </div>

    </div>

@endsection
