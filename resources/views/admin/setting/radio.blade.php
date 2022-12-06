<div class="form-group">
    <div>
        <label>{{ $field['label'] }}</label>
    </div>
    
    @if($field['options'])
    	@foreach($field['options'] as $key => $value)
    		<div class="custom-control custom-radio">
		        {!! Form::radio($field['name'], $key, (\setting($field['name']) == $key) ? true : false, ['id' => $field['name'] . '_' . $key, 'class' => 'custom-control-input']) !!} 
		        <label class="custom-control-label" for="{{$field['name'] . '_' . $key}}">{{$value}}</label>
		    </div>
    	@endforeach
    @endif

    @include('admin.error.validation_error', ['field' => $field['name']])
</div>