{{ Form::open(['method' => 'PUT', 'route' => ['review.changeStatus', 'review' => $review->id]]) }}
	<a class="btn btn-round btn-link ispublish @if($review->status == '1') btn-primary @else btn-danger @endif" data-original-title="{{config('constants.REVIEW_STATUS')[$review->status]}}" data-toggle="tooltip" href="{{route('review.changeStatus', ['review' => $review->id])}}">
	@if($review->status == '1')
	    <i class="icon-check"></i>
	@else
	    <i class="icon-close"></i>
	@endif
	</a>
{{ Form::close() }}