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
            <table id="deals" class="table table-hover table-striped">
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
                        'label'  => 'Views',
                        'filter' => 'input',
                        'options' => [
                            'style'  => 'width: 100px !important'
                        ]
                    ],
                    [
                        'label'  => 'Hits',
                        'filter' => 'input',
                        'options' => [
                            'style'  => 'width: 100px !important'
                        ]
                    ],
                    [
                        'label'  => 'Currency',
                        'filter' => 'input',
                        'options' => [
                            'style'  => 'width: 100px !important'
                        ]
                    ],
                    [
                        'label'  => 'Owner',
                        'filter' => 'input',
                    ],
                    [
                        'label'  => 'Limiter',
                        'filter' => \App\Models\DealLimiter::all()->lists('name', 'name')->toArray(),
                        'options' => [
                            'style'  => 'width: 150px !important'
                        ]
                    ],
                    [
                        'label'  => 'Remaining',
                        'filter' => 'input',
                        'options' => [
                            'style'  => 'width: 100px !important'
                        ]
                    ],
                    ''
                ]])
                <tbody>
                <?php 
                    $limiters = \App\Models\DealLimiter::all()
                ?>
                @foreach ($models as $model)
                    <tr>
                        <td>{{ $model->id }}</td>
                        <td>{{ $model->site->name }}</td>
                        <td>{{ $model->name }}</td>
                        <td>{{ $model->views }}</td>
                        <td>{{ $model->hits }}</td>
                        <td>{{ $model->currency }}</td>
                        <td>{{ $model->owner }}</td>
                        <td>
                            <?php 
                                $ids = explode(",", $model->limiter_id);
                                $limiterNames = [];
                                foreach ($limiters as $value) {
                                    if(in_array($value->id, $ids)) {
                                        $limiterNames[] = $value->name;
                                    }
                                }
                            ?>
                            {{implode(",", $limiterNames)}}
                        </td>
                        <td>{{ $model->remaining }}</td>
                        <td class="text-center">
                            @include('components.table.column_action', [
                                'edit' => adminUrl($controllerUrl, ['id' => $model->id, 'edit']),
                                'delete' => adminUrl($controllerUrl, ['id' => $model->id]),
                                'menu' => [
                                    'booked' => [
                                        'class' => 'action-dialog',
                                        'label' => '<i class="fa fa-users"></i> Members',
                                        'href' => adminUrl($controllerUrl, ['id' => $model->id, 'booked'])
                                    ]
                                ]
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
