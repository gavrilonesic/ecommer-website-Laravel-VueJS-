<div class="row">
    <div class="col-md-12 video-error" style="display: none">
        <div class="alert alert-danger">
            <strong>
                {{__('messages.please_select_atleast_one_video')}}
            </strong>
        </div>
    </div>
    <div class="col-md-6 offset-md-6 text-right">
          <input type="text" class="form-control" name="search_video" id="search_video" placeholder="{{__('messages.search_video')}}">
    </div>
    {{-- <div class="col-md-12"> --}}
        @foreach($videos as $video)
        <div class="col-md-3 video-list">
            <div class="image-video-gallery">
                @if($video->medias)
                <a target="_blank" href="{{$video->medias->getUrl() }}" class="anchorbox">
                    <img alt="preview" class="avatar-img img-fluid" src="{{$video->medias->getUrl('thumb')}}">
                </a>
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" name="video" type="checkbox" value="{{$video->id}}" id="video-{{$video->id}}" {{ (!empty($product->video_id) && in_array($video->id, $product->video_id )) ? 'checked':'' }} data-video-url="{{$video->medias->getUrl() }}" data-video-image-url="{{$video->medias->getUrl('thumb')}}" data-video-title="{{$video->title}}" />
                        <label class="custom-control-label" for="video-{{$video->id}}">{{$video->title}}
                        </label>
                </div>
                {{-- @else
                <span class="col-6 col-md-3 mb-4">
                    <img alt="preview" class="avatar-img img-fluid" src="{{asset('images/150x150.png')}}">
                </span> --}}
                @endif
            </div>
        </div>
        @endforeach
        {{-- <div class="table-responsive">
            <table class="display table table-head-bg-primary table-striped no-footer">
                <thead>
                    <tr>
                        <th>
                            #
                        </th>
                        <th>
                            {{__('messages.video')}}
                        </th>
                        <th>
                            {{__('messages.title')}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($videos as $video)
                    <tr>
                        <td>
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" name="video[]" type="checkbox" value="{{$video->id}}" id="video-{{$video->id}}" />
                                    <label class="custom-control-label" for="video-{{$video->id}}">
                                    </label>
                            </div>
                        </td>
                        <td>
                            <div class="row image-gallery avatar">
                                @if($video->medias)
                                <a class="" target="_blank" href="{{$video->medias->getUrl() }}">
                                    <img alt="preview" class="avatar-img img-fluid" src="{{$video->medias->getUrl('thumb')}}">
                                </a>
                                @else
                                <span class="">
                                    <img alt="preview" class="avatar-img img-fluid" src="{{asset('images/150x150.png')}}">
                                </span>
                                @endif
                            </div>
                        </td>
                        <td>
                            {{$video->title}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div> --}}
    {{-- </div> --}}
</div>
