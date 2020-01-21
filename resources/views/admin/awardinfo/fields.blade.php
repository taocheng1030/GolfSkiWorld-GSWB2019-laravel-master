
    {{ Form::adminLocaleInput($model, 'name', ['eng' => old('name'), 'local' => old('local[name]')], 'Name *') }}

    {{ Form::adminLocaleInput($model, 'left_title', ['eng' => old('left_title'), 'local' => old('local[left_title]')], 'Left title *') }}

    {{ Form::adminTextarea('left_info', old('left_info'), 'Left info') }}

    {{ Form::adminLocaleInput($model, 'middle_title', ['eng' => old('middle_title'), 'local' => old('local[middle_title]')], 'Middle title *') }}

    {{ Form::adminTextarea('middle_info', old('middle_info'), 'Middle info') }}

    {{ Form::adminLocaleInput($model, 'right_title', ['eng' => old('right_title'), 'local' => old('local[right_title]')], 'Right title *') }}

    {{ Form::adminTextarea('right_info', old('right_info'), 'Right info') }}

    
@section('script')
@parent
<script src="{!! asset('editor/ckeditor/ckeditor.js')!!}"></script>
<script>
    CKEDITOR.replace( 'left_info' );
    CKEDITOR.replace( 'middle_info' );
    CKEDITOR.replace( 'right_info' );
</script>
@append