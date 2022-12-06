<div class="form-group">
    <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
    {!! isset($field['required']) ? '<span class="required-label">*</span>' : '' !!}
    {!! Form::textarea($field['name'], old($field['name'], \setting($field['name'])), ['id' => $field['name'], 'placeholder' => $field['label'], 'class' => "form-control " . ($errors->has($field['name']) ? 'is-invalid' : '')]) !!}

    @include('admin.error.validation_error', ['field' => $field['name']])
</div>