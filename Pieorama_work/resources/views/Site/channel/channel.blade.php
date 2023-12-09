@extends('layouts.site.web.webapp')
@section('content')
<!-- <body class="bg-white"> -->
	<!-- right-panel --> 
	<div class="right_panel1  channel-listWarp">
		<div class="vd_container vd_verticalHgt">
			<h1 class="channel-heading">{{$ChannelDetails->channel_title}}</h1>
			<div class="d-flex align-items-center justify-content-between">
				<div class="channel-subheading">{{$ChannelDetails->channel_description}}</div>
			</div>
			<div class="video_list">
				<ul class="christanPieograms-wrapper clearfix">				  
					@if($ChannelVideos)
				   <?php  
					$i=0;
					foreach($ChannelVideos as $ChannelVideosItem) { ?>	
				    <?php
					$first=trim($trending_user[$i]['user_firstname']);
					$last=trim($trending_user[$i]['user_lastname']);
					$view=trim($trending_user[$i]['view']);
					?>  
					<li>
				    	<div class="vid_bx">
				    		<div class="thumbnail">
				    			<a href="{!! url('pieogram-details/'.base64_encode(base64_encode($ChannelVideosItem->id)).'/'.$ChannelVideosItem->video_title)  !!}">
					    			<img src="{{$ChannelVideosItem->video_thumbnail_file_path}}" alt="image" class="poster">
					    			<span class="play_icon">
					    				<img src="{{ asset('website/images/play.png')}}" alt="images">
					    			</span>
					    		</a>
				    		</div>
				    		<div class="video-details">
								<h3>{{ substr($ChannelVideosItem->video_title, 0,37) }}</h3>
								<div class="d-block">
									<ul class="vid-upl-time clearfix">
										<li><?php 
										 $date =  $ChannelVideosItem->created_at;
										 echo $NewCreatedDate = date('d M Y', strtotime($date));
											  $NewCreatedTime = date('h:i A', strtotime($date));
										 ?></li>
										<li>{{$NewCreatedTime}}</li>
									</ul>
								</div>
								<p><?php echo $view; ?> Views</p>
				    		</div> 
				    	</div>
				    </li>
				     <?php 
					 $i++;
					 } ?>
                   @endif

				</ul>
			</div>
		</div>
	</div>
<!-- </body> -->
@endsection 