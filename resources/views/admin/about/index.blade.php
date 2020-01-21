@extends('layouts.admin')
@section('title', ':: ' . $controllerTitle)
@section('page-header')
    {{ $controllerTitle }}
@endsection
@section('breadcrumb')
    <li class="active">{{ $controllerTitle }}</li>
@endsection
@section('content')

    @include('components.alert')

    <div class="box">
        <div class="box-header with-border">
            <a href="{{ adminUrl($controllerUrl.'/create')}}" class="btn btn-primary">Add new</a>
        </div>
        <div class="box-body no-padding">
            <table id="abouts" class="table table-hover table-striped">
                @include('components.table.thead', ['fields' => [
                    'ID',
                    [
                        'label'  => 'Name',
                        'filter' => 'input',
                        'options' => [
                            'style'  => 'width: 250px !important'
                        ]
                    ],
                    [
                        'label'  => 'Contact',
                        'filter' => 'input',
                        'options' => [
                            'style'  => 'width: 200px !important'
                        ]
                    ],
                    [
                        'label'  => 'Description',
                        'filter' => 'input',
                    ],
                    [
                        'label'  => 'Order'
                    ],
                    ''
                ]])
                <tbody>
                @foreach ($models as $model)
                    <tr>
                        <td>{{ $model->id }}</td>
                        <td>{{ $model->name }}</td>
                        <td>{{ $model->contact }}</td>
                        <td>{{ $model->description }}</td>
                        <td>{{ $model->order }}</td>
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
