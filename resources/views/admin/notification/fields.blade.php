
{{ Form::adminInput('name', old('name'), 'Title *') }}

{{ Form::adminLocaleTextarea($model, 'description', ['eng' => old('description'), 'local' => old('local[description]')], 'description', ['eng' => ['rows' => 4], 'local' => ['rows' => 4]]) }}

{{ Form::adminInput('link', old('link'), 'Link', ['placeholder' => 'http://example.com']) }}
