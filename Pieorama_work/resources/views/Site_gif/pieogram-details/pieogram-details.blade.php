@extends('layouts.site.web.webapp')


@section('content')

<!-- right-panel -->
<div class="detail_page">
	<div class="vd_container">
		<div class="row">
			<div class="col-xl-9 col-lg-8">
				<div class="detail_box">
					<?php 
					$total_commentss=$total_comment; 
					?> 
					<?php
					if($videoDetails->video_file_path!='')
					{
					//$path = url("uploads/"); 

					$path = config('constants.ADMIN_URL').'/uploads'; 
					if($videoDetails->video_large_thumbnail_file_path!='')
					{
					  $thumb=$videoDetails->video_large_thumbnail_file_path;
					  $img=$path.'/'.$thumb;
					}else{
						$img=asset('images/300.png');
					}	
					?>
					<div>
					<?php  
					// Now it's static thumb
					$MainPageThumb = asset('thumbs/1568610309158106469.jpg') ;
					?>
						<div class="VideoDetails clickonviewVideo videodetail_topvideoWrap vidFrame"  style='background: url("<?php echo $img; ?>") center center no-repeat; background-size: cover;'>
							<video id="video1" class="" style="background: #fff;" width="100%" height="100%" controls onended="run()" cancelled ="false" autoplay>
								<source src="<?php echo $videoDetails->video_file_path; ?>" type="video/mp4">

							</video>
							<i id ="fullScreen" class="fa fa-arrows-alt videoFullScreen" aria-hidden="true"></i>
							<div class="v-overlay" id="timerloader" style="display: none;">
								<div class="upnext" id="upnext" style="text-align: center;">Up Next</div>
								<div class="next_text_video" id="next_text" style="text-align: center;"></div>
								<div class="circle-loader-wrap">
								    <i class="fa fa-step-forward" aria-hidden="true" onclick="playvideo()"></i>
									<div class="circle-loader-inner" data-anim="base wrapper">
								  		<div class="loader-circle" data-anim="base left"></div>
								       	<div class="loader-circle" data-anim="base right"></div>  
								    </div>
								</div>
								<div class="loader-close" id="loader_close" style="display: none; cursor: pointer;" onclick="stopvideo()" ><span>Cancel</span>
								</div>														
							</div>
						</div>
					
						<input type="hidden" id="videodetails_id" name="videodetails_id" value="{{$videoDetails->id}}">
						<input type="hidden" id="video_path" name="video_path" value="{{  $videoDetails->video_file_path }}">

					</div>
					<?php 
					}
					else
					{	
					?>
					<p>No video uploaded</p>
					<?php
					}

					//$path = url("uploads/");
					$path = config('constants.ADMIN_URL').'/uploads';  

					?>
					
					<input type="hidden" id="video_id" name="video_id" value="{{ $videoDetails->id }}">
					<div class="detail_info px-0 pt-3">
						<div class="form-row align-items-center">
							<div class="col-xl-6 col-lg-6">
								<h1 class="page-subtitle mb-0 mt-1" id="nextvideo">{{ substr($videoDetails->video_title, 0,555) }}</h1>
								
							</div>
							<div class="col-xl-6 col-lg-6 side-share text-lg-right mt-3 mt-lg-0">
								<?php
								if($videoDetails->video_file_path!='')
								{
								?>		
								
								<ul>
									<?php
									if($videoDetails->original_video_path != ''){
										$videoUrl =  $videoDetails->original_video_path;
									}else{
										$videoUrl = '';
									}
									

									?>
									<li class="source_video pl-0">

										
										@if($videoUrl != '')
											<a title='View source Video' class=' videotest_{{$videoDetails->id}}' data-id='"{{$videoDetails->id}}"' video_url='{{$videoUrl}}' onclick='show_video("{{$videoDetails->id}}")' style="cursor: pointer;"><span>Source</span>
												<img style="vertical-align: top;" src="<?php echo $path; ?>/video_source.png">

											</a>
										@else
										  <a data-toggle="modal" data-target="#video-popup" tabindex="0" style="cursor: pointer;"><span>Source</span>
											<img style="vertical-align: top;" src="<?php echo $path; ?>/video_source.png">
										</a>
										@endif
										
									</li>
									<li class="source_video pl-0">
										<?php
											if($videoDetails->video_animated_file_path != ''){
												$animatedGif =  $videoDetails->video_animated_file_path;
											}else{
												$animatedGif = '';
											}
											

										?>
										
										@if($animatedGif != '')
											<a title='View animated Gif' class='gifvideotest_{{$videoDetails->id}}' data-id='"{{$videoDetails->id}}"' video_url='{{$animatedGif}}' onclick='show_animatedvideo("{{$videoDetails->id}}")' style="cursor: pointer;"><span>GIF</span>
												<img style="vertical-align: top;" src="{{asset('website/images/Animated_GIF_button-optimised.jpg')}}">

											</a>
										@else
										  <a data-toggle="modal" data-target="#animatedvideo-popup" tabindex="0" style="cursor: pointer;"><span>GIF</span>
											<img style="vertical-align: top;" src="{{asset('website/images/Animated_GIF_button-optimised.jpg')}}">
										</a>
										@endif
										
									</li>
									
									<li class="source_video">
										
										<a onclick="javascript:genericSocialShare('[CustomSocialShareLink]')" style="cursor: pointer;"><span>Share</span>
												<img style="vertical-align: top;" src="<?php echo $path.'/share_me.png'; ?>" alt="">
										</a>
									</li>
									
									
									
								</ul>		
								
								<?php } ?>
							</div>
						</div>
						<div class="border_btm py-4">
							<div class="row align-items-center justify-content-between">
								<div class="col-auto">
									<div class="date">
										<span>
											{{number_format($TotalvideoViewsCount)}} 
											@if($TotalvideoViewsCount > 1) 
											Views 
											@else 
											View
											@endif
										</span> 
										<span>•</span>
										<?php 
										$date =  $videoDetails->created_at;
										$time = Commenhelper::time_Ago($date->toDateTimeString()); 
										echo $time;
										?>
									</div>
								</div>
								<div class="col-auto">
									<ul class="detail_icons mt-0 d-inline-block">
										@if(!empty(auth()->user()->id))
										<li>
											<a href="javascript:;" class="likebutton <?php if($like_status==1) { echo "Activelike"; } ?>" id="Activelike" onclick="javascript:video_like()" >
												
												<img id="likedthumb" style="vertical-align: top;" @if($like_status==1) src="{{ asset('uploads/thumbs-up-icon-colored.png')}}" @else src="{{ asset('uploads/thumbs-up-icon.png')}}" @endif>
												<span class="value" id="like_count">{{ $total_count_like}} </span>
											</a>
										</li>
										<li  style="padding-right: 0 !important;">
											<a href="javascript:;" class="unlikebutton <?php if($dislike_status==1) { echo "Activeunlike"; } ?>" id="Activeunlike" onclick="javascript:video_dislike()" >
												
													<img id="dislikedthumb" style="vertical-align: top;" @if($dislike_status==1) src="{{ asset('uploads/thumbs-down-icon-colored.png')}}" @else src="{{ asset('uploads/thumbs-down-icon.png')}}" @endif>
												
												<span class="value" id="dislike_count">{{ $total_count_dislike}} </span>
											</a> 
										</li> 
										@else
										<li>
											<a href="javascript:;" class="likebutton" id="Activelike" data-toggle="modal" data-target="#myModal">
												
												<img style="vertical-align: top;" src="<?php echo $path; ?>/thumbs-up-icon.png">
												<span class="value" id="like_count">{{ $total_count_like}} </span>
											</a>
										</li>
										<li  style="padding-right: 0 !important;">
											<a href="javascript:;" class="unlikebutton" id="Activeunlike" data-toggle="modal" data-target="#myModal">
											
												<img style="vertical-align: top;" src="<?php echo $path; ?>/thumbs-down-icon.png">
												<span class="value" id="dislike_count">{{ $total_count_dislike}} </span>
											</a>  
										</li>  
										@endif

										<?php
										if($videoDetails->video_file_path!='')
										{
										$path = config('constants.ADMIN_URL').'/uploads'; 
										$video_path=$videoDetails->video_file_path;	
										}
										?>
									</ul>
									<ul class="detail_icons mt-0 d-inline-block border-bottom-0 ml-3">
										<li>
											<a href="javascript:;">
												<!--<i class="fa fa-share-alt"></i>-->
												<img style="vertical-align: top;" src="<?php echo $path; ?>/share-icon.png">
												<span class="value" id="shared_value"><?php echo $totalsharecount ?></span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<div class="pt-3">
							<div class="text-md-right">
							<h5 class="video-tag-werappers">
							

							<?php

							
							$tag_namee='';
							if(!empty($video_user['video_tags']))
							{
								
							foreach($video_user['video_tags'] as $row)
							{

							if($row['tag_name'] != '')
							{	
							$tag_namee ='#'.$row['tag_name'].' ';
							?>
							<span><?php echo substr($tag_namee,0,-1); ?></span> 
							<?php
							}
							}	 
							?>
							
							<?php
							}	
							?>


							
							
						</h5>
						</div>
							<div class="media pt-0 pb-4 mt-3 mt-md-0">
								<div class="user-image mt-0 mr-3">

									<img src="<?php echo $video_user['profile_image']; ?>" alt="">
								</div>
								<div class="media-body">
									<h2>
										<?php
										echo $name=$video_user['user_firstname'].' '.$video_user['user_lastname'];
										?>
									</h2>
									<span class="body-text">
										{!! $videoDetails->video_description !!}
									</span>
								</div>
							</div>
							
							
							<div class="comment-main">
								<div class="detail_info d-none">
									<h1 class="page-subtitle mb-0" id="totalcomment">
									<?php 
									echo $total_commentss;  
									?>
										Comments
									</h1>
									<div class="d-block">
										<small class="sm_txt">
											{{number_format($TotalvideoViewsCount)}} 
											@if($TotalvideoViewsCount > 1) 
											Views 
											@else 
											View
											@endif
										</small>
									</div>
								</div>
								<?php
								$user_id=0;
								?>
								@if(!empty(auth()->user()->id))
								<div class="comment-box">
									<ul>
										<li>
											<div class="comment-box-in">
												@if(!empty(auth()->user()->profile_image))
												<img src="<?php if(isset(auth()->user()->profile_image)){ ?>{{ auth()->user()->profile_image }}<?php } ?>" alt="" class="comment-userImage">
												@else
												<img src="{{ url('/website/') }}/images/nouserimage.png" alt="" class="comment-userImage">
												@endif
												@if(isset($id_exist))
									    			@if($id_exist == 1)
														<div class="pieogram_details_badge_img"> 
															<img src="https://media.pieorama.fun/Pieoneer_badge_small.png" alt="badge picture">
														</div>
													@endif
												@endif
												<input type="text" name="comment" id="text_comment" class="comment-text" placeholder="Add a public comment...">
												<button class="comment_btn" onclick="javascript:text_comment()"><i class="fa fa-paper-plane"></i></button>
											</div>
										</li>
									</ul>
								</div>
								@endif



								
								<div class="comment-box" id="ajax_comment">
									<ul class="comment-box-list" >

										<?php $i =1; ?>
										<?php $a=0; ?>
										@foreach($videoComment as $res)   
										<li class="border_btm comment_row row_<?php echo $res->id; ?>" >
											<div class="comment-box-in">
												@if(!empty($res->getprofile_image->profile_image))
												<img src="{{$res->getprofile_image->profile_image}}" alt="" class="comment-userImage">
												@elseif(empty($res->getprofile_image->profile_image))
												<img src="{{ url('/website/') }}/images/nouserimage.png" alt="" class="comment-userImage">
												@endif
												<div class="comment-detail"> 
													<div class="comment-mesg-wrap">
														<p class="comment-u-name">{{ $res->commentd_by_username }}
															<?php $time = Commenhelper::time_Ago($res->updated_at->toDateTimeString()); ?>
															<span class="commnet-time">{{  $time  }}</span>
														</p>
														<p class="commnet-messa">{{ $res->comment_text }}</p>
														<div class="comment-opt">
															<?php if(isset(auth()->user()->id)){?>
															@if( auth()->user()->id == $res->comment_by)<i class="fa fa fa-ellipsis-v" data-toggle="dropdown" aria-expanded="false"></i> @endif <?php }?>
															<div class="dropdown-menu">
																
																<a class="dropdown-item delete-comment" id='encoded_pieogramid'  onclick="javascript:delete_comment({{$res->id}})"><i class="far fa-trash-alt"></i> Delete</a>
															</div>
														</div>
													</div>
													<ul class="repl-view-list" id="view_reply<?php echo $res->id; ?>">
														<?php  
														$reply_list = Commenhelper::getreply($res->id,$videoDetails->id); 
														$total_reply = count($reply_list);
														$time = Commenhelper::time_Ago($res->updated_at->toDateTimeString());
														
														 

														$countArray = Commenhelper::count_like_dislike($videoDetails->id,$res->id);
														/*
														echo "<pre>";		
														print_r($countArray);
														echo "</pre>";		
														*/
														$total_like=$countArray[0]['like'];
														$total_dislike=$countArray[0]['dislike'];
														$user_id=0;
														if(!empty(auth()->user()))
														{
															$user_id=auth()->user()->id;
														}
														$user_count=Commenhelper::check_user_like_dislike_comment($videoDetails->id,$res->id,$user_id);
														
														 //dd($user_count);
														 
														?>
														<li class="like-comment">
															<input type="hidden" value="<?php echo $total_like; ?>" id="like_text_<?php echo $res->id; ?>">
															<input type="hidden" value="<?php echo $total_dislike; ?>" id="dislike_text_<?php echo $res->id; ?>"> 
															<ul class="like-comment-ul replylikedislike">
																<li>
																<?php 

																$user_like_count = Commenhelper::check_user_like_comment($videoDetails->id,$res->id,$user_id);
																?>
																	
																<a href="javascript:;" class="likebutton @if(isset($user_like_count)) Activelike @endif" id="like_<?php echo $res->id; ?>" onclick="comment_like_dislike('1','<?php echo $res->id; ?>');" >
																		
																		<img id="commentlikedthumb_<?php echo $res->id; ?>" style="vertical-align: top;" @if(isset($user_like_count))  src="{{ asset('uploads/thumbs-up-icon-colored.png')}}" @else src="{{ asset('uploads/thumbs-up-icon.png')}}" @endif>


																		<span class="value" id="like_count_<?php echo $res->id; ?>"  ><?php echo $total_like; ?>
																		</span>
																	</a>
																</li>

																<li>
																	<?php 

																$user_dislike_count = Commenhelper::check_user_dislike_comment($videoDetails->id,$res->id,$user_id);
																//dd($user_dislike_count);
																?>
																	<a class="unlikebutton @if(isset($user_dislike_count)) Activeunlike @endif" id="dislike_<?php echo $res->id; ?>"  onclick="comment_like_dislike('0','<?php echo $res->id; ?>');">
																		<img id="commentdislikedthumb_<?php echo $res->id; ?>" style="vertical-align: top;" @if(isset($user_dislike_count))  src="{{ asset('uploads/thumbs-down-icon-colored.png')}}" @else src="{{ asset('uploads/thumbs-down-icon.png')}}" @endif>

																		<span class="value" id="dislike_count_<?php echo $res->id; ?>" ><?php echo $total_dislike; ?></span>
																	</a>     
																</li> 
															</ul>
														</li>
														<li class="reply-comment" <?php if(empty(auth()->user())) { ?> href="javascript:;" class="" id="" data-toggle="modal" data-target="#myModal" <?php } ?>><span class="value">Reply</span></li>
															<?php if($total_reply>0){ ?>
														<li class="view-reply">
															<i class="fa fa-caret-down"></i>
															@if($total_reply > 1)
															<span class="no-reply">View <?php echo $total_reply; ?> Replies</span>
															<span class="hide-no">Hide Replies</span>
															@elseif($total_reply == 1)
															<span class="no-reply">View <?php echo $total_reply; ?> Reply</span>
															<span class="hide-no">Hide Reply</span>
															@endif

														</li>
														<?php }?>
														<?php if(!empty(auth()->user())) { ?>
														<div class="comment-box2-in">
															<input type="text" name="comment" class="comment-text" placeholder="Add a public comment..." id="replycomment<?php echo $i; ?>">
															<div class="comment-btn2">
																<button class="cancel-btn cancel-btn2"><i class="fa fa-times"></i></button>
																<button class="reply-btn" id="text_reply<?php echo $i; ?>" ><i class="fa fa-paper-plane"></i></button>
																<input type="hidden" name="" id="comment_id<?php echo $i; ?>" value="<?php echo $res->id ?>">
															</div>
														</div>
													<?php } ?>
													<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
														<script type="text/javascript">
															$(document).ready(function() {
																$('#text_reply<?php echo $i; ?>').click(function(){
																	//alert('#replycomment<?php echo $i; ?>');
																	var comment = $('#replycomment<?php echo $i; ?>').val();
																	var comment_id = $('#comment_id<?php echo $i; ?>').val();
																	var video_id = $('#video_id').val();
																	$.ajax({
																		url     : '{{ route("site.addreplyPieogram")}}',
																		method  : 'post',
																		data: { 
																			comment: comment,
																			video_id : video_id,
																			comment_id : comment_id,
																			_token : '{{csrf_token()}}'
																		},
																		dataType: 'json',
																		success : function(response){
																			$('#ajax_comment').html(response.html);
																			$('#totalcomment').html(response.total_comment + ' Comments ');
																			$('#totalcomment1').html(response.total_comment);
																			$('#view_reply<?php echo $res->id ;?>').addClass('open-repl');
																		}
																	});
																	$('#replycomment').val('')
																});
															});
														</script>
														<?php $j =1; ?>
														@foreach($reply_list as $value)
														<div class="nest-comment-box">
															<div class="nest-comment-box-in">
																@if(!empty($value->getprofile_image->profile_image))
																<img src="{{$value->getprofile_image->profile_image}}" alt="" class="comment-userImage">
																@elseif(empty($value->getprofile_image->profile_image))
																<img src="{{ url('/website/') }}/images/nouserimage.png" alt="" class="comment-userImage">
																@endif
																<div class="comment-detail">
																	<div class="comment-mesg-wrap">
																		<p class="comment-u-name"><?php echo $value->commentd_by_username; ?>. <?php $time = Commenhelper::time_Ago($value->updated_at->toDateTimeString()); ?>
																			<span class="commnet-time"><?php echo $time; ?></span></p>
																		<p class="commnet-messa"><?php echo  $value->comment_text; ?></p>
																		<div class="comment-opt">
																			<?php if(isset(auth()->user()->id)){ ?>
																			@if( auth()->user()->id == $value->comment_by)<i class="fa fa fa-ellipsis-v" data-toggle="dropdown" aria-expanded="false"></i> @endif <?php }?>
																			<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 505px, 0px);" x-out-of-boundaries="">
																				
																				<a class="dropdown-item delete-comment" id='encoded_pieogramid' onclick="javascript:delete_comment({{$value->id}})"><i class="far fa-trash-alt"></i> Delete</a>
																			</div>
																		</div>
																	</div>
																	<ul class="repl-view-list">
																												
																		<?php
																		$countArray = Commenhelper::count_like_dislike($videoDetails->id,$value->id);
																		/*
																		echo "<pre>";		
																		print_r($countArray);
																		echo "</pre>";		
																		*/
																		$total_likes=$countArray[0]['like'];
																		$total_dislikes=$countArray[0]['dislike'];
																		
																		$user_id=0;
																		if(!empty(auth()->user()))
																		{
																			$user_id=auth()->user()->id;
																		}
														
																		$user_counts=Commenhelper::check_user_like_dislike_comment($videoDetails->id,$value->id,$user_id);
																		
																		
																		?>

																		<input type="hidden" value="<?php echo $total_likes; ?>" id="like_text_<?php echo $value->id; ?>">
																		<input type="hidden" value="<?php echo $total_dislikes; ?>" id="dislike_text_<?php echo $value->id; ?>">  
																		<li class="like-comment"> 
																			<ul class="like-comment-ul replylikedislike">
																				<li>
																					<?php

																					$user_like_counts=Commenhelper::check_user_like_comment($videoDetails->id,$value->id,$user_id);
																					?>
																					<a href="javascript:;" class="likebutton @if(isset($user_like_counts)) Activelike @endif" id="like_<?php echo $value->id; ?>"  onclick="comment_like_dislike('1','<?php echo $value->id; ?>');" >
																						<img id="commentlikedthumb_<?php echo $value->id; ?>" style="vertical-align: top;" @if(isset($user_like_counts))  src="{{ asset('uploads/thumbs-up-icon-colored.png')}}" @else src="{{ asset('uploads/thumbs-up-icon.png')}}" @endif>
																						<span class="value" id="like_count_<?php echo $value->id; ?>" ><?php echo $total_likes; ?>
																						</span>
																					</a>
																				</li>
																				<li>
																					<?php 
																					$user_dislike_counts=Commenhelper::check_user_dislike_comment($videoDetails->id,$value->id,$user_id);
																					?>
																					<a href="javascript:;" class="unlikebutton @if(isset($user_dislike_counts)) Activeunlike @endif" id="dislike_<?php echo $value->id; ?>"   onclick="comment_like_dislike('0','<?php echo $value->id; ?>');" > 
																						<img id="commentdislikedthumb_<?php echo $value->id; ?>" style="vertical-align: top;" @if(isset($user_dislike_counts))  src="{{ asset('uploads/thumbs-down-icon-colored.png')}}" @else src="{{ asset('uploads/thumbs-down-icon.png')}}" @endif>
																						<span class="value" id="dislike_count_<?php echo $value->id; ?>" ><?php echo $total_dislikes; ?></span>
																					</a>     
																				</li> 
																			</ul>
																		</li>
																		
																		<li class="reply-comment" <?php if(empty(auth()->user())) { ?> href="javascript:;" class="" id="" data-toggle="modal" data-target="#myModal" <?php } ?> >
																			<div class="reply-icon"></div><span class="value">Reply</span>
																		</li>
																		<?php if(!empty(auth()->user())) {?>
																		<div class="nested-comment-box-in">
																			<input type="text" name="comment" class="comment-text" placeholder="Add a public comment..." id="reply_comments<?php echo $value->id; ?>">
																			<div class="comment-btn2">
																				<button class="cancel-btn nested-cancel-btn2"><i class="fa fa-times"></i></button>
																				<button class="reply-btn" id="text_reply1_<?php echo $value->id; ?>" ><i class="fa fa-paper-plane"></i></button>
																			</div>
																		</div>
																	<?php } ?>
																	</ul>
																</div>
															</div>
														</div> 

														<script type="text/javascript">
															$(document).ready(function() {
																$('#text_reply1_<?php echo $value->id; ?>').click(function() {
																	var comment = $('#reply_comments<?php echo $value->id; ?>').val();
																	var video_id = $('#video_id').val();
																	var comment_id = $('#comment_id<?php echo $i; ?>').val();
																	$.ajax({
																		url: '{{ route("site.addreplyPieogram")}}',
																		method: 'post',
																		data: {
																			comment: comment,
																			video_id: video_id,
																			comment_id: comment_id,

																			_token: '{{csrf_token()}}'
																		},
																		dataType: 'json',
																		success: function(response) {
																			$('#ajax_comment').html(response.html);
																			$('#totalcomment').html(response.total_comment + ' Comments ');
																			$('#totalcomment1').html(response.total_comment);
																			$('#view_reply<?php echo $res->id ;?>').addClass('open-repl');

																		}
																	});
																	$('#reply_comments<?php echo $value->id; ?>').val('')

																});
															});
														</script>
														<?php $j++; ?>
														@endforeach
													</ul>
												</div>
											</div>
										</li>
										<?php $i++; ?>
										@endforeach
									</ul>
									<div class="">
						@if($total_count_comm > 3)	
						<a href="javascript:void(0);" class="comm_load_more" onclick="load_more();">Load More</a>
						@endif	
						<input type="hidden" name="tot_rec" id="tot_rec" value="1">	


						<input type="hidden" name="total_record" id="total_record" value="<?php echo $total_count_comm; ?>">	 
						<input type="hidden" name="page" id="page" value="2"> 	  
						<input type="hidden" name="video_id" id="video_id" value="<?php echo $video_id; ?>">	 
						<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">	 
						<script> 
							
							function load_more()
							{
								var current_record=$('.comment_row').length;
								//alert(current_record); 
								var tot_rec=$('#tot_rec').val();

								var video_id=$('#video_id').val();
								var current_page=$('#page').val();
								var total_record=$('#total_record').val();
								
 
								$.ajax({
									url: '{{ route("site.more_comment")}}',
									method: 'post', 
									data: {
											tot_rec: tot_rec, 
											current_page: current_page, 
											video_id: video_id,   
											_token: '{{csrf_token()}}'
									},
									
									success: function(response) {
										
										
										$('#page').val(parseInt(current_page)+1);  
										var current_record=$('.comment_row').length;
										$(response).insertAfter('.comment_row:last');

									     var page = $('#page').val(); 
 										//alert(page);
										//alert(total_record);

										if((parseInt(page)+1) == total_record) 
										{   
											$('.comm_load_more').hide(); 
										} 

											
										  	 
									}
								});
								
								
								
							}
							</script>
						</div>
									
								</div>
							
							
								  
							
							
							</div>
							<!-- Comment End -->

						
						</div>
						


						@if($videoDetails->is_owner)
						<div class="border_btm">
							<div class="detail_column d-flex justify-content-between align-items-center pdt flex-wrap">
								<div class="vd-opt">
									<ul class="detail_order">
										<li>
											Public Available
										</li>
										<li>
											<div class="qst_icon tooltip-h">
												<div class="tooltip-wrap">
													<div class="tooltip-wrap-in">This pieogram will not be able to publicly available to other users if you won't allow.</div>
												</div>
											</div>											
										</li>
										<li>
											<label class="switch ">
												<?php if($videoDetails->public_available == 1){ ?>
												<input type="checkbox" class="default publicavailableon">
												<span class="slider round"></span>
													<?php } else { ?>
													<input type="checkbox" class="default2 publicavailableoff">
													<span class="slider2 round"></span>
													<?php } ?>
											</label>
										</li>
									</ul>
								</div>
								<div class="vd-opt">
									<ul class="detail_order">
										<li>Searchable</li>
										<li>
											<div class="qst_icon tooltip-h">
												<div class="tooltip-wrap">
													<div class="tooltip-wrap-in">It will not be search if you don't allow to permit for search this pieogram to other users.</div>
												</div>
											</div>
										</li>
										<li>
											<label class="switch ">
												<?php if($videoDetails->searchable == 1){ ?>
												<input type="checkbox" class="default searchableon">
												<span class="slider round"></span>
												<?php } else { ?>
												<input type="checkbox" class="default2 searchableoff">
												<span class="slider2 round"></span>
												<?php } ?>
											</label>
										</li>
									</ul>
								</div>
							</div>
						</div>
						
						@endif

						
					</div>
				</div>
			</div>

			<div class="col-xl-3 col-lg-4">
				<ul class="christanPieograms-wrapper clearfix rightside_videoWrap">

					@if(($getnextVideo != '') && ($all_userss1 != ''))

					<?php 
					//dd('dsadafd');

					{
					$path = config('constants.ADMIN_URL').'/uploads';
					$tags=array();
					
					$first=$all_userss1['user_firstname'];
					
					$last=$all_userss1['user_lastname'];
					$view=$all_userss1['view'];
					$tags=$all_userss1['tags'];
					$totalsharecount=$all_userss1['totalsharecount'];
					$total_count_like=$all_userss1['total_count_like'];
					$total_count_dislike=$all_userss1['total_count_dislike'];
					$total_comment=$all_userss1['total_comment'];
					$updated_at=$all_userss1['updated_at'];
					
					
					if($getnextVideo->small_gif!='' && $getnextVideo->small_gif!=null)
					{
					$thumb=$getnextVideo->small_gif;
					
					$img=$thumb;
							
					}else{
						$img='';
					}	
					?>
					<?php
					$video_idddd=base64_encode($getnextVideo->id);

					$video_idddd=urlencode(base64_encode($video_idddd));
					$video_idddd = str_replace('%3D%3D', '', $video_idddd);
					//dd($video_idddd);
					?>
					<input type="hidden" name="" id="playnextvideoid" value = "{{$getnextVideo->id}}">
					@if($img != '')
					<li>
						<div class="vid_bx">

							 <div class="thumbnail">
							 	<div class="gif_thumbnail_img_wrap">
				  
								<img src="<?php echo $img; ?>" alt="image" class="imghome_<?php echo $getnextVideo->id; ?>" >
									
									  <div class="thumbnail_hover_icon_wrap">
									  		<ul>
												<li><a href="<?php echo url('/').'/getDownload/'.$getnextVideo->id; ?>" style="cursor:pointer;"><img src="{{asset('website/images/download-icon.png')}}" alt="image" class="imghome" ></a></li>
												  <li><a onclick = "copyUrlgif(<?php echo $getnextVideo->id; ?>)" style="cursor:pointer;"><img src="{{asset('website/images/copy-gif-link-icon.png')}}" alt="image" class="imghome" ></a></li>
												 
												  @if($getnextVideo->video_file_path != '' && $getnextVideo->video_file_path != null)
												  	<li><a href="<?php echo url('/').'/watch/?p='.$video_idddd; ?>" style="cursor:pointer;"><img src="{{asset('website/images/pieogram-icon.png')}}" alt="View PieOgram" class="imghome" ></a></li>
												  @endif
											</ul>
										</div>
							 
							 </div>
							  <input id="copyUrlgif_<?php echo $getnextVideo->id; ?>" class="copy-url-field" type="hidden" value="<?php echo $img; ?>">
							  <div class="middle">
									<?php
									$title = $getnextVideo->video_title;
									$full_title = $getnextVideo->video_title;
									if( strlen( $title) > 44) {
									    $title = explode( "\n", wordwrap( $title, 44));
									    $title = $title[0] . '...';
									} 
									/*if( strlen($title) > 35){
										$title = substr($title,0,35)."...";
									}*/
									//$title = strlen($title) > 38 ? substr($title,0,38)."...": $title;
									
									?>
									@if($getnextVideo->video_file_path != '' && $getnextVideo->video_file_path != null)
										<a href="<?php echo url('/').'/watch/?p='.$video_idddd; ?>" style="cursor:pointer;"><div class="text" title="{{$full_title}}">{{ $title }}</div></a>
									@else
										<div class="text" title="{{$full_title}}">{{ $title }}</div>
									@endif

							</div>
								<!-- <a href="{!! url('watch/?p='.$video_idddd)  !!}"> 
									
									<img src="<?php echo $img; ?>" alt="image" class="imghome_<?php echo $getnextVideo->id; ?>" > 
									   <video  data-play = "Hover"  class="postervideo1_<?php echo $getnextVideo->id; ?>" style="display: none; width: 100%; height: 137px;" muted="muted">
									  	 <source src="<?php echo $getnextVideo->video_file_path; ?>" type="video/mp4">

								 	  </video> 
									<div class="middle">
										<?php
											$title = $getnextVideo->video_title;
											$full_title = $getnextVideo->video_title;
											/*if( strlen($title) > 35){
												$title = substr($title,0,35)."...";
											}*/
											if( strlen( $title) > 40) {
											    $title = explode( "\n", wordwrap( $title, 40));
											    $title = $title[0] . '...';
											} 
											
										?>
										<div class="text" title="{{$full_title}}">{{ $title }}</div>
									</div>
								</a> -->
							</div>
							<div class="video-details home-videoDetails-wrap">
							<h4>
							<?php
							//print_r($tags);
							$tag_nameee='';
							if(!empty($tags))
							{
							
							foreach($tags as $row)
							{
							//dd($row['tag_name']);	
							if($row['tag_name1'] != '')
							{	
							$tag_nameee ='#'.$row['tag_name1'].' ';
							?>
							<span><?php echo substr($tag_nameee,0,-1); ?></span> 
							<?php
							}
							}
								
							}	
							?>
							</h4>
								
								<?php 
								$date =  $getnextVideo->created_at;
								$NewCreatedDate = date('d M Y', strtotime($date));
								$NewCreatedTime = date('h:i A', strtotime($date));
								?>
								<div class="thumbnail-content">
									<div class="row justify-content-between mt-2 mb-2">
										<div class="col-auto"><span class="category w-100 mb-0"><?php echo $first.' '.$last; ?></span></div>
										<div class="col-auto"><span class="Date">{{$updated_at}}</span></div>
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
					<?php } ?>
					@else
					<input type="hidden" name="" id="playnextvideoid" value = "">
					@endif




					@if($AllVideos)
					<?php  
					$i=0;
					$path = config('constants.ADMIN_URL').'/uploads'; 
					foreach($AllVideos as $ChannelVideosItem) { ?>	
					<?php
					$tags=array();
					$first=trim($all_userss[$i]['user_firstname']);
					$last=trim($all_userss[$i]['user_lastname']);
					$view=trim($all_userss[$i]['view']);
					$tags=$all_userss[$i]['tags'];
					$totalsharecount=$all_userss[$i]['totalsharecount'];
					$total_count_like=$all_userss[$i]['total_count_like'];
					$total_count_dislike=$all_userss[$i]['total_count_dislike'];
					$total_comment=$all_userss[$i]['total_comment'];
					$updated_at=$all_userss[$i]['updated_at'];
					
					
					if($ChannelVideosItem->small_gif!='' && $ChannelVideosItem->small_gif!=null)
					{
					$thumb=$ChannelVideosItem->small_gif;
					
					$img=$thumb;
					}else{
						$img='';
					}	
					?>
					<?php
					$video_idddd=base64_encode($ChannelVideosItem->id);

					$video_idddd=urlencode(base64_encode($video_idddd));
					$video_idddd = str_replace('%3D%3D', '', $video_idddd);
					/*$test =  url("watch/?p=".base64_encode(base64_encode($ChannelVideosItem->id)))  ;*/
					//dd($video_idddd);
					?>
					@if($img != '')
					<li>
						<div class="vid_bx">

							 <div class="thumbnail" >
							 	 <div class="gif_thumbnail_img_wrap">
				  
								<img src="<?php echo $img; ?>" alt="image" class="imghome_<?php echo $ChannelVideosItem->id; ?>" >
									
									  <div class="thumbnail_hover_icon_wrap">
									  		<ul>
												<li><a href="<?php echo url('/').'/getDownload/'.$ChannelVideosItem->id; ?>" style="cursor:pointer;"><img src="{{asset('website/images/download-icon.png')}}" alt="image" class="imghome" ></a></li>
												  <li><a onclick = "copyUrlgif(<?php echo $ChannelVideosItem->id; ?>)" style="cursor:pointer;"><img src="{{asset('website/images/copy-gif-link-icon.png')}}" alt="image" class="imghome" ></a></li>
												 
												  @if($ChannelVideosItem->video_file_path != '' && $ChannelVideosItem->video_file_path != null)
												  	<li><a href="<?php echo url('/').'/watch/?p='.$video_idddd; ?>" style="cursor:pointer;"><img src="{{asset('website/images/pieogram-icon.png')}}" alt="View PieOgram" class="imghome" ></a></li>
												  @endif
											</ul>
										</div>
							 
							 </div>
							  <input id="copyUrlgif_<?php echo $ChannelVideosItem->id; ?>" class="copy-url-field" type="hidden" value="<?php echo $img; ?>">
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
									@if($ChannelVideosItem->video_file_path != '' && $ChannelVideosItem->video_file_path != null)
										<a href="<?php echo url('/').'/watch/?p='.$video_idddd; ?>" style="cursor:pointer;"><div class="text" title="{{$full_title}}">{{ $title }}</div></a>
									@else
										<div class="text" title="{{$full_title}}">{{ $title }}</div>
									@endif

							</div>
								<!-- <a href="{!! url('watch/?p='.$video_idddd)  !!}"> 
									
									<img src="<?php echo $img; ?>" alt="image" class="imghome_<?php echo $ChannelVideosItem->id; ?>" > 
									   <video  data-play = "Hover"  class="postervideo1_<?php echo $ChannelVideosItem->id; ?>" style="display: none; width: 100%; height: 165px;" muted="muted">
									  	 <source src="<?php echo $ChannelVideosItem->video_file_path; ?>" type="video/mp4">

								 	  </video> 
									<div class="middle">
										<?php
											$title = $ChannelVideosItem->video_title;
											$full_title = $ChannelVideosItem->video_title;
											/*if( strlen($title) > 35){
												$title = substr($title,0,35)."...";
											}*/
											if( strlen( $title) > 40) {
											    $title = explode( "\n", wordwrap( $title, 40));
											    $title = $title[0] . '...';
											} 
											
											
										?>
										<div class="text" title="{{$full_title}}">{{ $title }}</div>
									</div>
								</a> -->
							</div>
							<div class="video-details home-videoDetails-wrap">
							<h4>
							<?php
							//print_r($tags);
							$tag_nameee='';
							if(!empty($tags))
							{
							
							foreach($tags as $row)
							{
							//dd($row['tag_name']);	
							if($row['tag_name'] != '')
							{	
							$tag_nameee ='#'.$row['tag_name'].' ';
							?>
							<span><?php echo substr($tag_nameee,0,-1); ?></span> 
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
										<div class="col-auto"><span class="category w-100 mb-0"><?php echo $first.' '.$last; ?></span></div>
										<div class="col-auto"><span class="Date">{{$updated_at}}</span></div>
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
			</div>
		</div>
	</div>
</div>

<!-- Report Comment popup -->
<div class="rpc-popup">
	<div class="rpc-popup-in">
		<div class="rpc-popup-cont">
			<h3 class="rpc-header">Report comment</h3>
			<ul>
				<li>
					<label class="custom-radio">Unwanted commercial content or spam
						<input type="radio" checked="checked" name="radio">
						<span class="checkmark"></span>
					</label>
				</li>
				<li>
					<label class="custom-radio">Pornography or sexually explicit material
						<input type="radio" name="radio">
						<span class="checkmark"></span>
					</label>
				</li>
				<li>
					<label class="custom-radio">Child abuse
						<input type="radio" name="radio">
						<span class="checkmark"></span>
					</label>
				</li>
				<li>
					<label class="custom-radio">Hate speech or graphic violence
						<input type="radio" name="radio">
						<span class="checkmark"></span>
					</label>
				</li>
				<li>
					<label class="custom-radio">Harassment or bullying
						<input type="radio" name="radio">
						<span class="checkmark"></span>
					</label>
				</li>
			</ul>
		</div>
		<div class="rpc-footer">
			<button class="btn btn-primary cancel-btn-bg rcp-cancel-btn">Cancel</button>
			<button class="btn btn-primary">Report</button>
		</div>
	</div>
</div>

<!-- video popup -->

<a  style="display:none;" class="watch" href="http://smartzitsolutions.com/pieorama/public/uploads/Sample320.mp4" data-lity=""><i class="fa fa-play" aria-hidden="true"></i> Watch Video</a>



<!-- Report comment popup end -->


<div class="modal fade share-popup" id="video-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded-0">
			<div class="modal-header border-bottom-0">
       
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body">
				<div class="text-center">
					<ul class="social-share-list">
						
						
						<li>
							<h3> Source video is not available</h3>
						</li>
						
					</ul>
					
				</div>
  			</div>
		</div>
	</div>
</div>

<div class="modal fade share-popup" id="animatedvideo-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded-0">
			<div class="modal-header border-bottom-0">
       
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body">
				<div class="text-center">
					<ul class="social-share-list">
						
						
						<li>
							<h3> Gif is not available</h3>
						</li>
						
					</ul>
					
				</div>
  			</div>
		</div>
	</div>
</div>
<?php
if($videoDetails->video_file_path!='')
{
?>
<div class="modal fade share-popup" id="share-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded-0">
			<div class="modal-header border-bottom-0">
        <h5 class="modal-title">Share</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
      <!-- 	<meta property="fb:app_id" content="455316068433476" />
		<meta property="og:site_name" content="Pieorama test">
		<meta property="og:title" content="<?php echo $videoDetails->video_title; ?>">
		<meta property="og:description" content="<?php echo substr($videoDetails->video_description, 0,28); ?>">
		<?php
							
			$imgtest = url('/uploads/').'/'.$videoDetails->video_thumbnail_file_path;

			$imgshare = str_replace(' ', '%20', $imgtest);
			
			
		?>
		<meta property="og:image" content="<?php echo $imgshare; ?>">
		<meta property="og:url" content="<?php echo (Request::fullUrl()); ?>">

		<meta name="twitter:title" content="<?php echo $videoDetails->video_title; ?>">
      	<meta name="twitter:image"  content="<?php echo $imgshare; ?>">
      	<meta name="twitter:card" content="summary_large_image">
      	<meta name="twitter:description" content="<?php echo substr($videoDetails->video_description, 0,28); ?>">
      	<meta property="twitter:url" content="<?php echo (Request::fullUrl()); ?>"> -->

      	


			<div class="modal-body">
				<div class="text-center">
					<ul class="social-share-list">
						<li>
							<?php
							
							$imgtest =  $videoDetails->video_large_thumbnail_file_path;

							$imgshare = str_replace(' ', '%20', $imgtest);
							/*$url1 = Request::segment(1);
							$url2 = Request::segment(2);
							dd($url2);*/
							$geturl = Request::fullUrl();
							$title = trim($videoDetails->video_title, '"');
		    				$desc1 = trim($videoDetails->video_description, '"');

							$desc1 = substr($desc1, 0,140);
							$desc=str_ireplace('<p>','',$desc1);
							$desc = str_ireplace('</p>','',$desc);  

							?>

							<a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(Request::fullUrl()); ?>&quote=<?php echo $title; ?>&image=<?php echo $imgshare; ?>&description=<?php echo $desc; ?>" target="_blank" onclick="javascript:social_share('facebook')"><img src="<?php echo $path.'/facebook.png'; ?>" alt=""></a>
						</li>
						<li>
							<?php
							$test = str_replace(' ', '%20', $video_path);
							$title = trim($videoDetails->video_title, '"');
							//dd($geturl);
							?>
							
							<a href="https://twitter.com/intent/tweet?text=<?php echo $title; ?>&url=<?php echo urlencode(Request::fullUrl()); ?>" target="_blank" onclick="javascript:social_share('twitter')"><img src="<?php echo $path.'/twitter.png'; ?>" alt=""></a>
						</li>
						<!-- <li>
							<a href=" https://plus.google.com/share?Url=<?php echo urlencode($video_path); ?>&quote=<?php echo $videoDetails->video_title; ?>&caption=<?php echo $videoDetails->video_description; ?>" target="_blank" onclick="javascript:social_share('tumblr')"><img src="<?php echo $path.'/instagram.png'; ?>" alt=""></a>
						</li> -->
						
						<li>
							<?php
							//$test = str_replace(' ', '%20', $video_path);
							$title = trim($videoDetails->video_title, '"');
							//dd($geturl);
							?>
							
							<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(Request::fullUrl()); ?>&title=<?php echo $title; ?>&summary=<?php echo $title; ?>&source=<?php echo url(''); ?>" target="_blank" onclick="javascript:social_share('linkedin')"><img src="<?php echo $path.'/linkedin.png'; ?>" alt=""></a>
						</li>
						
					</ul>
					<div class="copy-url-box">
						<div class="copy-url-box-inner"><input id="copyUrl" class="copy-url-field" type="text" value="{{Request::fullUrl()}}">
						<div class="copy-url-box-btn"><span id="copyurl" style="margin-left: -10px;">Copy</span><a onclick="copyUrl()"><img src="<?php echo $path.'/copy-url-icon.png'; ?>" alt=""></a></div>
						</div>
					</div>
				</div>
      </div>
		</div>
	</div>
</div>
<?php } ?>
<script src="{{ asset('website/js/jquery.min.js')}}"></script>
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v6.0&appId=1731426987153272&autoLogAppEvents=1"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('.se-pre-con').hide();
		$("#video1")[0].play();
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		var like_type = '<?php echo $like_status; ?>';
		if (like_type == 1) {
			$("#Activeunlike").removeClass("Activeunlike");
		} else if (like_type == 0) {
			$("#Activelike").removeClass("Activelike");
		} else if (like_type == 2) {
			$("#Activelike").removeClass("Activelike");
			$("#Activeunlike").removeClass("Activeunlike");
		}
	});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		var dislike_type = '<?php echo $dislike_status; ?>';
		if (dislike_type == 1) {
			$("#Activelike").removeClass("Activelike");
		} else if (dislike_type == 0) {
			$("#Activeunlike").removeClass("Activeunlike");
			
		}
		
		
		
	});
