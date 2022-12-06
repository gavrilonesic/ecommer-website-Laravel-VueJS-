@foreach($childs as $child)
	@if(!isset($category->id) || ($category->id != $child->id))
		<li class="col-md-12">
			@if(count($child->childs) > 0)
				<i class="expand-icon collapsed" data-toggle="collapse" data-target="#collapse-{{$child->id}}" aria-expanded="true" aria-controls="collapseOne"></i>
			@endif
			<div class="custom-control custom-checkbox" style="margin-left: {{$parent}}rem !important;">
				<input type="checkbox" id="custom-{{$child->id}}" name="category_id[]" class="custom-control-input" value="{{$child->id}}" {{!empty(old('category_id')) && in_array($child->id, old('category_id')) ? 'checked' : ''}} {{!empty($categoryId) && in_array($child->id, $categoryId) ? 'checked' : ''}}>
				<label class="custom-control-label" for="custom-{{$child->id}}">{{ $child->name }}</label>
			</div>
		    @if(count($child->childs) > 0)
		    	<ul id="collapse-{{$child->id}}" class="collapse category-expand-collapse">
			        @include('admin.product.manage_category',['childs' => $child->childs, 'parent' => $parent + 1])
		    	</ul>
		    @endif
		</li>
	@endif
@endforeach