<div class="col-md-9 col-lg-9 myprofile-right"><!--
<div class="actionpopup">
<div class="alert alert-dismissible">
<i class="icon-check"></i> 
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <h6>Your Product Deleted Succesfully</h6> 
</div>
     
    </div> -->
   <h2>{{__('messages.personal_information')}}</h2>
   <div class="">
      {!! Form::model(Auth::guard('web')->user(), ['name' => 'edit-customer-form', 'method' => 'PUT', 'id' => 'edit-customer-form', 'files' => true]) !!}
         <div class="form-group row">
            <div class="col-md-12 col-lg-6">
               <label> {{__('messages.first_name')}}</label>
               <span class="required-label"> * </span>
               {!! Form::text('first_name', null, ['id' => 'first_name', 'placeholder' => __('messages.enter_first_name'), 'class' => "form-control " . ($errors->has('first_name') ? 'is-invalid' : '')]) !!}
            </div>
            <div class="col-md-12 col-lg-6">
               <label> {{__('messages.last_name')}} </label>
               <span class="required-label"> * </span>
               {!! Form::text('last_name', null, ['id' => 'last_name', 'placeholder' => __('messages.enter_last_name'), 'class' => "form-control " . ($errors->has('last_name') ? 'is-invalid' : '')]) !!}
            </div>
         </div>
         <div class="form-group row">
            <div class="col-md-12">
               <label>{{__('messages.gender')}}</label>
               <div class="radioboxrow">
                  <span>
                     {!! Form::radio('gender', 'male', null) !!}
                     <label> {{__('messages.male')}} </label>
                  </span>
                  <span>
                  {!! Form::radio('gender', 'female', null) !!}
                  <label> {{__('messages.female')}} </label>
                  </span>
               </div>
            </div>
         </div>
         <div class="form-group row">
            <div class="col-md-12 col-lg-6">
               <label>{{__('messages.email')}}</label>
               <span class="required-label"> * </span>
               {!! Form::text('', Auth::guard('web')->user()->email, ['class' => "form-control", 'readonly' => true]) !!}
            </div>
            <div class="col-md-12 col-lg-6">
               <label>{{__('messages.mobile_no')}}</label>
               <span class="required-label"> * </span>
               {!! Form::text('mobile_no', null, ['id' => 'mobile_no', 'placeholder' => __('messages.enter_mobile_no'), 'class' => "form-control " . ($errors->has('mobile_no') ? 'is-invalid' : '')]) !!}
            </div>
         </div>
         <div class="form-group text-right">                     
            <button class="btn btn-primary"><i class="icon pencil"></i> Update Profile </button>
         </div>
      {!! Form::close() !!}
   </div>
   <h4>{{__('messages.change_password')}}</h4>
   {!! Form::open(['route' => ['change_password'],'name' => 'change-password-form', 'method' => 'PUT', 'id' => 'change-password-form']) !!}
      <div class="form-group row">
         <div class="col-md-12 col-lg-4">
            <label>{{__('messages.current_password')}}</label>
            {!! Form::password('current_password', ['id' => 'current_password', 'placeholder' => __('messages.enter_current_password'), 'class' => "form-control " . ($errors->has('current_password') ? 'is-invalid' : '')]) !!}
         </div>
         <div class="col-md-12 col-lg-4">
            <label>{{__('messages.new_password')}}</label>
            {!! Form::password('new_password', ['id' => 'new_password', 'placeholder' => __('messages.enter_new_password'), 'class' => "form-control " . ($errors->has('new_password') ? 'is-invalid' : '')]) !!}
         </div>
         <div class="col-md-12 col-lg-4">
            <label>{{__('messages.confirm_password')}}</label>
            {!! Form::password('confirm_password', ['id' => 'confirm_password', 'placeholder' => __('messages.enter_confirm_password'), 'class' => "form-control " . ($errors->has('confirm_password') ? 'is-invalid' : '')]) !!}
         </div>
      </div>
      <div class="form-group text-right">                     
         <button class="btn btn-primary"><i class="icon pencil"></i> Update Password</button>
      </div>
   {!! Form::close() !!}
</div>