@extends('layouts.site.web.webapp')
@section('content')
   
<!-- right-panel -->
<div class="right_panel home_right_panel">
	@if(Request::segment(1) != 'home')
	<div class="add_banner">

		@if($cookie_value == 1)
		<div class="bannerab" style='background: url("{{ $MainPageThumb }}") center center no-repeat; background-size: cover;'>
				
					<video id="mainvideo" class="postervideo" width="100%" height="100%"  controls >
					<source src="{{  $MainPagevd }}"
					type="video/mp4">
				</video>
				<span class="play_icon playvideo homebanner_playicon">
					<img src="https://media.pieorama.fun/uploads/Play_button.png" alt="image">
					<!-- <img src="{{ asset('website/images/Play_button.png')}}" alt="images"> -->
				</span>
				
				
				<span class="banner_close" id="closebtn">
					<img src="{{ asset('website/images/close.png')}}" alt="image">
					
				</span>
			</div>
			@else

			

				<div class="bannerab" >
				
					<video id="video2" class="" width="100%" height="100%"  controls autoplay="true"
    muted="muted">
					<source src="<?php  echo $MainPagevd ?>" type="video/mp4">
				</video>
				<span class="banner_close" id="closebtn">
					<img src="{{ asset('website/images/close.png')}}" alt="image">
				</span>
				
			</div>

		@endif

	</div>
	@if(isset($Allgif))
	@if(count($Allgif) > 0)
	
	<div class="vd_container" style="padding: 20px;">
		<div class="video_list home_video_list home_thumbnail_videoWrapp scrollpane" >
			<ul class="christanPieograms-wrapper clearfix" >
				@foreach($Allgif as $g)
				<li>
					<div class="vid_bx">
						<div class="thumbnail">
							<div class="gif_thumbnail_img_wrap">
								<img src="{{$g->video_animated_file_path}}" alt="image" class="imghome_114">
								<div class="thumbnail_hover_icon_wrap">
									<ul>
										<?php
										
										if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') && !strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
											$imgurl = $g->video_animated_file_path;
											
										}else{
											$imgurl = url('/getDownload').'/'.$g->id;
										}

										?>
										<li>
											<a href="{{$imgurl}}" style="cursor:pointer;"><img src="{{asset('website/images/download-icon.png')}}" alt="image" class="imghome"></a>
										</li>
										<li>
											<a onclick="copyUrlgif({{$g->id}})" style="cursor:pointer;"><img src="{{asset('website/images/copy-gif-link-icon.png')}}" alt="image" class="imghome"></a></li>
										<li>
											<a href="{{url('')}}/watch/?p={{$g->video_idddd}}" style="cursor:pointer;"><img src="{{asset('website/images/pieogram-icon.png')}}" alt="View PieOgram" class="imghome"></a></li>
										</ul>
									</div>
								</div>
							<input id="copyUrlgif_{{$g->id}}" class="copy-url-field" type="hidden" value="{{$g->video_animated_file_path}}">
							<div class="middle">
								<a href="{{url('')}}/watch/?p={{$g->video_idddd}}">
									<div class="text" title="{{$g->full_title}}">{{$g->title}}</div>
								</a>
							</div>
						</div>
					</div>
				</li>
				@endforeach
			</ul>

			@if(count($moregif) > 4)
				<div class="seemore_gifcorner">
				<a class="" @if(!empty(auth()->user()->id)) href=" {{url('/gif-corner')}}" @else href="javascript:;" data-toggle="modal" data-target="#myModal" @endif>Get more GIFs</a>
				</div>
			
			@endif

		</div>
</div>

@endif

@endif

	@if($welcome_message != '')
	<div class="banner-btoomContWrap" style="background-color: {{$background_color}};">
		<div class="vd_container wlcm_msg">
			<div class="banner-btoom-innerCont" style="color: {{$foreground_color}};">				
				<p >{!! $welcome_message !!} </p>				
			</div>
			<div class="readmore-btnWrap">
				<a href="javascript:;" class="readmore-btn" >
					<img src="{{asset('website/images/close.png')}}" align="">
				</a>
			</div>
		</div>
	</div>
	@endif
	@endif

	@if(isset($channels))
	<ul class="channelsfilter " id="channelsfilterID">

		
			<li class="channelclass current" data-tab = "0">
				<a class="btn btn-info btn-fill mr-2" id="channelsfilter" onclick="channelsfilter(0)">All</a>
			</li>
			@foreach($channels as $c)
				
				<li class="channelclass" data-tab = "{{$c->id}}">
					<a  class="btn btn-info btn-fill mr-2" id="channelsfilter_{{$c->id}}" onclick="channelsfilter({{$c->id}})">{{$c->channel_title}}</a>
				</li>
				
			@endforeach
		
	</ul>
	<input type="hidden" name="tag_id" id="tag_id" value="0">
	<div class="vd_container">
		<div class="video_list home_video_list home_thumbnail_videoWrapp scrollpane" >
			<ul class="christanPieograms-wrapper clearfix" id="results">	
				<!-- <div id="all_rows">
						 
				</div>
					<input type="hidden" id="start" value="0">
					<input type="hidden" id="end" value="8"> -->
					<input type="hidden" id="start" value="0">
					<input type="hidden" id="end" value="20">
					<div id="load_data"></div>
					<div id="load_channelsdata_0"></div>
					@foreach($channels as $c)
						<div id="load_channelsdata_{{$c->id}}"></div>
					@endforeach
					<div id="load_data_message" style=""></div>
			</ul>
		</div>
