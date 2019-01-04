<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="max-width:600px; width: 100%; border: 1px solid #e5e5e5">
            <tr>
              <td style="text-align: center; background: #014694; padding: 20px;"><a href="/" target="_blank"><img src="{{asset('images/msc-logo.png')}}" alt="Dosarest" height="48px" style="margin:0; display:inline-block; border:none; line-height:0px;"></a></td>
            </tr>
            <tr>
              <td style="background: #fff; padding: 40px 20px; text-align: center;">
                <h2 style="font-family:Arial, sans-serif, Gotham, 'Helvetica Neue', Helvetica; font-weight: bold; color: #414140; margin: 0 0 15px; padding: 0;"><strong style="font-size: 25px; font-weight: bold; color: #ee7546;display: block;">Welcome {{ $first_name." ".$last_name }}</h2>
                <p style="font-family:Arial, sans-serif, Gotham, 'Helvetica Neue', Helvetica; font-size: 19px; color: #797979; margin: 0 0 25px;line-height: 24px;">Your registeration is succefully on {{ $siteName }} <br/> You need to confirm your account. <br/>Just press the button below</p>
                <a href="{{ $url }}" style="display: block; width: 150px; border: 2px solid #ee7546; color: #ee7546; text-decoration: none; font-family:Arial, sans-serif, Gotham, 'Helvetica Neue', Helvetica; font-weight: bold; padding: 5px; margin: 0 auto; font-size: 14px;">Click Here</a>
              </td>
            </tr>
            <tr>
                <td style="text-align: center; padding: 15px; color: #a2a2a2; font-family: Arial, sans-serif, Gotham, 'Helvetica Neue', Helvetica; font-size: 12px;  border-bottom: 2px solid #f0f0f0; line-height: 20px; background: #414140;">
                    <strong style="font-weight: normal; color: #ee7546;">© {{ $siteName }}</strong> , {{ date('Y') }}}. All Rights Reserved. 
                </td>
            </tr>
          </table></td>
      </tr>  
    </table>
</body>
</html>