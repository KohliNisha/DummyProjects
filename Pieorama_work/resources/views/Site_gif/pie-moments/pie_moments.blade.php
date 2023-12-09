@extends('layouts.site.web.webapp')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<style type="text/css">
	.mfp-hide{
		display: none !important;
	}
	.mfp-close{
		color: #fff;
    margin-right: 194px;
    background-color: #fff;
	}
	video{
		width: 658px;
	}
	
</style>
@section('content')
   
<!-- right-panel -->
<div class="right_panel home_right_panel">
	
	@if($pie_moments)
	<div class="vd_container">
		<div class="video_list home_video_list">
			<ul class="christanPieograms-wrapper clearfix">				  
				@if($pie_moments)
				@foreach($pie_moments as $pie)
				<?php
					$video_idddd=base64_encode($pie->id);

					$video_idddd=urlencode(base64_encode($video_idddd));
				?> 
				<?php
				if($pie->original_video_path != ''){
					$videoUrl = url("uploads/").'/'.$pie->file_name;
				}else{
					$videoUrl = '';
				}
				

				?>
				<li>
					<div class="vid_bx">
						<div class="thumbnail" onmouseover="bigImg('<?php echo url('/').'/view/?p='.$video_idddd; ?>', '<?php echo $pie->id; ?>')" onmouseout="bigImg2('<?php echo url('/').'/view/?p='.$video_idddd; ?>', '<?php echo $pie->id; ?>')">

							<!-- <a title='View Pie Video' class='btn btn-gradient-primary btn-sm videotest_{{$pie->id}}' data-id='"{{$pie->id}}"' video_url='{{$videoUrl}}' onclick='show_video("{{$pie->id}}")' style="cursor: pointer;">
							<img src="<?php echo url("uploads/").'/'.$pie->video_thumbnail_file_path;  ?>" alt="image" class="imghome_<?php echo $pie->id; ?>" > --> 

						   
							<a title='View Pie Video' class='btn btn-gradient-primary btn-sm videotest_{{$pie->id}}' data-id='"{{$pie->id}}"' video_url='{{$videoUrl}}' onclick='show_video("{{$pie->id}}")' style="cursor: pointer;">
								 <img src="<?php echo url("uploads/").'/'.$pie->video_thumbnail_file_path;  ?>" alt="image" class="imghome_<?php echo $pie->id; ?>" > 
									   <video  data-play = "Hover"  class="postervideo1_<?php echo $pie->id; ?>" style="display: none; width: 100%; height: 137px;" muted="muted">
									  	 <source src="<?php echo url("uploads/").'/'.$pie->file_name;  ?>" type="video/mp4">

								 	  </video> 
								
								
								
								<div class="middle">
									<div class="text"><h5>{{ substr($pie->title, 0,28) }}</h5></div>
								</div>
								<div class="middle">
									<div class="text">{{ substr($pie->piable_description, 0,140) }}</div>
								</div>
							</a>
						</div>

					<!-- <div id="pie-story_{{$pie->id}}" class="mfp-hide" style="max-width: 75%; margin: 0 auto;">
					<iframe width="560" height="550" src="<?php echo url("uploads/").'/'.$pie->file_name;  ?>" frmaborder = "0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					</div>  -->
						<div class="video-details">
							
							
							<div class="thumbnail-content">
								<div class="row justify-content-between mt-2 mb-2">
									
									<div class="col-auto"><span class="Date">{{$pie->NewCreatedDate}}</span></div>
								</div>
							</div>
							<div class="entry-meta post-meta meta-font">
								<div class="post-meta-wrap">
									<div class="view-count">
										No. of used
										<span>{{$pie->used}}</span>
									</div>
									
									
								</div>
							</div>
						</div>
					</div>
				</li>
				@endforeach
				@endif
			</ul>
		</div>
	</div>
	@endif
</div>
<a  style="display:none;" class="watch" href="http://smartzitsolutions.com/pieorama/public/uploads/Sample320.mp4" data-lity=""><i class="fa fa-play" aria-hidden="true"></i> Watch Video</a>
@endsection



<script src="{{ asset('website/js/jquery.min.js')}}"></script>
<script  src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
<script type="text/javascript">
	function show_video(id)
	{
		var val= $('.videotest_'+id).attr('video_url');	

		$('.watch').attr('href',val); 
		$('.watch').trigger('click');
		 
	}
	function bigImg(x,y) {	
	
		    $('.imghome_'+y).hide();
			$('.playhide_'+y).hide();
	    	$('.postervideo1_'+y).show();
	        $('.postervideo1_'+y)[0].play();
	        
	     
		     setTimeout(function(){
			
				$('.postervideo1_'+y)[0].pause();
					
				},6000);
	 }

	function bigImg2(x,y) {	
	
		$('.postervideo1_'+y)[0].pause();
		$('.postervideo1_'+y).hide();
		$('.playhide_'+y).show();
		$('.imghome_'+y).show();
		$('.postervideo1_'+y)[0].load();
		
	}
	$(document).ready(function ($) {
	    $('.pie-link').magnificPopup({
		type: 'inline',
		midClick:true,
		closeBtnInside:true,

		/* gallery: {
			 enabled: true,
			 navigateByImgClick: true,
			 preload: [0,1]
			 },*/

		});
	
	$('.mfp-close').trigger('click');
	});
	



</script>