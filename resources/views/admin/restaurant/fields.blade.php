
{{ Form::adminSelect('site_id', $sites->lists('name', 'id'), old('site_id'), 'Site *') }}

{{ Form::adminSelect('type_id', $types->lists('name', 'id'), old('type_id'), 'Type *') }}

{{ Form::adminLocaleInput($model, 'name', ['eng' => old('name'), 'local' => old('local[name]')], 'Name *') }}

{{ Form::adminLocaleTextarea($model, 'description', ['eng' => old('description'), 'local' => old('local[description]')], 'Description', ['eng' => ['rows' => 4], 'local' => ['rows' => 4]]) }}

{{ Form::adminInput('owner', old('owner')) }}

{{ Form::adminInput('latitude', old('latitude'), 'Latitude *') }}

{{ Form::adminInput('longitude', old('longitude'), 'Longitude *') }}

@if(is_null($model))
    {{ Form::adminMultiSelect('resorts[]', $resorts, old('resorts'), 'Connected resorts', ['id' => 'ddlSelectResort']) }}
@else
    {{ Form::adminMultiSelect('resorts[]', $resorts, old('resorts') ? old('resorts') : $model->resorts->lists('id')->toArray(), 'Connected resorts', ['id' => 'ddlSelectResort']) }}
@endif

{{ Form::adminSelect('country_id', $countries->lists('name', 'id'), old('country_id'), 'Country *', ['id' => 'countryId', 'class' => 'form-control countries']) }}

{{ Form::adminSelect('state_id', $states->lists('name', 'id'), old('state_id'), 'Region', ['id' => 'stateId', 'class' => 'form-control states']) }}

{{ Form::adminSelect('city_id', $cities->lists('name', 'id'), old('city_id'), 'City', ['id' => 'cityId', 'class' => 'form-control cities']) }}

{{ Form::adminInput('street', old('street')) }}

{{ Form::adminInput('zip', old('zip')) }}

{{ Form::adminPhoneSelect('phone', old('phone')) }}

{{ Form::adminInput('email', old('email')) }}

{{ Form::adminInput('link', old('link'), 'Link', ['placeholder' => 'http://example.com']) }}

{{ Form::adminCheckbox('sponser') }}

{{ Form::adminCheckbox('published') }}
