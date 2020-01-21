
    {{ Form::adminLocaleInput($model, 'name', ['eng' => old('name'), 'local' => old('local[name]')], 'Name *') }}

    {{ Form::adminInput('contact', old('contact'), 'Contact') }}

    {{ Form::adminLocaleTextarea($model, 'description', ['eng' => old('description'), 'local' => old('local[description]')], 'Description', ['eng' => ['rows' => 4], 'local' => ['rows' => 4]]) }}

    {{ Form::adminInput('order', old('order'), 'Order') }}