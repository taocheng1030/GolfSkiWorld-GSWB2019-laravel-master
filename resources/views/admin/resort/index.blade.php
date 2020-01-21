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
            <table id="resorts" class="table table-hover table-striped">
                @include('components.table.thead', ['fields' => [
                    'ID',
                    [
                        'label'  => 'Site',
                        'filter' => \App\Models\Site::all()->lists('name', 'name')->toArray(),
                        'options' => [
                            'style'  => 'width: 100px !important'
                        ]
                    ],
                    [
                        'label'  => 'Name',
                        'filter' => 'input'
                    ],
                    [
                        'label'  => 'Street',
                        'filter' => 'input'
                    ],
                    [
                        'label'  => 'City',
                        'filter' => 'input',
                        'options' => [
                            'style'  => 'width: 200px !important'
                        ]
                    ],
                    [
                        'label'  => 'Country',
                        'filter' => \App\Models\Country::all()->lists('name', 'name')->toArray(),
                        'options' => [
                            'style'  => 'width: 200px !important'
                        ]
                    ],
                    [
                        'label'  => 'Latitude',
                        'filter' => 'input',
                        'options' => [
                            'style'  => 'width: 100px !important'
                        ]
                    ],
                    [
                        'label'  => 'Longitude',
                        'filter' => 'input',
                        'options' => [
                            'style'  => 'width: 100px !important'
                        ]
                    ],
                    ''
                ]])
                <tbody>
                @foreach ($models as $model)
                    <tr>
                        <td>{{ $model->id }}</td>
                        <td>{{ $model->site->name }}</td>
                        <td>{{ $model->name }}</td>
                        <td>{{ $model->street }}</td>
                        <td>{{ $model->city->name }}</td>
                        <td>{{ $model->country->name }}</td>
                        <td>{{ $model->latitude }}</td>
                        <td>{{ $model->longitude }}</td>
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