</script>
<script type="text/javascript">
	function text_comment() {

		//$('.comm_load_more').show(); 
		
		var comment = $('#text_comment').val();
		var video_id = $('#video_id').val();
		var video_file_path = $('#video_path').val();
		$.ajax({
			url: '{{ route("site.addcommentPieogram")}}',
			method: 'post',
			data: {
				comment: comment,
				video_id: video_id,
				video_file_path: video_file_path,
				_token: '{{csrf_token()}}'
			},
			dataType: 'json',
			success: function(response) {
				$('#ajax_comment').html(response.html);
				$('#totalcomment').html(response.total_comment + ' Comments ');
				$('#totalcomment1').html(response.total_comment);
			}
		});
		$('#text_comment').val('')
	}
</script>
<script type="text/javascript">
	function delete_comment(id) {
		swal({
				title: "Warning!",
				text: "Are you sure you want to delete this comment?",
				type: "warning",
				cancelButtonColor: "#DD6B55",
				showCancelButton: true,
				cancelButtonText: "Cancel",
				confirmButtonText: "Confirm"
			},
			function(isConfirm) {
				if (isConfirm) {
					var video_id = $('#video_id').val();
					$.ajax({
						url: '{{ route("site.deleteComments")}}',
						method: 'post',
						data: {
							id: id,
							video_id: video_id,
							_token: '{{csrf_token()}}'
						},
						dataType: 'json',
						success: function(response) {
							$('#ajax_comment').html(response.html);
							$('#totalcomment').html(response.total_comment + ' Comments ');
							$('#totalcomment1').html(response.total_comment);
						}
					});
				}
			});
	}
