<div class="row">
    <div class="col-md-3 col-lg-3">
        <div class="form-group">
            <label for="name">{{__('messages.from')}} <span class="sicon-class">(symbole)</span></label>
            {!! Form::text("shipping_charge[ranges][$key][from]", $range->from ?? null, ['placeholder' => __('messages.enter_from'), 'class' => "form-control range_required"]) !!}
        </div>
    </div>
    <div class="col-md-3 col-lg-3">
        <div class="form-group">
            <label for="name">{{__('messages.to')}} <span class="sicon-class">(symbole)</span></label>
            {!! Form::text("shipping_charge[ranges][$key][to]",  $range->to ?? null, ['placeholder' => __('messages.enter_to'), 'class' => "form-control range_required"]) !!}
        </div>
    </div>
    <div class="col-md-3 col-lg-3">
        <div class="form-group">
            <label for="name">{{__('messages.cost')}} ({{setting('currency_symbol')}})</label>
            {!! Form::text("shipping_charge[ranges][$key][cost]", $range->cost ?? null, ['placeholder' => __('messages.enter_cost'), 'class' => "form-control range_required"]) !!}
        </div>
    </div>
    @if ($key != 0)
        <button type="button" class="btn btn-link btn-danger btn-delete-range" data-original-title="{{__('messages.delete')}}" data-toggle="tooltip">
            <i class="icon-close"></i>
        </button>
    @endif
</div>