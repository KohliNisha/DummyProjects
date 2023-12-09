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
	
	
</style>
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
					$path = url("uploads/"); 
					$img='https://via.placeholder.com/300';
					if($videoDetails->video_thumbnail_file_path!='')
					{
					$thumb=$videoDetails->video_thumbnail_file_path;
					$str=strpos($thumb, 'cloudinary');
					if ($str=='') 
					{
					$img=$path.'/'.$thumb;
					}		
					}	
					?>
					<div>
					<?php  //$MainPageThumb = $videoDetails->video_thumbnail_file_path; 
					// Now it's static thumb
					$MainPageThumb = asset('thumbs/1568610309158106469.jpg') ;
					?>
						<!-- <div class="VideoDetails clickonviewVideo"  style='background: url("<?php echo $img; ?>") center center no-repeat; background-size: cover;'> -->
						<div class="VideoDetails clickonviewVideo" >
							<video id="video_details1" class="" style="background: #fafafa;" width="100%" height="100%" controls onended="run()">
								<source id="mp4video" src="<?php echo url('/uploads/').'/'.$videoDetails->video_file_path; ?>" type="video/mp4">
							</video>
							<span class="play_icon gif_loader" id="timerloader" style="display: none;" >
							  <img src="{{ asset('website/images/Ajaxloader.gif')}}">
							
							</span>
							<span class="play_icon playvideo">
								<img src="{{ asset('website/images/play.png')}}" alt="images">
							</span>
							<!-- <p id="timerpopup"></p> -->
							
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

					$path = url("uploads/"); 
					?>
					
					<input type="hidden" id="video_id" name="video_id" value="{{ $videoDetails->id }}">
					<div class="detail_info px-0 pt-3">
						<div class="form-row align-items-center">
							<div class="col-xl-7 col-lg-6">
								<h1 class="page-subtitle mb-0 mt-1">{{ substr($videoDetails->video_title, 0,555) }}</h1>
								
							</div>
							<div class="col-xl-5 col-lg-6 side-share text-lg-right mt-3 mt-lg-0">
								<?php
								if($videoDetails->video_file_path!='')
								{
								?>		
								
								<ul>
									
									<li class="source_video pl-0">
										<span>Source video</span>
										<a class="" id="videolink" @if(!empty($videoDetails->original_video_path)) href="#videostory" @else data-toggle="modal" data-target="#video-popup" tabindex="0" @endif>
											<img style="vertical-align: top;" src="<?php echo $path; ?>/video_source.png">
										</a>
										
									</li>
									
										<div id="videostory" class="mfp-hide" style="max-width: 75%; margin: 0 auto;">
										<iframe id="ddddd" width="560" height="550" src="<?php echo url('/originalVideo/').'/'.$videoDetails->original_video_path; ?>" frmaborder = "0" allowfullscreen></iframe>
										</div> 


								
									
									<li class="source_video">
										<span>Share</span>
										<a href="javascript:void(0)" onclick="javascript:genericSocialShare('[CustomSocialShareLink]')">
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
										echo $NewCreatedDate = date('d M Y', strtotime($date));
										?>
									</div>
								</div>
								<div class="col-auto">
									<ul class="detail_icons mt-0 d-inline-block">
										@if(!empty(auth()->user()->id))
										<li>
											<a href="javascript:;" class="likebutton <?php if($like_status==1) { echo "Activelike"; } ?>" id="Activelike" onclick="javascript:video_like()" >
												<!--<i class="fa fa-thumbs-up" class="icon"></i>-->
												<img style="vertical-align: top;" src="<?php echo $path; ?>/thumbs-up-icon.png">
												<span class="value" id="like_count">{{ $total_count_like}} </span>
											</a>
										</li>
										<li  style="padding-right: 0 !important;">
											<a href="javascript:;" class="unlikebutton <?php if($dislike_status==1) { echo "Activeunlike"; } ?>" id="Activeunlike" onclick="javascript:video_dislike()" >
												<!--<i class="fa fa-thumbs-down" class="icon"></i>-->
												<img style="vertical-align: top;" src="<?php echo $path; ?>/thumbs-down-icon.png">
												<span class="value" id="dislike_count">{{ $total_count_dislike}} </span>
											</a> 
										</li> 
										@else
										<li>
											<a href="javascript:;" class="likebutton" id="Activelike" data-toggle="modal" data-target="#myModal">
												<!--<i class="fa fa-thumbs-up" class="icon"></i>-->
												<img style="vertical-align: top;" src="<?php echo $path; ?>/thumbs-up-icon.png">
												<span class="value" id="like_count">{{ $total_count_like}} </span>
											</a>
										</li>
										<li  style="padding-right: 0 !important;">
											<a href="javascript:;" class="unlikebutton" id="Activeunlike" data-toggle="modal" data-target="#myModal">
												<!--<i class="fa fa-thumbs-down" class="icon"></i>-->
												<img style="vertical-align: top;" src="<?php echo $path; ?>/thumbs-down-icon.png">
												<span class="value" id="dislike_count">{{ $total_count_dislike}} </span>
											</a>  
										</li>  
										@endif

										<?php
										if($videoDetails->video_file_path!='')
										{
										$path = url("uploads/"); 	
										$video_path=url('/uploads/').'/'.$videoDetails->video_file_path;	
										}
										?>
									</ul>
									<ul class="detail_icons mt-0 d-inline-block border-bottom-0 ml-3">
										<li>
											<a href="javascript:;">
												
												<img style="vertical-align: top;" src="<?php echo $path; ?>/share-icon.png">
												<span class="value" id="shared_value"><?php echo $totalsharecount ?></span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>

						<div class="pt-3">
							<?php
							if(!empty($videoTags))
							{
							foreach($videoTags as $row)
							{
							$tagArrays[]=array(
							'tag_name'=>$row->tag_text,
							);	
							}	

							}
							$tag_namee='';
							if(!empty($tagArrays))
							{
							foreach($tagArrays as $row)
							{
							$tag_namee .='#'.$row['tag_name'].' ';
							}	 
							?>
							<div class="text-md-right">
								<h5 class="mb-0 mr-1"><?php echo $tag_namee; ?></h5>
							</div>
							<?php
							}	
							?>

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
										{{ $videoDetails->video_description}}
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
															@if( auth()->user()->id == $res->comment_by)<i class="fas fa fa-ellipsis-v" data-toggle="dropdown" aria-expanded="false"></i> @endif <?php }?>
															<div class="dropdown-menu">
																<!--<a class="dropdown-item edit-comment" href="javaScript:;" ><i class="fas fa-pencil-alt"></i> Edit</a> -->
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
														
														 
														 
														?>
														<li class="like-comment">
															<input type="hidden" value="<?php echo $total_like; ?>" id="like_text_<?php echo $res->id; ?>">
															<input type="hidden" value="<?php echo $total_dislike; ?>" id="dislike_text_<?php echo $res->id; ?>"> 
															<ul class="like-comment-ul">
																<li>
																
																	
																<a href="javascript:;" class="likebutton" id="like_<?php echo $res->id; ?>" <?php if($user_count==0) { ?> onclick="comment_like_dislike('1','<?php echo $res->id; ?>');" <?php } ?>>
																		<img src="http://smartzitsolutions.com/pieorama/public/uploads/thumbs-up-icon.png">
																		<span class="value" id="like_count_<?php echo $res->id; ?>"><?php echo $total_like; ?>
																		</span>
																	</a>
																</li>
																<li>
																	<a href="javascript:;" class="unlikebutton" id="dislike_<?php echo $res->id; ?>"  <?php if($user_count==0) { ?> onclick="comment_like_dislike('0','<?php echo $res->id; ?>');" <?php } ?>>
																		<img src="http://smartzitsolutions.com/pieorama/public/uploads/thumbs-down-icon.png">
																		<span class="value" id="dislike_count_<?php echo $res->id; ?>"><?php echo $total_dislike; ?></span>
																	</a>     
																</li> 
															</ul>
														</li>
														<li class="reply-comment"><span class="value">Reply</span></li>
															<?php if($total_reply>0){ ?>
														<li class="view-reply">
															<i class="fa fa-caret-down"></i>
															<span class="no-reply">View <?php echo $total_reply; ?> replies</span>
															<span class="hide-no">Hide replies</span>
														</li>
														<?php }?>
														<div class="comment-box2-in">
															<input type="text" name="comment" class="comment-text" placeholder="Add a public comment..." id="replycomment<?php echo $i; ?>">
															<div class="comment-btn2">
																<button class="cancel-btn cancel-btn2"><i class="fa fa-times"></i></button>
																<button class="reply-btn" id="text_reply<?php echo $i; ?>" ><i class="fa fa-paper-plane"></i></button>
																<input type="hidden" name="" id="comment_id<?php echo $i; ?>" value="<?php echo $res->id ?>">
															</div>
														</div>

				<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
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
																			@if( auth()->user()->id == $value->comment_by)<i class="fas fa fa-ellipsis-v" data-toggle="dropdown" aria-expanded="false"></i> @endif <?php }?>
																			<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 505px, 0px);" x-out-of-boundaries="">
																				<!--<a class="dropdown-item edit-comment" href="javaScript:;"><i class="fas fa-pencil-alt"></i> Edit</a>-->
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
																			<ul class="like-comment-ul">
																				<li>
																					<a href="javascript:;" class="likebutton" id="like_<?php echo $value->id; ?>" <?php if($user_counts==0) { ?> onclick="comment_like_dislike('1','<?php echo $value->id; ?>');" <?php } ?>>
																						<img src="http://smartzitsolutions.com/pieorama/public/uploads/thumbs-up-icon.png">
																						<span class="value" id="like_count_<?php echo $value->id; ?>"><?php echo $total_likes; ?>
																						</span>
																					</a>
																				</li>
																				<li>
																					<a href="javascript:;" class="unlikebutton" id="dislike_<?php echo $value->id; ?>"  <?php if($user_counts==0) { ?> onclick="comment_like_dislike('0','<?php echo $value->id; ?>');" <?php } ?>> 
																						<img src="http://smartzitsolutions.com/pieorama/public/uploads/thumbs-down-icon.png">
																						<span class="value" id="dislike_count_<?php echo $value->id; ?>"><?php echo $total_dislikes; ?></span>
																					</a>     
																				</li> 
																			</ul>
																		</li>
																		
																		<li class="reply-comment">
																			<div class="reply-icon"></div><span class="value">Reply</span>
																		</li>
																		<div class="nested-comment-box-in">
																			<input type="text" name="comment" class="comment-text" placeholder="Add a public comment..." id="reply_comments<?php echo $value->id; ?>">
																			<div class="comment-btn2">
																				<button class="cancel-btn cancel-btn2"><i class="fa fa-times"></i></button>
																				<button class="reply-btn" id="text_reply1<?php echo $value->id; ?>" ><i class="fa fa-paper-plane"></i></button>
																			</div>
																		</div>
																	</ul>
																</div>
															</div>
														</div> 

														<script type="text/javascript">
															$(document).ready(function() {
																$('#text_reply1<?php echo $value->id; ?>').click(function() {
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
								</div>
							
							
								  
							
							
							</div>
							<!-- Comment End -->
							
							
						<div class="load_more_sec">	
						<a href="javascript:void(0);" class="comm_load_more" onclick="load_more();">Load More</a>	
						<input type="hidden" name="tot_rec" id="tot_rec" value="1">	 
						<input type="hidden" name="total_record" id="total_record" value="<?php echo $total_count_comm; ?>">	 
						<input type="hidden" name="page" id="page" value="2"> 	  
						<input type="hidden" name="video_id" id="video_id" value="<?php echo $video_id; ?>">	 
						<input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">	 
						<script> 
							
							function load_more()
							{
								var current_record=$('.comment_row').length; 
								var tot_rec=$('#tot_rec').val();
								var video_id=$('#video_id').val();
								var current_page=$('#page').val();
								var total_record=$('#total_record').val();
								
								
								
								
								

								/* alert(current_record);
								alert(tot_rec);
								alert(video_id);
								alert(current_page);

								return false; */ 
 
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


										$(response).insertAfter('.comment_row:last');	
										var current_record=$('.comment_row').length;
										//alert(current_record);
										//alert(total_record);

 
										if(current_record==total_record) 
										{   
											$('.comm_load_more').hide(); 
										}   	 
									}
								});
								
								
								
							}
							</script>
						</div>	
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

						<!--<div class="border_btm no_border_btm">
							<div class="detail_column d-flex justify-content-between align-items-center pdt flex-wrap">
								<ul class="detail_order anima-ul">
									<li>
										Animated GIF
									</li>
									<li>
									<a href="{{ $videoDetails->video_animated_file_path }}" target="_blank">	<button class="btn btn-primary">Preview</button></a>
									</li>
									<li>
										<button class="btn btn-default" onclick="Copy();" id="copyurl" >Copy Url</button>
									</li>
									<li>
										<textarea id="url" style="margin-top: 12px; margin-left: 20px; font-size: 18px; display: none;" rows="1" cols="35"></textarea>
									</li>
								</ul>
								<div>
									@if($videoDetails->is_owner)
									<form action="{{route('site.deletePieogram')}}" method="POST" autocomplete="off" id="deletepie">
															@csrf
									<input type="hidden" readonly="readonly" id='encoded_pieogramid' name="encoded_pieogramid" value="{{  $videoDetails->encoded_pieogramid }}">
									<button type="submit" class="share_btn delete_btn delete_btnpieorama">
																	<img src="{{ asset('website/images/delete.png')}}"  alt="">
																</button>

																</form>
																@endif
								</div>

							</div>
						</div>-->
					</div>
				</div>
			</div>

			<div class="col-xl-3 col-lg-4">
				<ul class="christanPieograms-wrapper clearfix rgtside-productListWrap">
					@if($AllVideos)
					<?php  
					$i=0;
					$path = url("uploads/"); 
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
					$duration=$all_userss[$i]['duration'];
					$img='https://via.placeholder.com/300';
					if($ChannelVideosItem->video_thumbnail_file_path!='')
					{
					$thumb=$ChannelVideosItem->video_thumbnail_file_path;
					$str=strpos($thumb, 'cloudinary');
					if ($str=='') 
					{
					$img=$path.'/'.$thumb;
					}		
					}	
					?>
					<?php
					$video_idddd=base64_encode($ChannelVideosItem->id);

					$video_idddd=urlencode(base64_encode($video_idddd));
					?>
					<li>
						<div class="vid_bx" >
							<div class="thumbnail" onmouseover="bigImg('<?php echo url('/').'/watch/?p='.$video_idddd; ?>', '<?php echo $ChannelVideosItem->id; ?>')" onmouseout="bigImg2('<?php echo url('/').'/watch/?p='.$video_idddd; ?>', '<?php echo $ChannelVideosItem->id; ?>')">
								<a href="{!! url('watch/?p='.base64_encode(base64_encode($ChannelVideosItem->id)))  !!}"> 
									
									<img src="<?php echo $img; ?>" alt="image" class="imghome_<?php echo $ChannelVideosItem->id; ?>" > 
									   <video  data-play = "Hover"  class="postervideo1_<?php echo $ChannelVideosItem->id; ?>" style="display: none; width: 100%; height: 137px;" muted="muted">
									  	 <source src="<?php echo url('/uploads/').'/'.$ChannelVideosItem->video_file_path; ?>" type="video/mp4">

								 	  </video> 
									
									<div class="middle">
										<div class="text">{{ substr($ChannelVideosItem->video_title, 0,28) }}</div>
									</div>
								</a>
							</div>
							<div class="video-details">
								
								<?php

								$tag_nameee='';
								if(!empty($tags))
								{
									foreach($tags as $row)
									{
										$tag_nameee .='#'.trim($row['tag_name']).' ';
									}	 
								}	
								?>
								<h4><?php echo $tag_nameee; ?></h4>
								<?php 
								$date =  $ChannelVideosItem->created_at;
								$NewCreatedDate = date('d M Y', strtotime($date));
								$NewCreatedTime = date('h:i A', strtotime($date));
								?>
								<div class="thumbnail-content">
									<div class="row justify-content-between mt-2 mb-2">
										<div class="col-auto"><span class="category w-100 mb-0"><?php echo $first.' '.$last; ?></span></div>
										<div class="col-auto"><span class="Date">{{$NewCreatedDate}}</span></div>
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

										<div class="clock-count">
											<i class="fa fa-clock-o" aria-hidden="true"></i>
											<span class="dislike-count" data-id="1346"><?php echo $duration; ?>s</span>
										</div>       

									</div>
								</div>
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
<!-- Report comment popup end -->

<?php
if($videoDetails->video_file_path!='')
{
?>
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
<div class="modal fade share-popup" id="video_timer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded-0" style="background-color: unset!important">
			
			<div class="modal-body" >
				<div class="row begin-countdown">
				  <div class="col-md-12 text-center">
				    <progress value="15" max="15" id="pageBeginCountdown"></progress>
				    <p style="color: #fff;"> Begining in <span id="pageBeginCountdownText">15 </span> seconds</p>
				  </div>
				</div>
  			</div>
		</div>
	</div>
</div>
<div class="modal fade share-popup" id="share-popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content rounded-0">
			<div class="modal-header border-bottom-0">
        <h5 class="modal-title">Share</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
			<div class="modal-body">
				<div class="text-center">
					<ul class="social-share-list">
						<li>
							<a href="https://www.facebook.com/share.php?u=<?php echo $video_path; ?>&quote=<?php echo $videoDetails->video_title; ?>&image=<?php echo $videoDetails->video_thumbnail_file_path; ?>" target="_blank" onclick="javascript:social_share('facebook')"><img src="<?php echo $path.'/facebook.png'; ?>" alt=""></a>
						</li>
						<li>
							<?php
							$test = str_replace(' ', '%20', $video_path);

							?>
							<a href="https://twitter.com/intent/tweet?status=<?php echo $videoDetails->video_title; ?>+url= <?php echo urlencode($test); ?>" target="_blank" onclick="javascript:social_share('twitter')"><img src="<?php echo $path.'/twitter.png'; ?>" alt=""></a>
						</li>
						<li>
							<a href=" https://plus.google.com/share?Url=<?php echo urlencode($video_path); ?>&quote=<?php echo $videoDetails->video_title; ?>&caption=<?php echo $videoDetails->video_description; ?>" target="_blank" onclick="javascript:social_share('tumblr')"><img src="<?php echo $path.'/instagram.png'; ?>" alt=""></a>
						</li>
						
						<li>
							
							<a href="https://www.linkedin.com/sharing/share-offsite?url=<?php echo urlencode(Request::fullUrl()); ?>" target="_blank" onclick="javascript:social_share('linkedin')"><img src="<?php echo $path.'/linkedin.png'; ?>" alt=""></a>
						</li>
						<li>
							<a href="https://www.youtube.com/?url=<?php echo url()->current(); ?>&media=<?php echo $video_path; ?>&description=<?php echo $videoDetails->video_title; ?>" target="_blank" onclick="javascript:social_share('pinterest')"><img src="<?php echo $path.'/youtube.png'; ?>" alt=""></a>
						</li>
					</ul>
					<div class="copy-url-box">
						<div class="copy-url-box-inner"><input id="copyUrl" class="copy-url-field" type="text" value="https://pieorama.fun/fRte_45Tfx">
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
<script  src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
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
		
		var total_comment=$('.comment_row').length;
		if(total_comment==0)
		{
			$('.load_more_sec').hide(); 	
		}
		
		
		
		
	});
