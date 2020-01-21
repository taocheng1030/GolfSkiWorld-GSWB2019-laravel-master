
    {{ Form::adminSelect('site_id', $sites->lists('name', 'id'), old('site_id'), 'Site') }}

    {{ Form::adminSelect('language_id', $languages->lists('name', 'id'), old('language_id'), 'Language') }}

    {{ Form::adminInput('name', old('name')) }}

    {{-- {{ Form::adminInput('textinmenu', old('textinmenu'), 'Text in menu') }} --}}

    {{ Form::adminInput('summary', old('summary'), 'Summary', [], null, 150) }}

    {{ Form::adminInput('author', old('author')) }}

    {{ Form::adminDatePicker('publish_at', old('publish_at'), 'Publish date', [], 'dateTimePublish') }}

    {{ Form::adminTextarea('body', old('body'), 'Body') }}

    {{ Form::adminInput('tags', old('tags'), 'Tags', ['placeholder' => 'Separate with commas']) }}

    {{-- {{ Form::adminInput('link', old('link'), 'Link', ['placeholder' => 'http://example.com']) }} --}}

    {{-- {{ Form::adminCheckbox('inmenu', null, 'In menu') }} --}}

    {{-- {{ Form::adminCheckbox('startpage', null, 'Start page') }} --}}

    {{ Form::adminCheckbox('published') }}

{{-- @section('script')
    @parent
    <script src="{!! asset('editor/ckeditor/ckeditor.js')!!}"></script>
    <script>
        CKEDITOR.replace( 'body' );
    </script>
@append --}}