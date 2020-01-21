@extends('layouts.admin')
@section('title', ':: ' . 'Destinations')
@section('page-header')
    Destinations
@endsection
@section('breadcrumb')
    <li class="active">Destinations</li>
@endsection
@section('content')

    @include('components.alert')

    <div class="box">
        <div class="box-header with-border">
            <a href="{{ adminUrl($controllerUrl.'/create')}}" class="btn btn-primary">Add new</a>
        </div>

        <div class="box-body no-padding">
            <table id="destinfos" class="table table-hover table-striped">
                @include('components.table.thead', ['fields' => [
                    'ID',
                    [
                        'label' => 'Name',
                        'filter' => 'input',
                    ],
                    ''
                ]])
                <tbody>
                @foreach ($models as $model)
                    <tr>
                        <td>{{ $model->id }}</td>
                        <td>{{ $model->name }}</td>
                        <td class="text-center">
                            @include('components.table.column_action', [
                                'edit' => adminUrl($controllerUrl, ['id' => $model->id, 'edit']),
                                'delete' => adminUrl($controllerUrl, ['id' => $model->id])
                            ])
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            @include('components.table.pagination')
        </div>
    </div>
@endsection
