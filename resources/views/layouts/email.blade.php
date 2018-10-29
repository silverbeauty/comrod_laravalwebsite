<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Email</title>
</head>
<body>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#e9eaed" style="width:100%;background:#e9eaed">
        <tbody>
            <tr>
                <td>
                    <table border="0" cellspacing="0" cellpadding="0" align="center" width="550" style="width:100%;padding:10px">
                        <tbody>
                            <tr>
                                <td>
                                    <div style="direction:ltr;max-width:600px;margin:0 auto">
                                        @yield('content')
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="width:100%;padding-bottom:2em;color:#555555;font-size:12px;height:18px;text-align:center;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif">
                        <tbody>
                            <tr>
                                <td align="center">
                                    <a href="" style="text-decoration:underline;color:#2585b2;font-size:14px;color:#555555!important;text-decoration:none;font-family:&quot;Helvetica Neue&quot;,Helvetica,Arial,sans-serif;color:#555!important;font-size:14px;text-decoration:none" target="_blank">Thanks for using {{ trans('app.site_name') }}</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>