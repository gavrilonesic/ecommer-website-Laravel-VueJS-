<table align="center" border="0" cellpadding="0" cellspacing="0" class="email-container" style="margin: auto; background: #fff; width:100%;">
    <tr>
        <td bgcolor="#ffffff" style="padding: 40px 40px 0 40px; text-align: center; border-top:3px solid #393950;">
            <img height="33" src="{{asset('/images/mail-tick-icon.png')}}" style="margin:0 auto 20px; display:block;" width="33"/>
            <h1 style="margin: 0 0 5px 0; font-family: 'Montserrat', sans-serif;  font-size: 22px; line-height: 22px; color: #3eabe2; font-weight: 600; text-transform: uppercase">
                {{__('messages.password_reset_confirmation')}}
            </h1>
            <p style="margin: 0 0 20px 0; font-family: 'Montserrat', sans-serif;  font-size: 16px; line-height: 20px; color: #666666; font-weight: 500;">
                <strong style="font-weight: 700">
                    {{__('messages.hello')}} [Customer Name],
                </strong>
                <br>
                {{__('messages.your_password_is_reset_successfully')}}
                <p bgcolor="#ffffff"
                    style="padding: 0px 40px 40px 40px; text-align: center; border-bottom:1px solid #f0f5f9">
                    <a href="{{ url('/my-profile')}}"
                        style="display: inline-block; padding:10px 20px;  font-family: 'Montserrat', sans-serif;   color:#fff; background-color:#3eabe2; font-weight:600; font-size:16px; text-align:center; line-height:16px; text-decoration: none;">{{__('messages.view_your_account')}}</a>
                </p>
            </p>
        </td>
    </tr>
</table>