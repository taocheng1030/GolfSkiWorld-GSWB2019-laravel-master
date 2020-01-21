@extends('layouts.admin')
@section('title', ':: ' . $controllerTitle)
@section('page-header')
    {{ $controllerTitle }}
@endsection
@section('breadcrumb')
    <li class="active">{{ $controllerTitle }}</li>
@endsection
@section('content')

    {{ Form::model($model, [
        'action' => [$controllerName.'@update', $model],
        'enctype' => 'multipart/form-data',
        'data-toggle' => 'validator',
        'role' => 'form',
    ]) }}

    {{ Form::hidden('_method', 'PUT') }}

    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="pull-left header">
                <i class="fa fa-th-list" aria-hidden="true"></i>
                Edit
            </li>
            <li role="presentation" class="active">
                <a href="#model_edit" aria-controls="model_edit" role="tab" data-toggle="tab"><span class="tab-name">Form</span></a>
            </li>
            <li role="presentation">
                <a href="#model_gallery" aria-controls="model_gallery" role="tab" data-toggle="tab"><span class="tab-name">Gallery</span></a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="model_edit">
                @include('admin.article.fields', ['model' => $model])
                <div class="form-actions">
                    {!! Form::button('Update', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                    {!! link_to(adminUrl($controllerUrl), 'Cancel', ['class' => 'btn btn-default']) !!}
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="model_gallery">
                @include('admin.photo.gallery', ['model' => $model])
            </div>
        </div>
    </div>

    {{ Form::close() }}

@endsection
