<table align="center" border="0" cellpadding="0" cellspacing="0" class="email-container" style="margin: auto; background: #fff; width:100%;  ">
    <tr>
        <td bgcolor="#ffffff" style="padding: 40px 40px 40px 40px; text-align: center; border-top:3px solid #393950;">
            <img height="33" src="{{asset('/images/mail-tick-icon.png')}}" style="margin:0 auto 20px; display:block;" width="33"/>
            <h1 style="margin: 0 0 5px 0; font-family: 'Montserrat', sans-serif;  font-size: 22px; line-height: 22px; color: #3eabe2; font-weight: 600; text-transform: uppercase">
                {{__('messages.category_enquiry')}}
            </h1>
        </td>
    </tr>
    <tr>
        <td align="left" bgcolor="#fff" style="padding:0 40px 20px;" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" class="email-container" style="margin: auto; background: #fff; width:100%;  ">
                <tr>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            {{__('messages.name')}}:
                        </strong>
                    </td>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:inline-block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            [Customer First Name] [Customer Last Name]
                        </div>
                    </td>
                </tr>
                 <tr>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            {{__('messages.company_name')}}:
                        </strong>
                    </td>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:inline-block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            [Customer Company Name]
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            {{__('messages.email')}}:
                        </strong>
                    </td>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:inline-block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            [Customer Email]
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            {{__('messages.telephone')}}:
                        </strong>
                    </td>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:inline-block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            [Customer Telephone]
                        </div>
                    </td>
                </tr>
                 <tr>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            {{__('messages.address')}}:
                        </strong>
                    </td>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:inline-block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            [Customer Street Address], [Customer Address Line 2], [Customer City], [Customer State], [Customer Zipcode], [Customer Country].
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            {{__('messages.process_time')}}:
                        </strong>
                    </td>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:inline-block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            [Customer Process Time]
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            {{__('messages.temperature')}}:
                        </strong>
                    </td>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:inline-block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            [Customer Temperature]
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            {{__('messages.concentration')}}:
                        </strong>
                    </td>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:inline-block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            [Customer Concentration]
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            {{__('messages.soak')}}:
                        </strong>
                    </td>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:inline-block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            [Customer SOAK]
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            {{__('messages.reference')}}:
                        </strong>
                    </td>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:inline-block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            [Customer Reference]
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            {{__('messages.special_requirements')}}:
                        </strong>
                    </td>
                    <td align="left" class="stack-column-center" style="border-bottom:1px solid #e6e6e6; padding: 8px 0;" valign="top">
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:inline-block; margin-bottom:0; font-family: 'Montserrat', sans-serif;">
                            [Customer Special Requirement]
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="left" class="stack-column-center" style="padding: 8px 0;" valign="top">
                        <strong style="text-transform: uppercase; color:#666666; font-weight:700; font-size:13px; display:block; margin-bottom:5px; font-family: 'Montserrat', sans-serif;">
                            {{__('messages.comment')}}:
                        </strong>
                    </td>
                    <td align="left" class="stack-column-center" style="padding: 8px 0;" valign="top">
                        <div style="text-transform: capitalize; color:#666666; font-weight:500; font-size:13px; display:inline-block; margin-bottom:5px; font-family: 'Montserrat', sans-serif;word-break: break-all; ">
                            [Customer Comments]
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>