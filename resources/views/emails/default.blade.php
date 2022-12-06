<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
    <head>
        <meta charset="utf-8"/>
        <!-- utf-8 works for most cases -->
        <meta content="width=device-width" name="viewport"/>
        <!-- Forcing initial-scale shouldn't be necessary -->
        <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
        <!-- Use the latest (edge) version of IE rendering engine -->
        <meta name="x-apple-disable-message-reformatting"/>
        <!-- Disable auto-scale in iOS 10 Mail entirely -->
        <title>
        </title>
        <!-- The title tag shows in email notifications, like Android 4.4. -->
        <!-- Web Font / @font-face : BEGIN -->
        <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->
        <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
        <!--[if mso]>
        <style>
            * {
                font-family: sans-serif !important;
            }
        </style>
    <![endif]-->
        <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
        <!--[if !mso]><!-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700&display=swap" rel="stylesheet"/>
        <!--<![endif]-->
        <!-- Web Font / @font-face : END -->
        <!-- CSS Reset -->
        <style>
            /* What it does: Remove spaces around the email design added by some email clients. */
        /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
        html,
        body {
            margin: 0 auto !important;
            padding: 0 !important;
            height: 100% !important;
            width: 100% !important;
            font-family: 'Montserrat', sans-serif;
        }

        /* What it does: Stops email clients resizing small text. */
        * {
            -ms-text-size-adjust: 100%;
            -webkit-text-size-adjust: 100%;
        }

        /* What it does: Centers email on Android 4.4 */
        div[style*="margin: 16px 0"] {
            margin: 0 !important;
        }

        /* What it does: Stops Outlook from adding extra spacing to tables. */
        table,
        td {
            mso-table-lspace: 0pt !important;
            mso-table-rspace: 0pt !important;
        }

        /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
        table {
            border-spacing: 0 !important;
            border-collapse: collapse !important;
            table-layout: fixed !important;
            margin: 0 auto !important;
        }

        table table table {
            table-layout: auto;
        }

        /* What it does: Uses a better rendering method when resizing images in IE. */
        img {
            -ms-interpolation-mode: bicubic;
        }

        /* What it does: A work-around for email clients meddling in triggered links. */
        *[x-apple-data-detectors],
        /* iOS */
        .x-gmail-data-detectors,
        /* Gmail */
        .x-gmail-data-detectors *,
        .aBn {
            border-bottom: 0 !important;
            cursor: default !important;
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
        .a6S {
            display: none !important;
            opacity: 0.01 !important;
        }

        /* If the above doesn't work, add a .g-img class to any image in question. */
        img.g-img+div {
            display: none !important;
        }

        /* What it does: Prevents underlining the button text in Windows 10 */
        .button-link {
            text-decoration: none !important;
        }

        /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
        /* Create one of these media queries for each additional viewport size you'd like to fix */
        /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
        </style>
        <!-- Progressive Enhancements -->
        <style>
            /* What it does: Hover styles for buttons */
        .button-td,
        .button-a {
            transition: all 100ms ease-in;
        }

        .button-td:hover,
        .button-a:hover {
            background: #555555 !important;
            border-color: #555555 !important;
        }

        /* Media Queries */
        @media screen and (max-width: 600px) {

            .email-container {
                width: 100% !important;
                margin: auto !important;
            }

            /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
            .fluid {
                max-width: 100% !important;
                height: auto !important;
                margin-left: auto !important;
                margin-right: auto !important;
            }

            /* What it does: Forces table cells into full-width rows. */
            .stack-column,
            .stack-column-center {
                display: block !important;
                width: 100% !important;
                max-width: 100% !important;
                direction: ltr !important;
            }

            /* And center justify these ones. */
            .stack-column-center {
                text-align: center !important;

            }

            .nopadd {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }

            /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
            .center-on-narrow {
                text-align: center !important;
                display: block !important;
                margin-left: auto !important;
                margin-right: auto !important;
                float: none !important;
            }

            table.center-on-narrow {
                display: inline-block !important;
            }

            /* What it does: Adjust typography on small screens to improve readability */
            .email-container p {
                font-size: 13px !important;
                line-height: 16px !important;
            }

        }
        </style>
        <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
        <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->
    </head>
    <body bgcolor="#fff" style="margin: 0; mso-line-height-rule: exactly;" width="100%">
        <center style="width: 100%; background: #fff; text-align: left;">
            <!-- Visually Hidden Preheader Text : BEGIN -->
            {{-- <div style="display:none;font-size:1px;line-height:1px;max-height:0px;max-width:0px;opacity:0;overflow:hidden;mso-hide:all;font-family: sans-serif;"> --}}
                {{-- (Optional) This text will appear in the inbox preview, but not the email body. --}}
            {{-- </div> --}}
            <!-- Visually Hidden Preheader Text : END -->
            <!-- Email Header : BEGIN -->
            <table align="center" border="0" cellpadding="0" cellspacing="0" class="email-container" role="presentation" style="margin: auto; background: #f0f5f9" width="650">
                <tr>
                    <td align="center" bgcolor="#f0f5f9" style="padding: 40px 20px 20px;" valign="top">
                        <table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
                            <tr>
                                <td class="stack-column-center" style="width:200px; padding:0">
                                    <a href="{{ url('/') }}">
                                        <img alt="General Chemical Corp." border="0" height="55" src="{{asset('/images/mail-logo.png')}}" style="height: auto; background: #f0f5f9;" width="185"/>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- Email Header : END -->
            <!-- Email Body : BEGIN -->
            <table align="center" border="0" cellpadding="0" cellspacing="0" class="email-container" role="presentation" style="margin: auto;" width="650">
                <tr>
                    <td align="center" bgcolor="#f0f5f9" style="padding:0 20px;" valign="top">
                        [Main Content]
                    </td>
                </tr>
                <tr>
                    <td align="center" style="padding:40px 0; background: #f0f5f9">
                        <p style="color:#627e95; font-weight:500; font-size:10px; line-height: 13px; display:block; margin:0 0 20px 0; font-family: 'Montserrat', sans-serif; max-width:450px; width:100%">
                            Please do not reply to this message. This email address is not monitored for responses.  If you have any questions or concerns, please contact <a href="mailto:{{ setting('email') }}"> {{ setting('email') }}</a>. Thank you.
                        </p>
                        <p style="color:#627e95; font-weight:500; font-size:10px; line-height: 13px; display:block; margin:0 0 15px 0; font-family: 'Montserrat', sans-serif;">
                            © General Chemical Corp. All Rights Reserved
                        </p>
                    </td>
                </tr>
            </table>
            <!-- Email Body : END -->
        </center>
    </body>
</html>