@extends('layouts.email')

@section('content')
    <table border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="width:100%;background-color:#ffffff;text-align:left;margin:0 auto;max-width:1024px;min-width:320px;border: 1px solid #ddd;">
        <tbody>
        <tr>
            <td>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="width:100%;background-color:#ffffff;padding:0;border-bottom:1px solid #ddd">
                    <tbody>
                    <tr>
                        <td>
                            <h2 style="padding:0;margin:10px 20px;font-size:16px;line-height:1.4em;font-weight:bold;color:#464646;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">
                                Registration Confirmation
                            </h2>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table style="width:100%" width="100%" border="0" cellspacing="0" cellpadding="20" bgcolor="#ffffff">
                    <tbody>
                    <tr>
                        <td>
                            <table style="width:100%" border="0" cellspacing="0" cellpadding="0">
                                <tbody>
                                    <tr>
                                        {{--<td valign="top" style="width:60px">
                                            <a style="text-decoration:underline;color:#2585b2" href="http://gravatar.com/eurekadongkoy" target="_blank"><img border="0" alt="" src="https://ci3.googleusercontent.com/proxy/JkbZeytRj49OGtnblHBWXKhKR7kPSECRp5tNxL2Un9n0oCJAFkExGkpe3oWR901g_JckaiX-X52rBo9xyl_fI9Agv-E-YopfDQlFBVQPGhliR-97e8LgtWwXWNnDa_3TgX0qMTg=s0-d-e1-ft#https://2.gravatar.com/avatar/88bd40acb79a7eee4e307a571a842ccc?s=60&amp;d=retro&amp;r=G" height="60" width="60" class="CToWUd"></a>
                                        </td> --}}

                                        <td valign="top" style="padding:0 0 0 20px">
                                            <p style="direction:ltr;font-size:14px;line-height:1.4em;color:#444444;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;margin:0 0 1em 0;margin:0 0 20px 0">
                                                Hello {{ $firstname }}!<br/><br/>

                                                Thank you for signing up for {{ trans('app.site_name') }}. We're really happy to have you!                                            
                                            </p>

                                            <p style="direction:ltr;font-size:14px;line-height:1.4em;color:#444444;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;margin:0 0 1em 0;margin:0 0 20px 0">
                                                Click the link below to verify your account and get started.
                                            </p>

                                            <div style="direction:ltr;margin:0 0 20px 0;font-size:14px;">
                                                <p style="direction:ltr;font-size:14px;line-height:1.4em;color:#444444;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;margin:0 0 1em 0">
                                                    <a href="{{ $verificationUrl }}" style="text-decoration: none;color: #fff;background-color: #4BA2CC;border-color: transparent;display: inline-block;margin-bottom: 0;font-weight: normal;text-align: center;vertical-align: middle;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;background-image: none;border: 1px solid transparent;white-space: nowrap;box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.3);transition: all 0.2s;padding: 6px 12px;font-size: 14px;line-height: 1.42857;border-radius: 2px;" target="_blank">Verify my email</a>
                                                </p>
                                            </div>

                                            <p style="direction:ltr;font-size:14px;line-height:1.4em;color:#444444;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;margin:0 0 1em 0;margin:0 0 20px 0">If you didn't sign up for {{ trans('app.site_name') }}, please disregard this email</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table border="0" cellspacing="0" width="100%" cellpadding="20" bgcolor="#f6f7f8" style="width:100%;background-color:#f6f7f8;text-align:left;border-top:1px solid #dddddd">
                    <tbody>
                    <tr>
                        <td style="border-top:1px solid #f3f3f3;color:#888;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;font-size:14px;background:#efefef;margin:0;padding:10px 20px 20px">
                            <p style="direction:ltr;font-size:14px;line-height:1.4em;color:#444444;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;margin:0 0 1em 0;font-size:12px;line-height:1.4em;margin:0 0 0 0">
                                <strong>Trouble clicking?</strong> Copy and paste this URL into your browser: <br><a style="text-decoration:underline;color:#2585b2" href="{{ $verificationUrl }}" target="_blank">{{ $verificationUrl }}</a>
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
@stop