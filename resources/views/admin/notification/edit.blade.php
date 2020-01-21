@extends('layouts.admin')
@section('title', ':: ' . 'Notification center')
@section('page-header')
    Notification center
@endsection
@section('breadcrumb')
    <li class="active">Notification center</li>
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
            @include('admin.notification.fields', ['model' => $model])
        </div>

        <div class="box-footer">
            {!! Form::button('Update', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
            {!! link_to(adminUrl($controllerUrl), 'Cancel', ['class' => 'btn btn-default']) !!}
        </div>

        {{ Form::close() }}

    </div>

@endsection

@section('script')
    <script>
        CKEDITOR.replace( 'body' );
    </script>
@endsection
