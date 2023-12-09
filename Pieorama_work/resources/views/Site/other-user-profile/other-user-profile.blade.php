@extends('layouts.site.web.webapp')
@section('content')
	<!-- right-panel -->
	<div class="right_panel prof-wrapper">
		<div class="vd_container">
			<div class="right_panel prof-wrapper my-prof-wrapper">
				<div class="">
					<div class="prof-top-sec">
						<div class="ueser-detail">
							<div class="user-image">
								<?php  
									if($user->profile_image == "" || $user->profile_image == null){ 
									echo "<span class='h_unfl'>"; 
									$fname = $user->first_name; 
									$fnameUser = substr($fname,0,1);
									echo strtoupper($fnameUser);
									echo "</span>";
									} else { ?>
									<img src="{{ $user->profile_image }}" alt="" class="h_prof-image">
									<?php } ?>
									

									@if(isset($id_exist))
									    @if($id_exist == 1)
									   <div class="badge_img"> 
											<img src="https://media.pieorama.fun/Pieoneer_badge_small.png" alt="badge picture" class="">
										</div>
										@endif
									@endif
												
								
							</div>

							
							<div class="ueser-detail-in">
								<h2 class="channel-heading">{{ $user->first_name. ' '. $user->last_name}}</h2>
									@if($user->email)
									<p class="profile-subheading"> {{ $user->email}} </p>
									@endif
									<p class="profile-subheading">
										@if($userAddress)		
										@if($userAddress->city && $userAddress->country )
										{{ $userAddress->city .', '. $userAddress->country }}
										@elseif($userAddress->city && $userAddress->country == '')
										{{$userAddress->city}}
										@elseif($userAddress->city == '' && $userAddress->country)
										{{$userAddress->country}}
										@endif
										{{--@if($user->phone_number)
										({{ $user->phone_code .''. $user->phone_number  }})
										@endif--}}
										@endif  
									</p>
								<div class="mt-3">
									<!-- <div class="mt-3">
										<button class="btn btn-primary edit-prof-btn">Add Friend</button>
									</div> -->
								</div>
							</div>
						</div>
					</div>
					
				</div>
</div>
			
			<h1 class="channel-heading">{{ $user->first_name }}’s Pieograms</h1>
			<div class="video_list home_video_list home_thumbnail_videoWrapp">
				
				@if(!$videoDetails->isEmpty())
				<ul class="christanPieograms-wrapper clearfix">
				   <?php  foreach($videoDetails as $ChannelVideosItem) { ?>	
				   	<li>
				   		<?php
							$video_idddd=base64_encode($ChannelVideosItem->id);
							$video_idddd=urlencode(base64_encode($video_idddd));
							$video_idddd=str_replace('%3D%3D', '', $video_idddd);

							if($ChannelVideosItem->video_thumbnail_file_path!='')
								{
								$thumb=$ChannelVideosItem->video_thumbnail_file_path;
								
								$img = $thumb;
										
								}else{
									$img = '';
								}
								if($ChannelVideosItem->video_file_path != ''){
									$video_path = $ChannelVideosItem->video_file_path;
									
								}else{
									$video_path = '';
								}
						?> 
					<div class="vid_bx">
						<div class="thumbnail">
							<a href="<?php echo url('/').'/watch/?p='.$video_idddd; ?>">
								 <img src="{{$img}}" alt="image" class="imghome_<?php echo $ChannelVideosItem->id; ?>" > 
								<video  data-play = "Hover"  class="postervideo1_<?php echo $ChannelVideosItem->id; ?>" style="display: none; width: 246px; height: 165px;" muted="muted">
									  	 <source src="<?php echo $video_path; ?>" type="video/mp4">

								 	  </video> 
								 
								<div class="middle">
									<?php
									$title = $ChannelVideosItem->video_title;
									$full_title = $ChannelVideosItem->video_title;
									if( strlen( $title) > 44) {
									    $title = explode( "\n", wordwrap( $title, 44));
									    $title = $title[0] . '...';
									} 
									
									
									?>
									<div class="text" title="{{$full_title}}">{{ $title }}</div>
								</div>
							</a>
						</div>
						<div class="video-details home-videoDetails-wrap">
							
							<?php 
							$date =  $ChannelVideosItem->updated_at;
							$NewCreatedDate = date('d M Y', strtotime($date));
							$NewCreatedDate = date('h:i A', strtotime($date));
							$updated_at = $ChannelVideosItem->updated_time;
							?>
							<h4>
							<?php
							//print_r($tags);
							$tag_name='';
							if(!empty($ChannelVideosItem->tags))
							{
							
							foreach($ChannelVideosItem->tags as $row)
							{
							//dd($row['tag_name']);	
							if($row['tag_name'] != '')
							{	
							$tag_name ='#'.$row['tag_name'].' ';
							?>
							<span><?php echo substr($tag_name,0,-1); ?></span> 
							<?php
							}
							}
								
							}	
							?>
							</h4>
							<div class="thumbnail-content">
								<div class="row justify-content-between mt-2 mb-2">
									
									<div class="col-auto"><span class="Date">{{ $updated_at}}</span></div>
								</div>
							</div>
							
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