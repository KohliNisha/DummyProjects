@extends('layouts.site.web.webapp')
<style type="text/css">
	
	
</style>
@section('content')
   
<!-- right-panel -->
<div class="right_panel home_right_panel">
	<div class="add_banner">
		<div class="bannerab" style='background: url("{{ asset($MainPageThumb) }}") center center no-repeat; background-size: cover;'>
				<!-- <video id="video1" muted="muted" class="postervideo" width="100%" height="100%"  autoplay loop  style="display: block;"> -->
					<video id="video1" muted="muted" class="postervideo" width="100%" height="100%"  controls>
					<source src="{{  $MainPagevd }}"
					type="video/mp4">
				</video>
				<span class="play_icon playvideo">
					<img src="{{ asset('website/images/play.png')}}" alt="images">
				</span>
				<!-- <span class="seal_imageWrapper">
					<img class="seal_image" src="{{ asset('website/images/seal_texture.png')}}">
				</span> -->
				
				<span class="banner_close">
					<img src="{{ asset('website/images/close.png')}}" alt="image">
				</span>
			</div>


	</div>
	
</div>

<div class="vd_container">
		<div class="video_list home_video_list home_thumbnail_videoWrapp scrollpane" >
			<ul class="christanPieograms-wrapper clearfix" id="results">	
				<!-- <div id="all_rows">
						 
				</div>
					<input type="hidden" id="start" value="0">
					<input type="hidden" id="end" value="8"> -->
					<div id="load_data"></div>
					<div id="load_data_message"></div>
			</ul>
		</div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
 $(document).ready(function(){
 	var limit = 8;
 	 var start = 0;
 	 var action = 'inactive';

	function videoData(limit,start){
	
		/*var start = $('#start').val();
		var end = $('#end').val();*/
		///alert(start);
		//alert(end);
		$.ajax({
			url: '{{ route("site.sendData")}}',
			method: 'post',
			data: {
				start: start,
				end: limit,
				_token: '{{csrf_token()}}'
			},
			cache:false,
			 success: function (response) {
			 	console.log(response.AllVideos);
			 	var str = '';
			 	var i = 0;
			 	$.each(response.AllVideos, function(index, value) {
			 	
			 	var tags='';
				var first=$.trim(response.all_user[i].user_firstname);
				var last=$.trim(response.all_user[i].user_lastname);
				var view=$.trim(response.all_user[i].view); 
				var tags=response.all_user[i].tags;

				var totalsharecount=response.all_user[i].totalsharecount;
				var total_count_like=response.all_user[i].total_count_like;
				var total_count_dislike=response.all_user[i].total_count_dislike;
				var total_comment=response.all_user[i].total_comment;
				var updated_at=response.all_user[i].updated_at;
				
				

			 	var path = "{!! url('/uploads/'); !!}"; 
			 	var img='https://via.placeholder.com/300';
			 	
				if(value.video_thumbnail_file_path!='')
				{
				var thumb=value.video_thumbnail_file_path;
				//var str1=strpos(thumb, 'cloudinary');
				//if (str1=='') 
				//{
				var img=path+'/'+thumb;
				//}		
				}
				if(value.video_file_path != ''){
					var video_path = path+'/'+value.video_file_path;
					//dd($video_path);
				}else{
					var video_path = '';
				}
				var videowatch = '{!! url('/watch'); !!}/?p='+value.video_idddd;
				var title = value.video_title;
				title = title.substring(0, 28);
				  str = str + '<li>';
				  str = str + '<div class="vid_bx">';
				  str = str + '<div class="thumbnail" onmouseover="bigImg('+value.id+')" onmouseout="bigImg2('+value.id+')">';
				  str = str + '<a href="'+videowatch+'" >';
				  str = str + '<img src="'+img+'" alt="image" class="imghome_'+value.id+'" >';
				  str = str + '<video  data-play = "Hover"  class="postervideo1_'+value.id+'" style="display: none; width: 100%; height: 137px;" muted="muted">';
				  str = str + ' <source src="'+video_path+'" type="video/mp4">';
				  str = str + '</video> ';
				  str = str + '<div class="middle">';
				  str = str + '<div class="text">'+title+'</div>';
				  
				  str = str + '</div>';
				  str = str + '</a>';
				  str = str + '</div>';
				  str = str + '<div class="video-details home-videoDetails-wrap">';
				  str = str + '<h4>';
				  var tag_name='';
				  
				
			  		if(tags != ''){
			  			$.each(tags, function(index, d) {

			  				if(d.tag_name != ''){

			  					var tag_name ='#'+d.tag_name+' ';
			  					 //tag_name = tag_name.substring(0, -1);
			  					 //console.log(tag_name);
			  					   str = str + '<span>'+tag_name+'</span>';
			  				}
			  			});
			  		}
				  	

				 str = str + '</h4>';
				 str = str + '<div class="thumbnail-content">';
				 str = str + '<div class="row justify-content-between mt-2 mb-2">';
				 str = str + '<div class="col-auto"><span class="category w-100 mb-0">'+first+' '+last+'</span></div>';
				 str = str + '<div class="col-auto"><span class="Date">'+updated_at+'</span></div>';
				 str = str + '</div>';
				 str = str + '</div>';
				 str = str + '<div class="entry-meta post-meta meta-font">';
				 str = str + '<div class="post-meta-wrap">';
				 str = str + '<div class="view-count">';
				 str = str + '<i class="fa fa-eye" aria-hidden="true"></i>';
				 str = str + '<span>'+view+'</span>';
				 str = str + '</div>';
				 str = str + '<div class="like-count">';
				 str = str + '<i class="fa fa-thumbs-up" aria-hidden="true"></i>';
				 str = str + '<span class="like-count" data-id="'+total_count_like+'">'+total_count_like+'</span>';
				 str = str + '</div>';
				 str = str + '<div class="dislike-count">';
				 str = str + '<i class="fa fa-thumbs-down" aria-hidden="true"></i>';
				 str = str + '<span class="dislike-count" data-id="'+total_count_dislike+'">'+total_count_dislike+'</span>';
				 str = str + '</div>';
				 str = str + '<div class="comment-count">';
				 str = str + '<i class="fa fa-comment-o" aria-hidden="true"></i>';
				 str = str + '<span class="dislike-count" data-id="'+total_comment+'">'+total_comment+'</span>';
				 str = str + '</div>';
				 str = str + '<div class="share-count">';
				 str = str + '<i class="fa fa-share-alt" aria-hidden="true"></i>';
				 str = str + '<span class="dislike-count" data-id="'+totalsharecount+'">'+totalsharecount+'</span>';
				 str = str + '</div>';
				
				 str = str + '</div>';
				 str = str + '</div>';
				 str = str + '</div>';
				 str = str + '</div>';
				 str = str + '</li>';

				 i++;

				  //console.log(str);
				 });
			 	 
				 $('#load_data').append(str);
				 if(response == ''){
				 		$('#load_data_message').html("<h4> No record found</h4>");
				 		action = 'active';
					}else{
						$('#load_data_message').html("<i class='fa fa-spinner fa-pulse' style='font-size: 55px; margin-left: 575px;'></i>");
						action = 'inactive';
					}
			 
				}
		});
		
	}
	
if(action == 'inactive'){
	action = 'active';
	videoData(limit,start);
}
	
	$(window).scroll(function() {
		if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive') {
			action = 'active';
			start = start + 8;
			limit = limit + 8;
			setTimeout(function(){
				videoData(limit,start);
	         //videoData();
			} ,1000);
	    }
	});
	
});






	function bigImg(y) {	
		
		    $('.imghome_'+y).hide();
			$('.playhide_'+y).hide();
	    	$('.postervideo1_'+y).show();
	        $('.postervideo1_'+y)[0].play();
	        
	     
		     setTimeout(function(){
			
				$('.postervideo1_'+y)[0].pause();
					
				},6000);
	 }

		function bigImg2(y) {	
		
			$('.postervideo1_'+y)[0].pause();
			$('.postervideo1_'+y).hide();
			$('.playhide_'+y).show();
			$('.imghome_'+y).show();
			$('.postervideo1_'+y)[0].load();
			
		}

$( document ).ready(function() {
	var myVideo = document.getElementById("video1");
	var backgroundImage  =  '{{ $MainPagebackgroundColor }}';
	$('.playvideo').click(function(event) {
	  $(this).parent(".bannerab").css("background", backgroundImage)
	  $(this).hide();
	  $(".postervideo").addClass('active')  
	  setTimeout(function(){ 
	    if (myVideo.paused) 
	    myVideo.play(); 
	  else 
	    myVideo.pause(); 
	   }, 
	    300); 
	  });
	});	

</script>