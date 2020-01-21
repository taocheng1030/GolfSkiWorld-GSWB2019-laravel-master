
    {{ Form::adminLocaleInput($model, 'name', ['eng' => old('name'), 'local' => old('local[name]')], 'Name *') }}

    {{ Form::adminLocaleTextarea($model, 'description', ['eng' => old('description'), 'local' => old('local[description]')], 'description', ['eng' => ['rows' => 4], 'local' => ['rows' => 4]]) }}

    {{ Form::adminLocaleTextarea($model, 'other_activity', ['eng' => old('other_activity'), 'local' => old('local[other_activity]')], 'Other activity', ['eng' => ['rows' => 4], 'local' => ['rows' => 4]]) }}

    {{ Form::adminLocaleTextarea($model, 'useful_info', ['eng' => old('useful_info'), 'local' => old('local[useful_info]')], 'Useful information', ['eng' => ['rows' => 4], 'local' => ['rows' => 4]]) }}