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
            <table id="articles" class="table table-hover table-striped">
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
                        'filter' => 'input',
                        
                    ],
                    [
                        'label'  => 'Language',
                        'filter' => \App\Models\Language::all()->lists('name', 'name')->toArray(),
                        'options' => [
                            'style'  => 'width: 100px !important'
                        ]
                    ],
                    [
                        'label'  => 'Author',
                        'filter' => 'input',
                        'options' => [
                            'style'  => 'width: 200px !important'
                        ]
                    ],
                    [
                        'label'  => 'Publish date',
                        'options' => [
                            'style'  => 'width: 140px !important'
                        ]
                    ],
                    [
                        'label'  => 'Published',
                        'filter' => 'boolean',
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
                        <td>{{ $model->name}}</td>
                        <td>{{ $model->language->name }}</td>
                        <td>{{ $model->author }}</td>
                        <td>{{ $model->publish_at }}</td>
                        <td>{{ $model->published?"Yes":"No" }}</td>
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
