<hr>
<div class="row form-group form-group-calspace">
    <div class="col-sm-6 col-sm-offset-2">
        {!! Form::button($value, ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
        {!! link_to($cancel, 'Cancel', ['class' => 'btn btn-default']) !!}
    </div>
</div>