</script>
<script type="text/javascript">

	function genericSocialShare(url) {
		//alert(url);
		$('#share-popup').modal('show');
		return true;
	}

	function social_share(type) {
		/*var pagelink = '{{Request::fullUrl()}}';
		if(type == 'facebook'){
			var app_id = '455316068433476';
			var urllll = 'https://www.facebook.com/dialog/feed?app_id='+app_id+' &link='+encodeURIComponent(pagelink)+' &picture='+encodeURIComponent(img)+' &caption='+encodeURIComponent(title)+'&description='+encodeURIComponent(desc);
			var w=600;
			var h = 400;
			var left = (screen.width /2 ) - (w /2);
			var top = (screen.height/2) - (h/2);

			window.open(urllll,title,desc,img,'share on facebook','toolbar = no,location = no,directories = no,status = no, menubar = yes,scrollbars =no,resizeable = no,copyhistory = no,width = '+800+',height='+650+',top = '+top+',left = '+left);
			//$('#share-popup').modal('show');
			return true;
		}*/
		var video_id = $('#video_id').val();
		$.ajax({
			url: '{{ route("site.sharevideo")}}',
			method: 'post',
			data: {
				type: type,
				video_id: video_id,
				_token: '{{csrf_token()}}'
			},
			dataType: 'json',
			success: function(response) {
				$('#share-popup').modal('hide');
				$('#shared_value').html(response.total_shared);
			}
		});
	}

	function video_like() {
		var video_id = $('#video_id').val();
		$.ajax({
			url: '{{ route("site.like_video")}}',
			method: 'post',
			data: {
				video_id: video_id,
				_token: '{{csrf_token()}}'
			},
			dataType: 'json',
			success: function(response) {
				
				$('#like_count').html(response.total_count_like);
				$('#dislike_count').html(response.total_count_dislike);
				if (response.data.like_status == 1) {
					$("#Activeunlike").removeClass("Activeunlike");
					$('#likedthumb').attr('src','{{ asset("uploads/thumbs-up-icon-colored.png")}}');
					
					$("#dislikedthumb").attr('src','{{ asset("uploads/thumbs-down-icon.png")}}');
					
					$("#Activelike").addClass("Activelike");
				} else if (response.data.like_status == 0) {
					$("#Activelike").removeClass("Activelike");
					$('#likedthumb').attr('src','{{ asset("uploads/thumbs-up-icon.png")}}');
					$("#dislikedthumb").attr('src','{{ asset("uploads/thumbs-down-icon.png")}}');
				} else if (response.data.dislike_status == 1) {
					$("#Activelike").removeClass("Activelike");
					$("#Activeunlike").addClass("Activeunlike");
				} else if (response.data.dislike_status == 0) {
					$("#Activeunlike").removeClass("Activeunlike");
					$('#likedthumb').attr('src','{{ asset("uploads/thumbs-up-icon.png")}}');
					$("#dislikedthumb").attr('src','{{ asset("uploads/thumbs-down-icon.png")}}');
					
					
				}
			}
		});
		//$("#Activeunlike").removeClass("Activeunlike");
	}

	function video_dislike() {
		var video_id = $('#video_id').val();
		$.ajax({
			url: '{{ route("site.unlike_video")}}',
			method: 'post',
			data: {
				video_id: video_id,
				_token: '{{csrf_token()}}'
			},
			dataType: 'json',
			success: function(response) {
				
				$('#like_count').html(response.total_count_like);
				$('#dislike_count').html(response.total_count_dislike);
				if (response.data.dislike_status == 1) {
					$("#Activelike").removeClass("Activelike");
					$('#likedthumb').attr('src','{{ asset("uploads/thumbs-up-icon.png")}}');
					$("#dislikedthumb").attr('src','{{ asset("uploads/thumbs-down-icon-colored.png")}}');
					$("#Activeunlike").addClass("Activeunlike");
				} else if (response.data.dislike_status == 0) {
					$("#Activeunlike").removeClass("Activeunlike");
					$('#likedthumb').attr('src','{{ asset("uploads/thumbs-up-icon.png")}}');
					$("#dislikedthumb").attr('src','{{ asset("uploads/thumbs-down-icon.png")}}');
				} else if (response.data.like_status == 1) {
					$("#Activeunlike").removeClass("Activeunlike");
					$("#Activelike").addClass("Activelike");
				} else if (response.data.like_status == 0) {
					$("#Activelike").removeClass("Activelike");
					$('#likedthumb').attr('src','{{ asset("uploads/thumbs-up-icon.png")}}');
					$("#dislikedthumb").attr('src','{{ asset("uploads/thumbs-down-icon.png")}}');
					
				}

			}
		});
	}
	
	function comment_like_dislike(type,id)
	{
		
		var user_id = $('#user_id').val();
		
		if(user_id==0)
		{
			$('#myModal').modal('show');	
			return false;	 	
		} 

		var video_id = $('#video_id').val();
		var current_like=$('#like_text_'+id).val();	
		var current_dislike=$('#dislike_text_'+id).val();	

		var new_like=current_like;	
		if(type==1)
		{
			var new_like=Math.abs(parseInt(current_like)+1);
			var new_dislike=Math.abs(parseInt(current_dislike)-1);
			
			$('#like_count_'+id).html(new_like);
			$('#dislike_count_'+id).html(new_dislike);
			/*$('#like_count_'+id).css('color','#f47c42','!important');
			$('#dislike_text_'+id).css('color','#0000', '!important');*/
			//$("#Activeunlike").removeClass("Activeunlike");
			//$("#Activelike").addClass("Activelike");
		}
		
		var new_dislike=current_dislike;	 
		if(type==0)
		{
			var new_dislike=Math.abs(parseInt(current_dislike)+1);
			var new_like=Math.abs(parseInt(current_like)-1);
			$('#like_count_'+id).html(new_like);
			$('#dislike_count_'+id).html(new_dislike);
			//$('#like_count_'+id).css('color','#0000', '!important');
			//$('#dislike_text_'+id).css('color','#f47c42','!important');
			/*$('.cmtlike').addClass("cmtdislike");
			$('.cmtdislike').removeClass("cmtlike");*/	
		}	
	$.ajax({
			url: '{{ route("site.unlike_comment")}}',
			method: 'post', 
			data: {
				video_id: video_id,
				type: type,
				comment_id: id, 
				_token: '{{csrf_token()}}'
			},
			dataType: 'json',
			success: function(response) {
				console.log(response);
				$('#like_count_'+id).html(response.likes);
				$('#dislike_count_'+id).html(response.dislikes);
				
				if (response.like_status == 0 && response.dislike_status == 0) {
					//$("#like_"+id).removeClass("Activeunlike");
					$("#like_"+id).removeClass("Activelike");
					$("#dislike_"+id).removeClass("Activeunlike");
					$("#commentlikedthumb_"+id).attr('src','{{ asset("uploads/thumbs-up-icon.png")}}');
					$("#commentdislikedthumb_"+id).attr('src','{{ asset("uploads/thumbs-down-icon.png")}}');
				} else if (response.like_status == 1 && response.dislike_status == 0) {
					
					$("#like_"+id).addClass("Activelike");
					$("#dislike_"+id).removeClass("Activeunlike");
					$("#commentlikedthumb_"+id).attr('src','{{ asset("uploads/thumbs-up-icon-colored.png")}}');
					$("#commentdislikedthumb_"+id).attr('src','{{ asset("uploads/thumbs-down-icon.png")}}');
				} else if (response.dislike_status == 1 && response.like_status == 0) {
					
					$("#like_"+id).removeClass("Activelike");
					$("#dislike_"+id).addClass("Activeunlike");
					$("#commentlikedthumb_"+id).attr('src','{{ asset("uploads/thumbs-up-icon.png")}}');
					$("#commentdislikedthumb_"+id).attr('src','{{ asset("uploads/thumbs-down-icon-colored.png")}}');
				}    
 
			}
		});
		
		
	}	
	
