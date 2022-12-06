<input type="text" class="form-control" placeholder="{{__('messages.card_number')}}&nbsp;*" name="card_number" />
<div class="row">
    <div class="col-md-6 col-sm-12">
        <label>Valid Date <span class="required-label">*</span></label><br>
        <div class="row">
           <div class="col-sm-12 col-md-6">   <select class="form-control" name="expiry_month">
            <option>{{__('messages.month')}}</option>
            @for($i = 1; $i <= 12; $i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select></div>
           <div class="col-sm-12 col-md-6">      <select class="form-control" name="expiry_year">
            <option>{{__('messages.year')}}</option>
            @for($i = date('Y'); $i <= date('Y') + 10; $i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select></div>
        </div>


    </div>
    <div class="col-md-6 col-sm-12">
    <label>CVV <span class="required-label">*</span></label><br>
        <input type="text" class="form-control" placeholder="{{__('messages.cvv')}}" name="cvv" required="required" />
    </div>
</div>