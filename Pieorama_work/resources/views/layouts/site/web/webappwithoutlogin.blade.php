<!DOCTYPE html>
<html lang="en">
<head>  
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  	<title>Welcome to Pieorama</title>
  	<!-- font-awesome -->
  	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
  	<!-- slick-css -->
  	<link rel="stylesheet" href="{{ asset('website/css/slick.css')}}">
  	<!-- scroll-bar-css -->
  	<link rel="stylesheet" href="{{ asset('website/css/jquery.mCustomScrollbar.css')}}">
  	<!-- bootstrap css -->
  	<link rel="stylesheet" href="{{ asset('website/css/bootstrap.min.css')}}">
  	<!-- style css -->
  	<link rel="stylesheet" href="{{ asset('website/css/style.css')}}">

    <link rel="stylesheet" href="{{ asset('website/css/jquery-ui.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
       
        @include('layouts.site.web.beforeloginheader')
        @include('layouts.site.web.navigation')
        @yield('content')
        @include('layouts.site.web.footer')
 </body>
</html>
