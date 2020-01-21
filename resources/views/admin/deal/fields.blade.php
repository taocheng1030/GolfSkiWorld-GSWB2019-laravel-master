
    {{ Form::adminSelect('site_id', $sites->lists('name', 'id'), old('site_id'), 'Site *') }}

    <div id="limiterID">
        {{ Form::adminMultiCheck('limiter_id', $limiters->lists('name', 'id'), explode(",", $model['limiter_id']), 'Limiter *') }}
    </div>

    <div id="limiterID1" class="limiterField">
        {{ Form::adminDatePicker('starts', old('starts'), 'Starts', [], 'dateTimeStarts') }}

        {{ Form::adminDatePicker('ends', old('ends'), 'Ends', [], 'dateTimeEnds') }}
    </div>

    <div id="limiterID2" class="limiterField">
        {{ Form::adminInput('numberofpurchases', old('numberofpurchases'), 'Number of purchases') }}
    </div>
    
    {{ Form::adminLocaleInput($model, 'name', ['eng' => old('name'), 'local' => old('local[name]')], 'Name *') }}

    {{ Form::adminLocaleTextarea($model, 'shortdescription', ['eng' => old('shortdescription'), 'local' => old('local[shortdescription]')], 'Short description', ['eng' => ['rows' => 2], 'local' => ['rows' => 2]], null, 150) }}

    {{ Form::adminLocaleTextarea($model, 'description', ['eng' => old('description'), 'local' => old('local[description]')], 'Description', ['eng' => ['rows' => 4], 'local' => ['rows' => 4]]) }}

    @if(is_null($model))
        {{ Form::adminMultiSelect('resorts[]', $resorts, old('resorts'), 'Connected resorts', ['id' => 'ddlSelectResort']) }}
    @else
        {{ Form::adminMultiSelect('resorts[]', $resorts, old('resorts') ? old('resorts') : $model->resorts->lists('id')->toArray(), 'Connected resorts', ['id' => 'ddlSelectResort']) }}
    @endif

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

    {{ Form::adminInput('latitude', old('latitude'), 'Latitude *') }}

    {{ Form::adminInput('longitude', old('longitude'), 'Longitude *') }}

    {{ Form::adminInput('owner', old('owner')) }}

    {{ Form::adminInput('owner_email', old('owner_email'), 'Owner email') }}

    {{ Form::adminInput('owner_phone', old('owner_phone'), 'Owner phone') }}

    {{ Form::adminInput('currency', old('currency'), 'Currency *') }}

    {{ Form::adminInput('originalprice', old('originalprice'), 'Original price') }}

    {{ Form::adminInput('price', old('price'), 'Price *') }}

    {{ Form::adminInput('link', old('link'), 'Link', ['placeholder' => 'http://example.com']) }}

    {{ Form::adminCheckbox('email') }}

    {{ Form::adminCheckbox('sms') }}

    {{ Form::adminCheckbox('push') }}

    {{ Form::adminCheckbox('published') }}
