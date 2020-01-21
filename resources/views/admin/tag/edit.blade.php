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

        {{ Form::model($model, [
            'action' => [$controllerName.'@update', $model],
            'enctype' => 'multipart/form-data',
            'data-toggle' => 'validator',
            'role' => 'form',
        ]) }}

        {{ Form::hidden('_method', 'PUT') }}

        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="fa fa-th-list" aria-hidden="true"></i>
                Edit
            </h3>
        </div>

        <div class="box-body">
            @include('admin.tag.fields', ['model' => $model])
        </div>

        <div class="box-footer">
            {!! Form::button('Update', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
            {!! link_to(adminUrl($controllerUrl), 'Cancel', ['class' => 'btn btn-default']) !!}
        </div>

        {{ Form::close() }}

    </div>

@endsection
