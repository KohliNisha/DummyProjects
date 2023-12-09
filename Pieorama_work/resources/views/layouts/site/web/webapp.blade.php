<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

	
	@if(Request::segment(1) == 'home')
	<title>PieOrama :: Home</title>
	@elseif(Request::segment(1) == 'gif-corner')
	<title>PieOrama :: GIF Corner</title>
	@elseif(Request::segment(1) == 'contact-us')
	<title>PieOrama :: Contact</title>
	@elseif(Request::segment(1) == 'watch')
	 	@if(isset($videoDetails))
	      	<title>{{$videoDetails->video_title}}</title>	
	 	 @endif
	@elseif(Request::segment(1) == 'about-pieorama') 
	<title>PieOrama :: About</title>
	@else
	<title>PieOrama :: Welcome</title>
	@endif
	<!-- Google Font -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Average|Bitter:400,400i,700&display=swap" rel="stylesheet">
	<!-- font-awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- slick-css -->
	<link rel="stylesheet" href="{{ asset('website/css/slick.css')}}">
	<!-- scroll-bar-css -->
	<link rel="stylesheet" href="{{ asset('website/css/jquery.mCustomScrollbar.css')}}">
	<!-- bootstrap css -->
	<link rel="stylesheet" href="{{ asset('website/css/bootstrap.min.css')}}">
	<!-- jquery-ui css -->
	<link rel="stylesheet" href="{{ asset('website/css/jquery-ui.css')}}">
	<!-- style css -->
	<link rel="stylesheet" href="{{ asset('website/css/style.css')}}">
	<link rel="stylesheet" href="{{ asset('vendors/css/lity.css')}}">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	

	<meta https-equiv="Cache-Control" content="public, max-age=604800, immutable" />
	
	<meta https-equiv="Content-Security-Policy" content="default-src 'self'; img-src 'self' pieoramaspace.nyc3.digitaloceanspaces.com www.googletagmanager.com; media-src 'self' pieoramaspace.nyc3.digitaloceanspaces.com; script-src 'self' www.google-analytics.com ajax.googleapis.com cdnjs.cloudflare.com www.googletagmanager.com; style-src 'self' fonts.googleapis.com; child-src 'none';" />

	<meta https-equiv="Content-Type" content="text/html; charset=UTF-8; X-Content-Type-Options=nosniff" />
	<meta https-equiv="Strict-Transport-Security" content="max-age=63072000; includeSubDomains; preload" />
	<meta https-equiv="X-Frame-Options" content="deny" />
	<meta https-equiv="X-XSS-Protection" content="1; mode=block" />

	



	<meta property="fb:app_id" content="455316068433476" />
	<meta property="og:site_name" content="PieOrama">
	<meta property="og:image:width" content="1200" />
	<meta property="og:image:height" content="628" />

	
	@if(isset($videoDetails))
	@if(isset($video_user))
		<?php
			 $name=$video_user['user_firstname'].' '.$video_user['user_lastname'];
		?>
		 <meta name="author" content="<?php echo $name; ?>">
	@endif
	@if(isset($video_user['video_tags']))
	 <?php

							
		$tag_namee='';
		if(!empty($video_user['video_tags']))
		{
			
		foreach($video_user['video_tags'] as $row)
		{

		if($row['tag_name'] != '')
		{	
		$tag_namee =''.$row['tag_name'].' ';
		?>
		<meta name="keywords" content="<?php echo substr($tag_namee,0,-1); ?>">
		
		<?php
		}
		}	 
		?>
		
		<?php
		}?>
			
	
	 
	 @endif


	

		 @if(isset($videoDetails->video_title))
		    <?php
		     $title = trim($videoDetails->video_title, '"');
		    ?>
		        <meta property="og:title" content="<?php echo $title; ?>">
		   @endif
		
		@if(isset($videoDetails->video_description))
		 <?php
		    $desc1 = trim($videoDetails->video_description, '"');

			$desc1 = substr($desc1, 0,140);
			$desc=str_ireplace('<p>','',$desc1);
			$desc = str_ireplace('</p>','',$desc);  
		    ?>
			<meta property="og:description" content="<?php echo $desc; ?>">
		@endif
		@if(isset($videoDetails->video_large_thumbnail_file_path))
			<?php
							
				$imgtest = $videoDetails->video_large_thumbnail_file_path;

				$imgshare = str_replace(' ', '%20', $imgtest);
			
			
			?>
			<meta property="og:image" content="<?php echo $imgshare; ?>">
		@endif

		<meta property="og:url" content="<?php echo (Request::fullUrl()); ?>">
		

		@if(isset($videoDetails->video_title))
		 <?php
		     $title = trim($videoDetails->video_title, '"');
		    ?>
			<meta name="twitter:title" content="<?php echo $title; ?>">
		@endif
		

		@if(isset($videoDetails->video_description))
		 <?php
		     $desc1 = trim($videoDetails->video_description, '"');

			$desc1 = substr($desc1, 0,140);
			$desc=str_ireplace('<p>','',$desc1);
			$desc = str_ireplace('</p>','',$desc);  
		    ?>
			<meta name="twitter:description" content="<?php echo $desc; ?>">
		@endif
		

		@if(isset($videoDetails->video_large_thumbnail_file_path))
			<?php
							
				$imgtest = $videoDetails->video_large_thumbnail_file_path;

				$imgshare = str_replace(' ', '%20', $imgtest);
			
			
			?>
			
			<meta name="twitter:image"  content="<?php echo $imgshare; ?>">
		@endif
		<meta name="twitter:card" content="summary_large_image">
		<meta property="twitter:url" content="<?php echo (Request::fullUrl()); ?>">
	@else
		
		<meta name="twitter:title" content="">
		<meta name="twitter:description" content="">
		<meta name="twitter:image"  content="">
		<meta name="twitter:card" content="summary_large_image">
	@endif
</head>

<body>
	<!-- <img class="gifplay loder-image" src="{{ asset('website/images/Flying pie.gif')}}"> -->
	<div class="se-pre-con" ></div>
	
	@include('layouts.site.web.header')
	@yield('content')
	@include('layouts.site.web.footer')
	
  <script src="{{ asset('vendors/js/lity.js')}}"></script>
<script src="{{ asset('js/cookies/dist/jquery.cookieMessage.min.js')}}"></script>
<!-- <script src="{{ asset('js/cookies/dist/jquery.cookieMessage.js')}}"></script> -->
<script type="text/javascript">
$.cookieMessage({
  'mainMessage': 'This website uses cookies. By using this website you consent to our use of these cookies. For more information visit our <a href="https://www.pieorama.fun/privacy-policy">Privacy Policy</a>. ',
  'acceptButton': 'Got It!'
});


</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-7WFWXB423F"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-7WFWXB423F');
</script>

</body>

</html>
