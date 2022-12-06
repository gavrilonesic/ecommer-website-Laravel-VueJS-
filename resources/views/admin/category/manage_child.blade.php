@foreach($childs as $child)
	@if(!isset($category->id) || ($category->id != $child->id))
		<li class="col-sm-12">
			@if(count($child->childs) > 0 && (!isset($category->parent_id) || $category->parent_id != $child->id || (count($child->childs) > 1)))
				<i class="expand-icon collapsed" data-toggle="collapse" data-target="#collapse-{{$child->id}}" aria-expanded="true" aria-controls="collapseOne"></i>
			@endif
			<div class="custom-control custom-radio" style="margin-left: {{$parent}}rem !important;">
				<input type="radio" id="custom-{{$child->id}}" name="parent_id" class="custom-control-input category_type" value="{{$child->id}}" {{!empty($category->parent_id) && $category->parent_id == $child->id ? 'checked' : ''}}>
				<label class="custom-control-label" for="custom-{{$child->id}}">{{ $child->name }}</label>
			</div>
		
		    @if(count($child->childs) > 0)
		    	<ul id="collapse-{{$child->id}}" class="collapse category-expand-collapse">
		        	@include('admin.category.manage_child',['childs' => $child->childs, 'parent' => $parent + 1])
		    	</ul>
		    @endif
		</li>
	@endif
@endforeach