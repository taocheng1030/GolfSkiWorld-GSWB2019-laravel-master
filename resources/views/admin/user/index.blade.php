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
            <table id="users" class="table table-hover table-striped">
                @include('components.table.thead', ['fields' => [
                    [
                        'label'  => 'Name',
                        'filter' => 'input',
                        'options' => [
                            'style'  => 'width: auto !important'
                        ]
                    ],
                    [
                        'label'  => 'Email',
                        'filter' => 'input'
                    ],
                    [
                        'label'  => 'Role',
                        'sortable' => false,
                        'filter' => \App\Role::all()->lists('name', 'id')->toArray(),
                        'options' => [
                            'style'  => 'width: 200px !important'
                        ]
                    ],
                    ''
                ]])
                <tbody>
                @foreach ($models as $model)
                    <tr>
                        <td>{{ $model->name }}</td>
                        <td>{{ $model->email }}</td>
                        @if ($model->getRoles() != null)
                            <td>{{ $model->roles[0]->name }}</td>
                        @else
                            <td>None</td>
                        @endif
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
