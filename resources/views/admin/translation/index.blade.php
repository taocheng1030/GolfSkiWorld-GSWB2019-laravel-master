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
            <table id="translations" class="table table-hover table-striped table-without-ID">
                @include('components.table.thead', ['fields' => [
                    [
                        'label'  => 'Key',
                        'filter' => 'input'
                    ],
                    [
                        'label'  => 'Translate',
                        'filter' => 'input'
                    ],
                    [
                        'label'  => 'Language',
                        'filter' => \App\Models\Language::all()->lists('name', 'name')->toArray(),
                        'options' => [
                            'style'  => 'width: 100px !important'
                        ]
                    ],
                    ''
                ]])
                <tbody>
                @foreach ($models as $model)
                    <tr>
                        <td>{{ $model->key}}</td>
                        <td>{{ $model->translate}}</td>
                        <td>{{ $model->language->name }}</td>
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
