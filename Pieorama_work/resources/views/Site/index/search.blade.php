@extends('layouts.site.web.webapp')
@section('content')

<div class="right_panel">
	
	
	<div class="vd_container">
	@if($videocount)
	 <div>Search results ({{$videocount}})</div>
	@endif
		
	
		@if($AllVideos) 
		<div class="video_list home_video_list home_thumbnail_videoWrapp">
			<?php
			if(!empty($all_user)) {
			?>
			<ul class="christanPieograms-wrapper clearfix">				  
				@if($AllVideos)
				<?php  
				$i=0;
				//$path = config('constants.ADMIN_URL').'/uploads'; 
				foreach($AllVideos as $ChannelVideosItem) { ?>	
				<?php
				$tags=array();
				$first=trim($all_user[$i]['user_firstname']);
				$last=trim($all_user[$i]['user_lastname']);
				$view=trim($all_user[$i]['view']); 
				$tags=$all_user[$i]['tags'];
				$totalsharecount=$all_user[$i]['totalsharecount'];
				$total_count_like=$all_user[$i]['total_count_like'];
				$total_count_dislike=$all_user[$i]['total_count_dislike'];
				$total_comment=$all_user[$i]['total_comment'];
				$updated_at=$all_user[$i]['updated_at'];
				
				
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
				<?php
					$video_idddd=base64_encode($ChannelVideosItem->id);
					$video_idddd=urlencode(base64_encode($video_idddd));
					$video_idddd=str_replace('%3D%3D', '', $video_idddd);
				?> 
			@if($img)
				<li>
					<div class="vid_bx">
						<div class="thumbnail">
							<a href="<?php echo url('/').'/watch/?p='.$video_idddd; ?>">
								 <img src="<?php echo $img; ?>" alt="image" class="imghome_<?php echo $ChannelVideosItem->id; ?>" > 
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
									/*if( strlen($title) > 35){
										$title = substr($title,0,35)."...";
									}*/
									//$title = strlen($title) > 38 ? substr($title,0,38)."...": $title;
									
									?>
									<div class="text" title="{{$full_title}}">{{ $title }}</div>
								</div>
							</a>
						</div>
						<div class="video-details home-videoDetails-wrap">
							<h4>
							<?php
							//print_r($tags);
							$tag_name='';
							if(!empty($tags))
							{
							
							foreach($tags as $row)
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
							<?php 
							$date =  $ChannelVideosItem->created_at;
							$NewCreatedDate = date('d M Y', strtotime($date));
							$NewCreatedTime = date('h:i A', strtotime($date));
							?>
							<div class="thumbnail-content">
								<div class="row justify-content-between mt-2 mb-2">
									@if(!empty(auth()->user()))
									
										<div class="col-auto">
											<a href="{!! url('/pieorama-user-profile'); !!}/{{$ChannelVideosItem->userprofile_id}}" style="color:#000;">
												<span class="category w-100 mb-0"><?php echo $first.' '.$last; ?>
											
												</span>
											</a>
										</div>
								    @else
								   
								    <div class="col-auto"> 
								    	<a href="javascript:;" data-toggle="modal" data-target="#myModal" style="color:#000;">
								    		<span class="category w-100 mb-0"><?php echo $first.' '.$last; ?></span>
								    	</a>
									</div>
									@endif
									<div class="col-auto"><span class="Date">{{ $updated_at}}</span></div>
								</div>
							</div>
							<div class="entry-meta post-meta meta-font">
								<div class="post-meta-wrap">
									<div class="view-count">
										<i class="fa fa-eye" aria-hidden="true"></i>
										<span><?php echo $view; ?></span>
									</div>
									<div class="like-count">
										<i class="fa fa-thumbs-up" aria-hidden="true"></i>
										<span class="like-count" data-id="<?php echo $total_count_like; ?>"><?php echo $total_count_like; ?></span>
									</div>
									<div class="dislike-count">
										<i class="fa fa-thumbs-down" aria-hidden="true"></i>
										<span class="dislike-count" data-id="<?php echo $total_count_dislike; ?>"><?php echo $total_count_dislike; ?></span>
									</div>
									<div class="comment-count">
										<i class="fa fa-comment-o" aria-hidden="true"></i>
										<span class="dislike-count" data-id="<?php echo $total_comment; ?>"><?php echo $total_comment; ?></span>
									</div>
									<div class="share-count">
										<i class="fa fa-share-alt" aria-hidden="true"></i>
										<span class="dislike-count" data-id="<?php echo $totalsharecount; ?>"><?php echo $totalsharecount; ?></span>
									</div>
									
								</div>
							</div>
						</div>
					</div>
				</li>
				@endif
				<?php 
				$i++;
				} ?>
				@endif
			</ul>
			<?php 
			}
			else 
			{		
			?>
			<div class="not_found">
			<a href = "{!! url('/home'); !!}"><button type="submit" class="login_btn signupbtn searcMsg"><i class="fas fa fa-arrow-left"></i></button></a>
				<span>Your search returned no results</span>
			</div>
			<?php } ?>
			
		</div> 
		@else
		<div class="not_found">
			<a href = "{!! url('/home'); !!}"><button type="submit" class="login_btn signupbtn searcMsg"><i class="fas fa fa-arrow-left"></i></button></a>
				<span>Your search returned no results</span>
			</div>

		@endif
		
	</div>
	
</div>
@endsection

<script type="text/javascript">

	/*function bigImg(x,y) {	
	
		    $('.imghome_'+y).hide();
			$('.playhide_'+y).hide();
	    	$('.postervideo1_'+y).show();
	        $('.postervideo1_'+y)[0].play();
	        
	       
		     setTimeout(function(){
			
				$('.postervideo1_'+y)[0].pause();
		
				},6000);
	 }

		function bigImg2(x,y) {	
		//alert(x);	
			$('.postervideo1_'+y)[0].pause();
			$('.postervideo1_'+y).hide();
			$('.playhide_'+y).show();
			$('.imghome_'+y).show();
			$('.postervideo1_'+y)[0].load();
			
		}*/
</script>