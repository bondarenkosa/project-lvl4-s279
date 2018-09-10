<div class="form-group row">
    {!! Form::label('name', 'Name', ['class' => 'col-md-4 col-form-label text-md-right']) !!}

    <div class="col-md-6">
        {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'required', 'autofocus']) !!}
        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row mb-0">
    <div class="col-md-6 offset-md-4">
        {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary']) !!}
    </div>
</div>
