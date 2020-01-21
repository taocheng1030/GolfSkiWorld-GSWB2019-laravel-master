    {{ Form::adminSelect('language_id', $languages->lists('name', 'id'), old('language_id'), 'Language') }}

    {{ Form::adminInput('key', old('key')) }}

    {{ Form::adminInput('translate', old('translate')) }}