</script>
<script type="text/javascript">
	function text_comment() {

		$('.comm_load_more').show(); 
		
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
		$('#share-popup').modal('show');
		return true;
	}

	function social_share(type) {
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
					$("#Activelike").addClass("Activelike");
				} else if (response.data.like_status == 0) {
					$("#Activelike").removeClass("Activelike");
				} else if (response.data.dislike_status == 1) {
					$("#Activelike").removeClass("Activelike");
					$("#Activeunlike").addClass("Activeunlike");
				} else if (response.data.dislike_status == 0) {
					$("#Activeunlike").removeClass("Activeunlike");
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
					$("#Activeunlike").addClass("Activeunlike");
				} else if (response.data.dislike_status == 0) {
					$("#Activeunlike").removeClass("Activeunlike");
				} else if (response.data.like_status == 1) {
					$("#Activeunlike").removeClass("Activeunlike");
					$("#Activelike").addClass("Activelike");
				} else if (response.data.like_status == 0) {
					$("#Activelike").removeClass("Activelike");
				}

			}
		});
	}
	
	function comment_like_dislike(type,id)
	{
		
		//alert('aaaaaaaaa');
		//return false; 
		
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
			var new_like=parseInt(current_like)+1;	
		}
		
		var new_dislike=current_dislike;	 
		if(type==0)
		{
			var new_dislike=parseInt(current_dislike)+1;	
		}	

		$('#like_count_'+id).html(new_like);
		$('#dislike_count_'+id).html(new_dislike);  
		
		$('#like_'+id).removeAttr('onclick');
		$('#dislike_'+id).removeAttr('onclick');
		  
		
		
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
				
				$('#like_count_'+id).html(response.likes);
				$('#dislike_count_'+id).html(response.dislikes);
				
				//alert(response.likes);  
				//alert(response.dislikes);   
 
			}
		});
		
		
	}	
	


	
	
