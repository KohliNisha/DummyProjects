

	<?php
	$path = url("uploads/");
	?>
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
																
																	
																<a href="javascript:;" class="likebutton_sdsgf" id="like_<?php echo $res->id; ?>" onclick="comment_like_dislike('1','<?php echo $res->id; ?>');" >
																		<img src="<?php echo $path; ?>/thumbs-up-icon.png">
																		<span class="value" id="like_count_<?php echo $res->id; ?>"><?php echo $total_like; ?>
																		</span>
																	</a>
																</li>

																<li>
																	<a class="unlikebutton_hhhhh" id="dislike_<?php echo $res->id; ?>"  onclick="comment_like_dislike('0','<?php echo $res->id; ?>');">
																		<img src="<?php echo $path; ?>/thumbs-down-icon.png">
																		<span class="value" id="dislike_count_<?php echo $res->id; ?>"><?php echo $total_dislike; ?></span>
																	</a>     
																</li> 
															</ul>
														</li>
														<li class="reply-comment" <?php if(empty(auth()->user())) { ?> href="javascript:;" class="" id="" data-toggle="modal" data-target="#myModal" <?php } ?>><span class="value">Reply</span></li>
															<?php if($total_reply>0){ ?>
														<li class="view-reply">
															<i class="fa fa-caret-down"></i>
															<span class="no-reply">View <?php echo $total_reply; ?> Replies</span>
															<span class="hide-no">Hide Replies</span>
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
													<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
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
																					<a href="javascript:;" class="likebutton_sssss" id="like_<?php echo $value->id; ?>"  onclick="comment_like_dislike('1','<?php echo $value->id; ?>');" >
																						<img src="<?php echo $path; ?>/thumbs-up-icon.png">
																						<span class="value" id="like_count_<?php echo $value->id; ?>"><?php echo $total_likes; ?>
																						</span>
																					</a>
																				</li>
																				<li>
																					<a href="javascript:;" class="unlikebutton" id="dislike_<?php echo $value->id; ?>"   onclick="comment_like_dislike('0','<?php echo $value->id; ?>');" > 
																						<img src="<?php echo $path; ?>/thumbs-down-icon.png">
																						<span class="value" id="dislike_count_<?php echo $value->id; ?>"><?php echo $total_dislikes; ?></span>
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
																				<button class="cancel-btn cancel-btn2"><i class="fa fa-times"></i></button>
																				<button class="reply-btn" id="text_reply1<?php echo $value->id; ?>" ><i class="fa fa-paper-plane"></i></button>
																			</div>
																		</div>
																	<?php } ?>
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
