@extends('layouts.site.web.webapp')
@section('content')
   
<!-- right-panel -->
<div class="right_panel home_right_panel">
	
	<div class="vd_container">
		<div class="video_list home_video_list home_thumbnail_videoWrapp scrollpane" >
			<ul class="christanPieograms-wrapper clearfix" id="results">	
				<!-- <div id="all_rows">
						 
				</div>
					<input type="hidden" id="start" value="0">
					<input type="hidden" id="end" value="8"> -->
					<div id="load_gifdata"></div>
					<div id="load_gifdata_message" style="text-align:center;"></div>
					<div id="seemore_gif" style="text-align:right;"></div>
			</ul>
		</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>



<script type="text/javascript">
/*$( window ).on( "load", function() {
	alert('dsfsdgf');
        videoData(limit,start,1);
    });*/


// Safari 3.0+ "[object HTMLElementConstructor]" 
var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || (typeof safari !== 'undefined' && safari.pushNotification));



if(isSafari == true){
	var file = 'notdownloadable';
}else{
	var file = 'downloadable';
}




			  


  $(document).ready(function(){
 	var limit = 8;
 	 var start = 0;
 	 var action = 'inactive';
 	 //var type = 1;

	function gifdata(limit,start){
		
		
		$.ajax({
			url: '{{ route("site.gifdata")}}',
			method: 'post',
			data: {
				start: start,
				//type: type,
				end: limit,
				_token: '{{csrf_token()}}'
			},
			cache:false,
			 success: function (response) {
			 	console.log(response);
			 	var str = '';
			 	var i = 0;
			 	$.each(response.Allgif, function(index, value) {
			 	
			 	
				if(value.video_animated_file_path!='' && value.video_animated_file_path != null)
				{
				var thumb=value.video_animated_file_path;
				
				var img=thumb;
					
				}else {
					var img='{{asset("images/placeholder.png")}}';
				}
				
				var videowatch = '{!! url('/watch'); !!}/?p='+value.video_idddd;
				var download = '{!! url('/getDownload'); !!}/'+value.id;
				var title = value.title;
				var full_title = value.video_title;

				
				  str = str + '<li>';
				  str = str + '<div class="vid_bx">';
				  str = str + '<div class="thumbnail" >';
				  //str = str + '<a href="'+videowatch+'" >';
				  str = str + '<div class="gif_thumbnail_img_wrap"><img src="'+img+'" alt="image" class="imghome_'+value.id+'" >';
				  if(value.video_animated_file_path){
				  str = str + '<div class="thumbnail_hover_icon_wrap">';
				  str = str + '<ul>';
				  if(file == 'notdownloadable'){
				  	 str = str + '<li><a href="'+img+'" style="cursor:pointer;"><img src="{{asset("website/images/download-icon.png")}}" alt="image" class="imghome" ></a></li>';
				  	}else{
				  		 str = str + '<li><a href="'+download+'" style="cursor:pointer;"><img src="{{asset("website/images/download-icon.png")}}" alt="image" class="imghome" ></a></li>';
				  	}
				 
				  str = str + '<li><a onclick = "copyUrlgif('+value.id+')" style="cursor:pointer;"><img src="{{asset("website/images/copy-gif-link-icon.png")}}" alt="image" class="imghome" ></a></li>';
				  //str = str + '<li><a><img src="{{asset("website/images/copy-gif-icon.png")}}" alt="image" class="imghome" ></a>';
				  if(value.video_file_path){
				  	  str = str + '<li><a href="'+videowatch+'" style="cursor:pointer;"><img src="{{asset("website/images/pieogram-icon.png")}}" alt="View PieOgram" class="imghome" ></a></li>';
				  }
				  /*str = str + '<li><a href="'+videowatch+'" style="cursor:pointer;"><img src="{{asset("website/images/pieogram-icon.png")}}" alt="View PieOgram" class="imghome" ></a></li>';*/
				 
				 
				  
				  str = str + '</ul>';
				  str = str + '</div>';
				  }
				  str = str + '</div>';
				  str = str + '<input id="copyUrlgif_'+value.id+'" class="copy-url-field" type="hidden" value="'+img+'">';
				  str = str + '<div class="middle">';
				  str = str + '<a href="'+videowatch+'" ><div class="text" title="'+full_title+'">'+title+'</div></a>';
				  
				  str = str + '</div>';
				 // str = str + '</a>';
				  str = str + '</div>';
				  
				 str = str + '</div>';
				 str = str + '</li>';

				 i++;

				  //console.log(str);
				 });
			 	 
				 $('#load_gifdata').append(str);
				 if(response.Allgif == ''){
				 	
				 		//$('#load_data_message').html("<h4> No record found</h4>");
				 		$('#load_gifdata_message').hide();
				 		
				 		action = 'active';
					}else if('{{(empty(auth()->user()))}}')
					{
						$('#seemore_gif').html("<div class='seemore_gifcorner'><a href='javascript:;' data-toggle='modal' data-target='#myModal' class='' style='margin: 20px;'>Get more GIFs</a><div>");
					}

					else{
						
						$('#load_gifdata_message').html("<i class='fa fa-spinner fa-pulse' style='font-size: 55px;'></i>");
						action = 'inactive';
					}
			 
				}
		});
		
	}
	
if(action == 'inactive'){
	action = 'active';
	gifdata(limit,start);
}
	
	$(window).scroll(function() {
		if($(window).scrollTop() + $(window).height() > $("#load_gifdata").height() && action == 'inactive') {
			action = 'active';
			start = start + 8;
			limit = limit + 8;
			setTimeout(function(){
				gifdata(limit,start);
	         //videoData();
			} ,1000);
	    }
	});
	
});

function downloadfile(id) {
         var url = "your file url";
          e.preventDefault();
         window.location.href = url;
}


</script>

@endsection