<aside class="control-sidebar control-sidebar-light">
    <!-- Create the tabs -->
    {{--<ul class="nav nav-tabs nav-justified control-sidebar-tabs">--}}
        {{--<li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>--}}
    {{--</ul>--}}
    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Home tab content -->
        <div class="tab-pane active" id="control-sidebar-home-tab">

            @foreach($sidebarControl->models as $models)

                <div class="model-item">
                    <table class="table table-striped table-condensed" data-url="{{ $models['links']['delete'] }}" data-model="{{ $models['model'] }}" data-token="{{ csrf_token() }}">
                        <thead>
                        <tr>
                            <th colspan="2">{{ $models['title'] }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($models['models'] as $model)
                        <tr>
                            <td>{{ $model->name }}</td>
                            <td>
                                <a href="#" data-id="{{ $model->id }}" class="action-sidebar-delete">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ Form::open([
                        'url' => $models['links']['action'],
                        'data-toggle' => 'validator',
                        'role' => 'form',
                    ]) }}

                    {{ Form::hidden('model', $models['model']) }}

                    <div class="input-group">
                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) }}
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-primary btn-flat action-sidebar-add">Add</button>
                        </span>
                    </div>

                    {{ Form::close() }}

                </div>

            @endforeach

        </div>
        <!-- /.tab-pane -->
    </div>
</aside>
<!-- /.control-sidebar -->

<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>

<style>
    .table td:last-child {
        text-align: right;
    }
</style>

@section('script')
<script src="{!! asset('js/sidebar-control.js') !!}"></script>
@append