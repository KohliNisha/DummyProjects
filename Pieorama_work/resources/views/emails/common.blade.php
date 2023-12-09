<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width">
<title>Plendify</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8; X-Content-Type-Options=nosniff" />

<meta http-equiv="Content-Security-Policy" content="default-src 'self'; img-src 'self' https://pieoramaspace.nyc3.digitaloceanspaces.com; media-src 'self' https://pieoramaspace.nyc3.digitaloceanspaces.com; script-src 'self'; style-src 'self' https://fonts.googleapis.com; child-src 'none';">

<meta http-equiv="Strict-Transport-Security" content="max-age=63072000; includeSubDomains; preload">

<meta http-equiv="X-Frame-Options" content="deny">

<meta http-equiv="X-XSS-Protection" content="1; mode=block">

<meta http-equiv="Cache-Control" content="public, max-age=604800, immutable">


<style type="text/css">
    @media only screen and (max-width: 479px) {
    .topHd {font-size:16px !important;}
	.middleBx {font-size:14px !important; line-height:22px !important; padding:10px !important;}
	.offerBox {float:none !important; width:100% !important; padding-top:20px !important;}
	.offerHd {padding-bottom:0 !important;}
    }
</style>
</head>
<body style="background:#f6f2f2;">
<table cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#ffffff" style="border-top:3px solid #e4e4e4; max-width:600px;">
	<tr>
    	<td style="padding:15px 15px 0 15px;" align="center"><img src="{{ asset('images/AnimatedPieOram_logo_2_small.gif') }}" alt="" style="vertical-align:top;"></td>
    </tr>
    <tr>
    	<!-- <td style="padding:10px 15px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#000" class="topHd" align="center">Pieorama is an amazing video maker</td> -->
    </tr>
    <tr>
    	<!-- <td><img src="{{ asset('images/Untitled-1.jpg') }}" alt="" style="vertical-align:top; width:100%;"></td> -->
    </tr>
    <tr>
    	<td class="middleBx" style="padding:20px; font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#3a3a3a; line-height:24px;">
            
            
         <?php echo $html_body;?>
        
        <?php //echo $ddd ; ?>  


        </td>
    </tr>
    <tr>
       
    	<!-- <td><img src="{{ asset('images/AnimatedPieOram_logo_2_small.gif') }}" alt="" style="vertical-align:top; width:16%;"></td> -->

           
           
            @if(isset($email))
            <?php
                $encryptedemail = encrypt($email);

            ?>
            @else
            <?php
                $encryptedemail = '';

            ?>
            @endif
             @if(isset($name))
            <?php
                $encryptedname = encrypt($name);

            ?>
            @else
            <?php
                $encryptedname = '';

            ?>
            @endif
           <td class="middleBx" style="padding:20px; font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#3a3a3a; line-height:24px;"> 
            <a href="{{url('/')}}/contact-us" target="_blank">Contact Us</a>&nbsp; |&nbsp;&nbsp;<a href="{{url('/')}}/get-help" target="_blank">Get Help</a>&nbsp; |&nbsp;&nbsp;<a @if($encryptedemail == '' && $encryptedname == '')  href="{{url('/')}}/unsubscribed-confirmation" @else href="{{url('/')}}/unsubscribe-confirmation/{{$encryptedemail}}/{{$encryptedname}}" @endif target="_blank">Unsubscribe</a></td>
        
    </tr>
    
</table>

</body>
</html>
