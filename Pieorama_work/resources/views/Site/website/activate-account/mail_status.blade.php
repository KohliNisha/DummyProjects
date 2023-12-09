@extends('layouts.site.web.webapp')
@section('content')
<style type="text/css">
    @media only screen and (max-width: 479px) {
    .topHd {font-size:16px !important;}
	.middleBx {font-size:14px !important; line-height:22px !important; padding:10px !important;}
	.offerBox {float:none !important; width:100% !important; padding-top:20px !important;}
	.offerHd {padding-bottom:0 !important;}
	.message{font-size: 18px;}
    }
     .sucmessage { font-size: 18px; font-weight: 400; margin: 20px; color: green; font-family: none; text-align: center;  }
</style>

     <section class="contact-sec" style="background: url('images/images/bg-cr.png') top right no-repeat #ececec;">
		<div class="container">
			
			
  <table cellpadding="0" cellspacing="0" width="100%" align="center" bgcolor="#ffffff" style="border-top:3px solid #e4e4e4; max-width:75%; margin: auto;">
	<tr>
    	<td style="padding:15px 15px 0 15px;" align="center"><img src="{{ asset('images/logo.png') }}" alt="" style="vertical-align:top;"></td>
    </tr>
    <tr>
    	<td style="padding:10px 15px; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#000" class="topHd" align="center"> Powering Africa Through Business Growth</td>
    </tr>
    <tr>
    	<td><img src="{{ asset('images/Untitled-1.jpg') }}" alt="" style="vertical-align:top; width:100%;"></td>
    </tr>
    <tr>
    	<td class="middleBx" style="padding:20px 90px; font-size:16px; font-family:Arial, Helvetica, sans-serif; color:#3a3a3a; line-height:24px;">
    		<br/>
    		<div class="message">
    			

    		<div>
    			<br/>
    			<p class="sucmessage">{{$message}}</p>
                <p class="sucmessage"> Thank You </p>
            </div>
    		<br>
    		<br>
    		<br>

    	
    		</div>
    		
            
         	
        
        <?php //echo $ddd ; ?>          
        </td>
    </tr>
    <tr>
    	<td><img src="{{ asset('images/bot_bg.gif') }}" alt="" style="vertical-align:top; width:100%;"></td>
    </tr>
</table>
			
		
		</div>		
	</section>
	
@endsection         
