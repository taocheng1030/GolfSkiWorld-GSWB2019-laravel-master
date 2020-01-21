
    {{ Form::adminSelect('site_id', $sites->lists('name', 'id'), old('site_id'), 'Site *') }}

    {{ Form::adminLocaleInput($model, 'name', ['eng' => old('name'), 'local' => old('local[name]')], 'Name *') }}

    {{ Form::adminLocaleTextarea($model, 'description', ['eng' => old('description'), 'local' => old('local[description]')], 'Description', ['eng' => ['rows' => 2], 'local' => ['rows' => 2]], null, 150) }}

    {{ Form::adminLocaleTextarea($model, 'details', ['eng' => old('details'), 'local' => old('local[details]')], 'Details', ['eng' => ['rows' => 4], 'local' => ['rows' => 4]]) }}

    {{ Form::adminInput('latitude', old('latitude'), 'Latitude *') }}

    {{ Form::adminInput('longitude', old('longitude'), 'Longitude *') }}

    @if(is_null($model))
        {{ Form::adminMultiSelect('restaurants[]', $restaurants, old('restaurants'), 'Connected restaurant', ['id' => 'ddlSelectRestaurant']) }}
    @else
        {{ Form::adminMultiSelect('restaurants[]', $restaurants, old('restaurants') ? old('restaurants') : $model->restaurants->lists('id')->toArray(), 'Connected restaurant', ['id' => 'ddlSelectRestaurant']) }}
    @endif

    @if(is_null($model))
        {{ Form::adminMultiSelect('accommodations[]', $accommodations, old('accommodations'), 'Connected hotel', ['id' => 'ddlSelectHotel']) }}
    @else
        {{ Form::adminMultiSelect('accommodations[]', $accommodations, old('accommodations') ? old('accommodations') : $model->accommodations->lists('id')->toArray(), 'Connected hotel', ['id' => 'ddlSelectHotel']) }}
    @endif

    @if(is_null($model))
        {{ Form::adminMultiSelect('destinfos[]', $destinfos, old('destinfos'), 'Connected destination', ['id' => 'ddlSelectDestinfo']) }}
    @else
        {{ Form::adminMultiSelect('destinfos[]', $destinfos, old('destinfos') ? old('destinfos') : $model->destinfos->lists('id')->toArray(), 'Connected destination', ['id' => 'ddlSelectDestinfo']) }}
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
