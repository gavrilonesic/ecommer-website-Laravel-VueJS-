@foreach($childs as $child)
	<li class="col-md-6">
		@if(count($child->childs) > 0)
			<i class="expand-icon collapsed" data-toggle="collapse" data-target="#collapse-{{$child->id}}" aria-expanded="true" aria-controls="collapseOne"></i>
		@endif
		<div class="custom-control custom-checkbox" style="margin-left: {{$parent}}rem !important;">
			<input type="checkbox" id="custom-{{$child->id}}" name="permission_id[]" class="custom-control-input" value="{{$child->id}}" {{!empty(old('permission_id')) && in_array($child->id, old('permission_id')) ? 'checked' : ''}} {{!empty($userPermissions) && in_array($child->id, $userPermissions) ? 'checked' : ''}}>
			<label class="custom-control-label" for="custom-{{$child->id}}">{{ $child->title }}</label>
		</div>
	    @if(count($child->childs) > 0)
	    	<ul id="collapse-{{$child->id}}" class="collapse category-expand-collapse">
		        @include('admin.user.permission',['childs' => $child->childs, 'parent' => $parent + 1])
	    	</ul>
	    @endif
	</li>
@endforeach