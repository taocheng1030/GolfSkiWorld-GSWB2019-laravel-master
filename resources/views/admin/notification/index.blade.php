@extends('layouts.admin')
@section('title', ':: ' . 'Notification center')
@section('page-header')
    Notification center
@endsection
@section('breadcrumb')
    <li class="active">Notification center</li>
@endsection
@section('content')

    @include('components.alert')

    <div class="box">
        <div class="box-header with-border">
            <a href="{{ adminUrl($controllerUrl.'/create')}}" class="btn btn-primary">Add new</a>
        </div>
        <div class="box-body no-padding">
            <table id="awardinfos" class="table table-hover table-striped">
                @include('components.table.thead', ['fields' => [
                    'ID',
                    [
                        'label'  => 'Title',
                        'filter' => 'input'
                    ],
                    [
                        'label'  => 'Description',
                        'filter' => 'input'
                    ],
                    [
                        'label'  => 'Link',
                        'filter' => 'input'
                    ],
                    [
                        'label'=>'Action',
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
                        <td>{{ $model->name }}</td>
                        <td>{{ $model->description }}</td>
                        <td>{{ $model->link }}</td>
                        <td>
                            <div class="buttons">
                                <a href="#push" class="action-push btn btn-primary" id="btn-push-{{ $model->id }}" 
                                    data-url={{adminUrl($controllerUrl, ['id' => $model->id, 'push'])}}
                                    data-confirm="{{ trans('dashboard.notification.push.confirm') }}">Push</a> 
                            </div>
                        </td>
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
