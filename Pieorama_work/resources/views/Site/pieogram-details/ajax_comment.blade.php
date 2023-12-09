<script src="{{ asset('website/js/function.js')}}"></script>

<ul class="comment-box-list" id="ajax_comment" >
							<?php
	        					$path = url("uploads/");
	        				?>
	        		  	<?php $i =1; ?>
	        			@foreach($videoComment as $res)
	        				<li class="border_btm">
	        					<div class="comment-box-in">
		        					@if(!empty($res->getprofile_image->profile_image))

		        					<img src="{{$res->getprofile_image->profile_image}}" alt="" class="comment-userImage">
		        					@elseif(empty($res->getprofile_image->profile_image))
		        					<img src="{{ url('/website/') }}/images/nouserimage.png" alt="" class="comment-userImage">
		        					@endif

		        					<div class="comment-detail">
		        						<div class="comment-mesg-wrap">
			        						<p class="comment-u-name"> {{ $res->commentd_by_username }}
			        							<?php $time = Commenhelper::time_Ago($res->updated_at->toDateTimeString()); ?>
			        						 <span class="commnet-time">{{  $time  }}</span></p>
			        						<p class="commnet-messa">{{ $res->comment_text }} </p>

			        						<div class="comment-opt">
				        						@if( auth()->user()->id == $res->comment_by)<i class="fa fa-ellipsis-v" data-toggle="dropdown" aria-expanded="false"></i> @endif
				        						<div class="dropdown-menu">
												    <!--  <a class="dropdown-item edit-comment" href="javaScript:;" ><i class="fas fa-pencil-alt"></i> Edit</a> -->
												      <a class="dropdown-item delete-comment" onclick="javascript:delete_comment({{$res->id}})"><i class="far fa-trash-alt"></i> Delete</a>								      
												    </div>
				        					</div>

		        						</div>
		        						<input type="hidden" name="" id="video_id" value="<?php echo $video_id; ?>">
		        						<ul class="repl-view-list" id="view_reply<?php echo $res->id; ?>">
		        							<?php  
											$reply_list = Commenhelper::getreply($res->id,$video_id); 
		        							$total_reply = count($reply_list);

		        							  // echo "<pre>"; print_r($total_reply);
		        							
											$countArray = Commenhelper::count_like_dislike($video_id,$res->id);
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
											
											$user_count=Commenhelper::check_user_like_dislike_comment($video_id,$res->id,$user_id);
											
											
											
											?>

											<li class="like-comment">
												<input type="hidden" value="<?php echo $total_like; ?>" id="like_text_<?php echo $res->id; ?>">
												<input type="hidden" value="<?php echo $total_dislike; ?>" id="dislike_text_<?php echo $res->id; ?>"> 	
												<ul class="like-comment-ul replylikedislike">
													<li>
														<?php 
															$user_like_count=Commenhelper::check_user_like_comment($video_id,$res->id,$user_id);
															
															?>
														<a href="javascript:;" class="likebutton @if(isset($user_like_count)) Activelike @endif" id="like_<?php echo $res->id; ?>"  onclick="comment_like_dislike('1','<?php echo $res->id; ?>');" >
															<img id="commentlikedthumb_<?php echo $res->id; ?>" style="vertical-align: top;" @if(isset($user_like_count))  src="{{ asset('uploads/thumbs-up-icon-colored.png')}}" @else src="{{ asset('uploads/thumbs-up-icon.png')}}" @endif>

															<span class="value" id="like_count_<?php echo $res->id; ?>" ><?php echo $total_like; ?>
															</span>
														</a>
													</li>
													<li>
														<?php 
															$user_dislike_count=Commenhelper::check_user_dislike_comment($video_id,$res->id,$user_id);
															?>
														<a href="javascript:;" class="unlikebutton  @if(isset($user_dislike_count)) Activeunlike @endif" id="dislike_<?php echo $res->id; ?>"   onclick="comment_like_dislike('0','<?php echo $res->id; ?>');" >
															<img id="commentdislikedthumb_<?php echo $res->id; ?>" style="vertical-align: top;" @if(isset($user_dislike_count))  src="{{ asset('uploads/thumbs-down-icon-colored.png')}}" @else src="{{ asset('uploads/thumbs-down-icon.png')}}" @endif>

															<span class="value" id="dislike_count_<?php echo $res->id; ?>"><?php echo $total_dislike; ?></span>
														</a>     
													</li> 
												</ul>
											</li>
		        							
		        							<li class="reply-comment"><div class="reply-icon"></div><span class="value">Reply</span></li>
		        							<?php if($total_reply>1){ ?><li class="view-reply">
		        							<span class="no-reply">View <?php echo $total_reply; ?> Replies</span>
		        							<span class="hide-no">Hide Replies</span>
		        							<i class="fa fa-chevron-down"></i>
		        							</li> <?php }elseif($total_reply == 1){?>
		        								<li class="view-reply">
		        							<span class="no-reply">View <?php echo $total_reply; ?> Reply</span>
		        							<span class="hide-no">Hide Reply</span>
		        							<i class="fa fa-chevron-down"></i>
		        							</li><?php } ?>

		        							
		        							<div class="comment-box2-in">
					        					<input type="text" name="comment" class="comment-text" placeholder="Add a public comment..." id="replycommenttt_<?php echo $i; ?>" >
					        					<div class="comment-btn2">

					        					
									        				<button class="cancel-btn cancel-btn2"><i class="fa fa-times"></i></button>
									        				<button class="reply-btn" id="text_replyyyy<?php echo $i; ?>" ><i class="fa fa-paper-plane"></i></button>
					        						<input type="hidden" name="" id="comment_id<?php echo $i; ?>" value="<?php echo $res->id ?>">
					        					</div>
				        					</div>
				        					
				        					<script type="text/javascript">
			        						$(document).ready(function() { 
											 $('#text_replyyyy<?php echo $i; ?>').click(function(){
											 	//alert('#replycomment<?php echo $i; ?>');
												var comment1 = $('#replycommenttt_<?php echo $i; ?>').val();
												
												var comment_id = $('#comment_id<?php echo $i; ?>').val();
												
												var video_id = $('#video_id').val();

												$.ajax({
										          url     : '{{ route("site.addreplyPieogram")}}',
										          method  : 'post',          
										          data: { 
										               comment: comment1, 
										              video_id : video_id,
										              comment_id : comment_id,
										              
										             _token : '{{csrf_token()}}'
										          }, 
										          dataType: 'json',         
										          success : function(response){  
										          console.log(response);         
										             $('#ajax_comment').html(response.html);             
										             $('#totalcomment').html(response.total_comment + ' Comments ');
										             $('#totalcomment1').html(response.total_comment);
										             $('#view_reply<?php echo $res->id ;?>').addClass('open-repl'); 
										          }
											      });
													$('#replycommenttt_<?php echo $i; ?>').val('')
												
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
								        						@if( auth()->user()->id == $value->comment_by)<i class="fa fa-ellipsis-v" data-toggle="dropdown" aria-expanded="false"></i> @endif
								        						<div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 505px, 0px);" x-out-of-boundaries="">
																     <!-- <a class="dropdown-item edit-comment" href="javaScript:;"><i class="fas fa-pencil-alt"></i> Edit</a> -->
																      <a class="dropdown-item delete-comment" onclick="javascript:delete_comment({{$value->id}})"><i class="far fa-trash-alt"></i> Delete</a>								      
																    </div>
								        					</div>
							        					</div>

						        						<ul class="repl-view-list">
						        							<?php
															$countArray = Commenhelper::count_like_dislike($video_id,$value->id);
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
											
															$user_counts=Commenhelper::check_user_like_dislike_comment($video_id,$value->id,$user_id);
															
															
															?>
															<input type="hidden" value="<?php echo $total_likes; ?>" id="like_text_<?php echo $value->id; ?>">
															<input type="hidden" value="<?php echo $total_dislikes; ?>" id="dislike_text_<?php echo $value->id; ?>">  
															<li class="like-comment">
																<ul class="like-comment-ul replylikedislike">
																	<li>
																		<?php 
																		$user_like_counts=Commenhelper::check_user_like_comment($video_id,$value->id,$user_id);
																		//dd($user_like_counts);
																		?>
																		<a href="javascript:;" class="likebutton @if(isset($user_like_counts)) Activelike @endif" id="like_<?php echo $value->id; ?>"  onclick="comment_like_dislike('1','<?php echo $value->id; ?>');">
																				<img id="commentlikedthumb_<?php echo $value->id; ?>" style="vertical-align: top;" @if(isset($user_like_counts))  src="{{ asset('uploads/thumbs-up-icon-colored.png')}}" @else src="{{ asset('uploads/thumbs-up-icon.png')}}" @endif>
																			<span class="value" id="like_count_<?php echo $value->id; ?>" ><?php echo $total_likes; ?>
																			</span>
																		</a>
																	</li>
																	<li>
																		<?php 
																		$user_dislike_counts=Commenhelper::check_user_dislike_comment($video_id,$value->id,$user_id);
																		?>
																		<a href="javascript:;" class="unlikebutton @if(isset($user_dislike_counts)) Activeunlike @endif" id="dislike_<?php echo $value->id; ?>"   onclick="comment_like_dislike('0','<?php echo $value->id; ?>');" > 
																			<img id="commentdislikedthumb_<?php echo $value->id; ?>" style="vertical-align: top;" @if(isset($user_dislike_counts))  src="{{ asset('uploads/thumbs-down-icon-colored.png')}}" @else src="{{ asset('uploads/thumbs-down-icon.png')}}" @endif>
																			<span class="value" id="dislike_count_<?php echo $value->id; ?>" ><?php echo $total_dislikes; ?></span>
																		</a>     
																	</li>  
																</ul>
															</li>
						        							<li class="reply-comment"><div class="reply-icon"></div><span class="value">Reply</span></li>

						        							<div class="nested-comment-box-in">
									        					<input type="text" name="comment" class="comment-text" placeholder="Add a public comment..." id="reply_commenttts_<?php echo $value->id; ?>">
									        					<div class="comment-btn2">
									        						<button class="cancel-btn nested-cancel-btn2"><i class="fa fa-times"></i></button>
									        					<button class="reply-btn" id="text_replyyyy1<?php echo $value->id; ?>" ><i class="fa fa-paper-plane"></i></button>
									        						
									        					</div>
								        					</div>

						        						</ul>
						        					</div>
					        					</div>
			        						</div>	

			        						<script type="text/javascript">
			        						$(document).ready(function() { 
											 $('#text_replyyyy1<?php echo $value->id; ?>').click(function(){

											 	//alert('reply_comments<?php echo $value->id; ?>');
												var comment1 = $('#reply_commenttts_<?php echo $value->id; ?>').val();
												
												var video_id = $('#video_id').val();
												var comment_id = $('#comment_id<?php echo $i; ?>').val();
												$.ajax({
										          url     : '{{ route("site.addreplyPieogram")}}',
										          method  : 'post',          
										          data: { 
										               comment: comment1, 
										              video_id : video_id,
										              comment_id : comment_id,
										              
										             _token : '{{csrf_token()}}'
										          }, 
										          dataType: 'json',         
										          success : function(response){
										          	//console.log(response);
										            $('#ajax_comment').html(response.html);             
									             $('#totalcomment').html(response.total_comment + ' Comments ');
									             $('#totalcomment1').html(response.total_comment);
										             $('#view_reply<?php echo $res->id ;?>').addClass('open-repl'); 

										          }
											      });
													$('#reply_commenttts_<?php echo $value->id; ?>').val('')
												
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
<script type="text/javascript">

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
		}
		
		var new_dislike=current_dislike;	 
		if(type==0)
		{
			var new_dislike=Math.abs(parseInt(current_dislike)+1);
			var new_like=Math.abs(parseInt(current_like)-1);	
		}	

		$('#like_count_'+id).html(new_like);
		$('#dislike_count_'+id).html(new_dislike);  
		
		/*$('#like_'+id).removeAttr('onclick');
		$('#dislike_'+id).removeAttr('onclick');
		  */
		
		
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
				//console.log(response);
				$('#like_count_'+id).html(response.likes);
				$('#dislike_count_'+id).html(response.dislikes);
				
				if (response.like_status == 0 && response.dislike_status == 0) {
					//$("#like_"+id).removeClass("Activeunlike");
					$("#like_"+id).removeClass("Activelike");
					//$("#dislike_"+id).removeClass("Activelike");
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

	function delete_comment(id){
 		swal({
		  title: "Warning!",
		  text: "Are you sure you want to delete this comment?",
		  type: "warning",
		  cancelButtonColor: "#DD6B55",
          showCancelButton: true,
          cancelButtonText: "Cancel",
		  confirmButtonText: "Confirm"
		},
		function(isConfirm){
		  if (isConfirm) {
					var video_id = $('#video_id').val();
					$.ajax({
			          url     : '{{ route("site.deleteComments")}}',
			          method  : 'post',          
			          data: { 
			              id:id,               
			              video_id:video_id,               
			             _token : '{{csrf_token()}}'
			          }, 
			          dataType: 'json',         
			          success : function(response){
			             $('#ajax_comment').html(response.html);             
			             $('#totalcomment').html(response.total_comment + ' Comments ');
			             $('#totalcomment1').html(response.total_comment);
			          }
			      });		    
			  }
			});
	}


</script>