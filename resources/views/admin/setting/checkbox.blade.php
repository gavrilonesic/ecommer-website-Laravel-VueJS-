<div class="form-group">
    <div>
        <label>{{ $field['label'] }}</label>
    </div>
    @php
    	$response = \setting($field['name']);
    @endphp
    @if($field['options'])
    	@foreach($field['options'] as $key => $value)
    		<div class="custom-control custom-checkbox {{($errors->has($field['name']) ? 'is-invalid' : '')}}">
		        {!! Form::checkbox($field['name']."[]", $key, (in_array($key, $response ?? []) ? true : false), ['id' => $field['name'] . '_' . $key, 'class' => 'custom-control-input']) !!} 
		        <label class="custom-control-label" for="{{$field['name'] . '_' . $key}}">{{$value}}</label>
		    </div>
    	@endforeach
    @endif

    @include('admin.error.validation_error', ['field' => $field['name']])
</div>