</div>
	@endif
	

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script type="text/javascript">

	 $(document).ready(function(){
	 	
	 	$('#closebtn').click(function () {
			$('#mainvideo').remove();
			});
	 	//var x = document.getElementById("video2");
	 	 
	 	
	 });

	 
</script>
<script>
// Add current class to the current button (highlight it)
var header = document.getElementById("channelsfilterID");
var btns = header.getElementsByClassName("channelclass");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
  var current = document.getElementsByClassName("current");
  current[0].className = current[0].className.replace(" current", "");
  this.className += " current";
  });
}
</script>
<script type="text/javascript">

   $(document).ready(function(){
   		
   	var current_tab = $('ul#channelsfilterID').find('li.current').data('tab');
   	
	channelsfilter(current_tab);
   });
   function channelsfilter(current_tab){

   	channel = current_tab;
   	var limit = $('#end').val();
	var start = $('#start').val();
	start = 0;
	limit = 20;
	$('#start').val(start);
	$('#end').val(limit);
	
    videoData(limit,start,channel,appenddata);
   	//channelsvideo();
   	/*var limit = 8;
 	var start = 0;*/
 
   }

 	var limit = $('#end').val();
 	 var start = $('#start').val();
 	 var appenddata = 0;
 	 
	function videoData(limit,start,channel,appenddata){
		
		
		$.ajax({
			url: '{{ route("site.sendData")}}',
			method: 'post',
			data: {
				start: start,
				//type: type,
				end: limit,
				channel:channel,
				_token: '{{csrf_token()}}'
			},
			cache:false,
			 success: function (response) {
			 	console.log(response);
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
				
				
			    //var path = "{!! config('constants.ADMIN_URL') !!}/uploads";
			 	//var path = "{!! url('/uploads/'); !!}"; 
			 	
			 	
				if(value.video_thumbnail_file_path!='')
				{
				var thumb=value.video_thumbnail_file_path;
				
				var img=thumb;
					
				}
				if(value.video_file_path != ''){
					var video_path = value.video_file_path;
					
				}else{
					var video_path = '';
				}
				var videowatch = '{!! url('/watch'); !!}/?p='+value.video_idddd;
				var userprofile_url = '{!! url('/pieorama-user-profile'); !!}/'+value.userprofile_id;
				var title = value.title;
				var full_title = value.video_title;
			
			   //if(value.video_thumbnail_file_path != null && value.video_thumbnail_file_path != ''){
				  str = str + '<li>';
				  str = str + '<div class="vid_bx">';
				  str = str + '<div class="thumbnail" >';
				  str = str + '<a href="'+videowatch+'" >';
				  str = str + '<img src="'+img+'" alt="image" class="imghome_'+value.id+'" >';
				  str = str + '<video  data-play = "Hover"  class="postervideo1_'+value.id+'" style="display: none; width: 100%; height: 137px;" muted="muted">';
				  str = str + ' <source src="'+video_path+'" type="video/mp4">';
				  str = str + '</video> ';
				  str = str + '<div class="middle">';
				  str = str + '<div class="text" title="'+full_title+'">'+title+'</div>';
				  
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
				 str = str + '<div class="col-auto">';
				 if('{{(empty(auth()->user()))}}'){
				 	str = str + '<a href="javascript:;" data-toggle="modal" data-target="#myModal" style="color:#000;"><span class="category w-100 mb-0">'+first+' '+last+'</span></a>';
				 }else{
				 	str = str + '<a href="'+userprofile_url+'" style="color:#000;"><span class="category w-100 mb-0">'+first+' '+last+'</span></a>';
				 }
				 
				 str = str + '</div>';
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
				//}

				 i++;

				  
				 });
				if(appenddata == 1){
					$('#load_data').append(str);
				}else{
					$('#load_data').html(str);
				}
				
				 
				 if((Object.keys(response.AllVideos).length < 20) && (Object.keys(response.AllVideos).length != 0)){
				 		
				 		
				 		$('#load_data_message').hide();
				 		
					} else if(response.AllVideos == ''){
						$('#load_data_message').show();
						$('#load_data_message').html('<h4 style="text-align:center;">No Records Found</h4>');
					}else{
						$('#load_data_message').show();
						$('#load_data_message').html('<div class="seemore_gifcorner"><a  href="javascript:;" onclick="loadmore()">Show more</a><div>');
					}
						
						
					
			 
				}
		});
		
	}
	function loadmore(){
		var limit = $('#end').val();
 	 	var start = $('#start').val();
 		start = parseInt(start) + 20;
		limit = parseInt(limit) + 20;
		$('#start').val(start);
		$('#end').val(limit);
		var channel = $('ul#channelsfilterID').find('li.current').data('tab');
		var appenddata = 1;
	 	//action = 'active';
	 	videoData(limit,start,channel,appenddata);

}


$( document ).ready(function() {
	var myVideo = document.getElementById("mainvideo");
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

	// readmore and less content
	
	$('.readmore-btn').click(function(){
		$('.banner-btoomContWrap').hide();
		
	});
});	

</script>
@endsection