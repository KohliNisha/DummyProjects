@extends('layouts.site.web.webapp')
@section('content')
	<!-- right-panel -->
	<div class="right_panel prof-wrapper">
		<div class="vd_container">
			<div class="prof-top-sec">
				<div class="ueser-detail">
					<div class="user-image">
		                 <?php if($user->profile_image) { ?>
					     <img src="{{ $user->profile_image }}" alt="">
					     <?php }  else { ?> 
                         <img src="{{ asset('website/images/nouserimage.png')}}" alt="">	
					     <?php } ?>
					</div>					
					<div class="ueser-detail-in">
						<h2 class="channel-heading">{{ $user->first_name . ' ' . $user->last_name}}</h2>
						@if($user->email)
						<p class="profile-subheading"> {{ $user->email}} </p>
						@endif
	 					<p class="profile-subheading">
	 				     @if($userAddress)		
	    				  @if($userAddress->city || $userAddress->state || $userAddress->country )
     						{{ $userAddress->city .' '. $userAddress->state .' '. $userAddress->country }}
						   @endif	
						
		            		@if($user->phone_number)
				  	 	    ({{ $user->phone_code .''. $user->phone_number  }})
				 	       @endif
				 	     @endif  
						</p>

						<div class="mt-3">
							<button class="btn btn-primary edit-prof-btn">Add Friend</button>
						</div>
					</div>
				</div>
			</div>
			<h1 class="channel-heading">{{ $user->first_name }}’s Pieograms</h1>
			<div class="video_list">
				@if(!$videoDetails->isEmpty())
				<ul class="christanPieograms-wrapper clearfix">
				   <?php  foreach($videoDetails as $ChannelVideosItem) { ?>	
				    <li>
				    	<div class="vid_bx">
				    		<div class="thumbnail">
				    			<a href="{!! url('pieogram-details/'.base64_encode(base64_encode($ChannelVideosItem->id)).'/'.$ChannelVideosItem->video_title)  !!}" >
					    			<img src="{{$ChannelVideosItem->video_thumbnail_file_path}}" alt="image" class="poster">
					    			<span class="play_icon">
					    				<img src="{{ asset('website/images/play.png')}}" alt="images">
					    			</span>
					    		</a>
				    		</div>
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
				    	</div>
				    </li>
				     <?php } ?>
				</ul>
				   @else

				     No pieogram created yet.

                    @endif
			</div>
		</div>
	</div>
@endsection 