$( document ).ready(function() {

	

	var myVideo = document.getElementById("video1");
	
	$('.playvideo').click(function(event) {
	  $(this).parent(".bannerab").css("background", "none")
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


function show_video(id)
	{
		var val= $('.videotest_'+id).attr('video_url');	

		$('.watch').attr('href',val); 
		$('.watch').trigger('click');
		 
	}	


function show_animatedvideo(id)
	{
		var val= $('.gifvideotest_'+id).attr('video_url');	

		$('.watch').attr('href',val); 
		$('.watch').trigger('click');
		 
	}		


	function copyUrl() {
	  var copyText = document.getElementById("copyUrl");
	  copyText.select();
	  copyText.setSelectionRange(0, 99999)
	  document.execCommand("copy");
	  
         $('#copyurl').text('Copied');
        
	  
	   //alert("Copied the text: " + copyText.value);
	}
	var cancelled = false;
	var old_title = $('#nextvideo').text();
	//alert(old_title);
	function stopvideo(){
		
		$("#video1")[0].setAttribute("cancelled", "true");
		
		$('#next_text').hide();

		//alert(old_title);
		var myDiv = document.getElementById("timerloader"),

		      show = function(){
		        timerloader.style.display = "none";
		        loader_close.style.display = "none";
		        next_text.style.display = "none";
		        upnext.style.display = "none";

		       // setTimeout(hide, 150000); // 15 seconds
		        nextvideodetails(old_title);
		       
		        
		      },

		      hide = function(){
		        timerloader.style.display = "none";
		        loader_close.style.display = "none";
		        next_text.style.display = "none";
		        upnext.style.display = "none";
		        playvideo(old_title);
		        //e.preventDefault();
		      };

		    hide();

		     

		     
	}
	function run(){
		//$('#next_text').show();
		//alert('first');
		var playnextvideoid = $('#playnextvideoid').val();

		
		//alert(playnextvideoid);
		 var myDiv = document.getElementById("timerloader"),

		      show = function(){
		        timerloader.style.display = "block";
		        loader_close.style.display = "block";
		        next_text.style.display = "block";
		        upnext.style.display = "block";
		        //alert(cancelled);
		        setTimeout(hide, 15000); // 15 seconds
		       // alert(cancelled);
		        nextvideodetails(old_title);
		        
		      },

		      hide = function(){
		        timerloader.style.display = "none";
		        loader_close.style.display = "none";
		        next_text.style.display = "none";
		        upnext.style.display = "none";
		        playvideo(old_title);
		      };

		    show();
			
		}
	function nextvideodetails(old_title){
		var cncl = $("#video1").attr("cancelled");
		

		if(cncl == 'true'){
			//$('#next_text').hide();
			return false;
		}else{
		var video_id = $('#videodetails_id').val();
		
		$.ajax({
			url: '{{ route("site.videoplayontimer")}}',
			method: 'post', 
			data: {
				video_idd: video_id,
				
				_token: '{{csrf_token()}}'
			},
			dataType: 'json',
			success: function(response) {
				console.log(response);
				
				if(response.videoDetails){
					
				 $('#next_text').text(response.videoDetails.video_title);
				 return false;
				}
			}
		});
	}
	}
	
  
	function playvideo(old_title){
		var cncl = $("#video1").attr("cancelled");
		
		if(cncl == 'true'){
			 $('#nextvideo').text(old_title);
			return false;
			}
		else{
			var video_id = $('#videodetails_id').val();
			//alert(video_id);
			//return false;
			var seg = '{{Request::segment(1)}}';
			$.ajax({
				url: '{{ route("site.videoplayontimer")}}',
				method: 'post', 
				data: {
					video_idd: video_id,
					seg: seg,
					_token: '{{csrf_token()}}'
				},
				dataType: 'json',
				success: function(response) {
					console.log(response);
					
					if(response.videoDetails){
						
					 window.location = "?p="+response.videoDetails.video_idddd;
					}else{
						
						$('#timerloader').hide();
						$('#loader_close').hide();
					}
				}
			});
		}
	}
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
		
			$('.postervideo1_'+y)[0].pause();
			$('.postervideo1_'+y).hide();
			$('.playhide_'+y).show();
			$('.imghome_'+y).show();
			$('.postervideo1_'+y)[0].load();
			
		}*/


var fullBtn = document.getElementById('fullScreen');

fullBtn.addEventListener('click', function(event) {
  var tgtEle = document.querySelector('.vidFrame');
  var  onOrOff = fullBtn.classList.contains('on');

  if (onOrOff) {
    enterFS(tgtEle);
    fullBtn.classList.remove('on');
    fullBtn.classList.add('off');
  } else {
    exitFS();
    fullBtn.classList.add('on');
    fullBtn.classList.remove('off');
  }
}, false);

function enterFS(element) {
  if (element.requestFullscreen) {
  	$(".detail_box").addClass('detail_box-2');
  	$(".v-overlay").addClass('videoFullScreen-cont ');
  	
    element.requestFullscreen();
  } else if (element.msRequestFullscreen) {
    element.msRequestFullscreen();
  } else if (element.mozRequestFullScreen) {
    element.mozRequestFullScreen();
  } else if (element.webkitRequestFullscreen) {
    element.webkitRequestFullscreen();
  }
}

function exitFS() {
  if (document.exitFullscreen) {
  	$(".detail_box").removeClass('detail_box-2');
  	$(".v-overlay").removeClass('videoFullScreen-cont ');
    document.exitFullscreen();
  } else if (document.msExitFullscreen) {
    document.msExitFullscreen();
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  }
}
	 // $('.videoFullScreen').click(function(){	 	
	 // 	 $(".detail_box").toggleClass('detail_box-2');
	 // });
</script>
@endsection 