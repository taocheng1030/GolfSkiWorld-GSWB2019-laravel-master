@extends('layouts.admin')
@section('title', ':: ' . 'Award infos')
@section('page-header')
    Award infos
@endsection
@section('breadcrumb')
    <li class="active">Award infos</li>
@endsection
@section('content')

    <div class="box box-default">

    {{ Form::open([
        'action' => $controllerName.'@store',
        'enctype' => 'multipart/form-data',
        'data-toggle' => 'validator',
        'role' => 'form',
    ]) }}

        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-th-list" aria-hidden="true"></i>
                Create
            </h3>
        </div>

        <div class="box-body">
            @include('admin.awardinfo.fields', ['model' => null])
        </div>

        <div class="box-footer">
            {!! Form::button('Create', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
            {!! link_to(adminUrl($controllerUrl), 'Cancel', ['class' => 'btn btn-default']) !!}
        </div>

        {{ Form::close() }}

    </div>

@endsection