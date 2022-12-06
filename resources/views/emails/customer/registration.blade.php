<table align="center" border="0" cellpadding="0" cellspacing="0" class="email-container" style="margin: auto; background: #fff; width:100%;">
    <tr>
        <td bgcolor="#ffffff" style="padding: 40px 40px 0 40px; text-align: center; border-top:3px solid #393950;">
            <img height="33" src="{{asset('/images/mail-tick-icon.png')}}" style="margin:0 auto 20px; display:block;" width="33"/>
            <h1 style="margin: 0 0 5px 0; font-family: 'Montserrat', sans-serif;  font-size: 22px; line-height: 22px; color: #3eabe2; font-weight: 600; text-transform: uppercase">
                {{__('messages.registration_confirmation')}}
            </h1>
            <p style="margin: 0 0 20px 0; font-family: 'Montserrat', sans-serif;  font-size: 16px; line-height: 20px; color: #666666; font-weight: 500;">
                <strong style="font-weight: 700">
                    {{__('messages.hello')}} [Customer Name],
                </strong>
                <br>
                {{__('messages.thank_you_for_registering_with_us')}}
            </p>
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff"
            style="padding: 0px 40px 40px 40px; text-align: center; border-bottom:1px solid #f0f5f9">
            <a href="{{ url('/my-profile')}}" target="_blank"
                style="display: inline-block; padding:10px 20px;  font-family: 'Montserrat', sans-serif;   color:#fff; background-color:#3eabe2; font-weight:600; font-size:16px; text-align:center; line-height:16px; text-decoration: none;">{{__('messages.view_your_account')}}</a>
        </td>
    </tr>

    <tr>
        <td bgcolor="#ffffff" style="padding:20px 40px; text-align:left; ">
            <p
                style="font-size: 13px; color:#666666; font-weight:500; font-family: 'Montserrat', sans-serif; line-height: 16px;">
                This email confirms that you have been successfully registered with Email Id - [Customer Email]</p>
        </td>
    </tr>
    <tr>
        <td bgcolor="#ffffff" style="padding:20px 40px; text-align:left; ">
            <p
                style="font-size: 13px; color:#666666; font-weight:500; font-family: 'Montserrat', sans-serif; line-height: 16px;">
                Shop our wide range of products at <a href="{{ url('/store') }}" target="_blank" style="font-size: 13px; color:#666666; font-weight:500; font-family: 'Montserrat', sans-serif; line-height: 16px; text-decoration:underline;">{{ url('/store') }}</a></p>
        </td>
    </tr>
        <tr>
        <td bgcolor="#fff" align="left" valign="top" style="padding:20px 15px;">
            <table class="email-container" cellspacing="0" cellpadding="0" border="0"
            align="center" style="width:100%;">
              <tr>
                  <td class="stack-column-center nopadd" style="padding:15px 15px 15px 0;" valign="top">
                   <strong style="text-transform: uppercase; color:#3eabe2; font-weight:700; font-size:16px; line-height: 15px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif; ">CONTACT INFORMATION</strong>
                   <p style="text-transform: none; color:#666; font-weight:500; font-size:13px; line-height: 15px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;"><strong style="display: block; margin: 10px 0 5px 0; text-transform: uppercase">
                       Head office: </strong>
                   {{ setting('address_line1') ? setting('address_line1') : '' }} {{ setting('address_line2') ? setting('address_line2') : '' }} <br/>{{ setting('city') ? setting('city').', ' : '' }} {{ setting('state') ? setting('state') : '' }} {{ setting('zipcode') ? setting('zipcode').', ' : '' }} {{ setting('country') ? setting('country') : '' }}</p>
                    <p style="text-transform: none; color:#666; font-weight:500; font-size:13px; line-height: 15px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;"><strong style="display: block; margin: 10px 0 5px 0; text-transform: uppercase">
                        Phone/Fax: </strong>
                        <a href="tel:2485875600"  style="color:#666; text-decoration: none; text-transform: none">{{setting('mobile_no')}}</a> / {{setting('fax')}}</p>
                        <p style="text-transform: uppercase; color:#666; font-weight:500; font-size:13px; line-height: 15px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;"><strong style="display: block; margin: 10px 0 5px 0;">
                            Email: </strong>
                            <a href="mailto:{{setting('email')}}" style="color:#666; text-decoration: none; text-transform: none"> {{setting('email')}}</p>
                </td>
                <td class="stack-column-center nopadd" style="padding:15px 0 15px 0;" valign="top">
                    <strong style="text-transform: uppercase; color:#3eabe2; font-weight:700; font-size:16px; line-height: 15px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif; ">opening hours</strong>
                    <p style="text-transform: uppercase; color:#666; font-weight:500; font-size:13px; line-height: 15px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;"><strong style="display: block; margin: 10px 0 5px 0; text-transform: uppercase">
                        monday to friday: </strong> 7:30 am to 4:30 pm</p>
                        <p style="text-transform: uppercase; color:#666; font-weight:500; font-size:13px; line-height: 15px; display:block; margin:0 0 5px 0; font-family: 'Montserrat', sans-serif;"><strong style="display: block; margin: 10px 0 5px 0; text-transform: uppercase">
                            saturday and sunday: </strong> closed</p>
                 </td>

              </tr>
            </table>
        </td>
    </tr>
</table>