</script>
<script type="text/javascript">
	$('#videolink').magnificPopup({
		type: 'inline',
		midClick:true,
		closeBtnInside:true,
		closeOnContentClick:false,
		closeOnBgClick:true,
		showCloseBtn:true,
		/*enableEscapeKey:true,
		autoplay:false,
		preload:false, */ 

		
		 
	});
	$(document).ready(function(){
		//$('.mfp-close').trigger('click');
		$('.mfp-close').on('click',function(){
			alert('sfafsdgf');
		});

	});
	
	


</script>
<script type="text/javascript">
	function copyUrl() {
	  var copyText = document.getElementById("copyUrl");
	  copyText.select();
	  copyText.setSelectionRange(0, 99999)
	  document.execCommand("copy");
	  
         $('#copyurl').text('Copied');
        
	  
	   //alert("Copied the text: " + copyText.value);
	}
</script>

<script type="text/javascript">
	
	function run(){
		 
		
		 var myDiv = document.getElementById("timerloader"),

		      show = function(){
		        timerloader.style.display = "block";
		        setTimeout(hide, 15000); // 15 seconds
		      },

		      hide = function(){
		        timerloader.style.display = "none";
		        playvideo();
		      };

		    show();
		
		}
  
	function playvideo(){
		
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
					
				 window.location = "?p="+response.videoDetails.video_idddd;
				}else{
					
					$('#timerloader').hide();
				}
			}
		});
	}
</script>
<script type="text/javascript">
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

	
</script>
<script type="text/javascript">
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

</script>
<!-- <script type="text/javascript">
	$(document).ready(function(){
 	
 	$('#video_details1')[0].play();
 });
</script> -->
@endsection 