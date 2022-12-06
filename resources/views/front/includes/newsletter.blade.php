<div class="signup-row text-center">
 <div class="container wow fadeIn">
   <div class="row">
         <div class="col align-self-center">
            <div class="subttl">customize a plan to save you time, manpower and money.</div>
            <h2>sign up for deals!</h2>
         </div>
      </div>
      <div class="emailbox">
       {!! Form::open(['route' => 'newsletter', 'name' => 'newsletter', 'id' => 'newsletter']) !!}

           {!! Form::text('email', null, ['id' => 'newsletter_subscription', 'placeholder' => __('messages.enter_your_email_address'), 'class' => 'form-control'. ($errors->has('email') ? 'is-invalid' : '')]) !!}
              <button type="submit"  id="submit-newsletter" class="btn btn-primary">{{ __('messages.send_me') }}</button>

       {!! Form::close() !!}
      </div>
 </div>
</div>