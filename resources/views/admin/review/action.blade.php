<div class="form-button-action">
    <a href="#" class="btn btn-link btn-primary btn-lg view-review" data-original-title="{{__('messages.edit_review')}}" data-toggle="modal" data-url="{{route('review.show', ['review' => $review->id])}}">
        <i class="icon-eye">
        </i>
    </a>
    <a class="btn btn-link btn-primary btn-lg" data-original-title="{{__('messages.edit_review')}}" data-toggle="tooltip" href="{{route('review.edit', ['review' => $review->id])}}">
        <i class="icon-note">
        </i>
    </a>
    {{ Form::open(['method' => 'DELETE', 'route' => ['review.delete', 'review' => $review->id]]) }}
        <button class="btn btn-link btn-danger btn-delete" data-original-title="{{__('messages.delete_review')}}" data-toggle="tooltip" href="{{route('review.delete', ['review' => $review->id])}}">
            <i class="icon-close"></i>
        </button>
    {{ Form::close() }}
</div>