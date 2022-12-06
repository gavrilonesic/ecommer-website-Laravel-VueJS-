<div class="col-md-9 col-lg-9 myprofile-right">
    <h2>
        {{__('messages.my_addresses')}}
    </h2>
        <a class="btn btn-primary" href="{{route('add_address')}}">{{__('messages.add_address')}}</a>
    <div class="row">
    @foreach($user->userAddress as $indexKey=>$userdata)
                  <div class="col-lg-4 col-md-4 col-sm-6 col-12">

                        <div class="addresbox">
                                <h5>
                                    {{ $userdata->first_name ? $userdata->first_name : '' }}
                                    {{ $userdata->last_name ? $userdata->last_name : '' }}  {{ $userdata->address_name ? '- '. $userdata->address_name : '' }}
                                </h5>
                                <p>{!! nl2br($userdata->getUserAddress()) !!}</p>
                                <div class="actionrow">
                                        <a class="" data-original-title="{{__('messages.edit')}} {{__('messages.address')}}" data-toggle="tooltip" href="{{route('address.edit', ['address' => $userdata->id])}}">
                                           Edit
                                        </a>  |
                                        {{ Form::open(['method' => 'DELETE', 'id'=>'delete_address', 'route' => ['address.delete', 'address' => $userdata->id]]) }}
                                        {{ Form::close() }}
                                        <a class="" data-original-title="{{__('messages.delete')}} {{__('messages.address')}}" data-toggle="" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('delete_address').submit();">
                                           Delete
                                        </a>
                                    </div>
                            </div>
                            </div>
                        @endforeach
           </div>

</div>