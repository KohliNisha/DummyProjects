@extends('layouts.site.web.webapp')
@section('content')
<!-- right-panel -->
    
<div class="right_panel prof-wrapper my-prof-wrapper">
	<div class="vd_container">
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
						<button class="btn btn-primary edit-prof-btn" data-toggle="modal" data-target="#editProfile">Edit Profile</button>
					</div>
				</div>
			</div>
		</div>
		
	</div>
</div>

<!-- Edit profile modal -->
<div class="modal login_modal editprofile_modal editprofile_modal-2" id="editProfile">
	<div class="modal-dialog">
		<div class="modal-content">
			<button type="button" class="close md_close" data-dismiss="modal">&times;</button>
			<!-- Modal body -->
			<div class="modal-body">
				<form action="{{route('site.updateprofile')}}" method="POST" autocomplete="off" id="updateProfileform" enctype="multipart/form-data">
					@csrf
					<div class="editProfile-popImg">
						<div class="user-image">
							<?php if($user->profile_image) { ?>
							<img src="{{ $user->profile_image }}" alt="Profile picture" class="profile-pic">
							<?php }  else { ?>
							<img src="{{ asset('website/images/nouserimage.png')}}" alt="Profile picture" class="profile-pic">
							<?php } ?>
							<div class="p-up-image ">
								<i class="fas fa fa-camera upload-button" ></i>
								<input class="file-upload" type="file" name="profile_image" id="profileimage" accept="image/*">
							</div>
						</div>
					</div>
					<div class="row align-items-center">
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="firstname" class="custom-label">First Name</label>
								<input type="text" id="firstname" name="first_name" value="{{ $user->first_name }}" class="custom-textbox"  placeholder="First Name" >
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="lastname" class="custom-label">Last Name</label>
								<input type="text" id="lasttname" name="last_name" value="{{ $user->last_name }}"  class="custom-textbox"  placeholder="Last Name" >
							</div>
						</div>
					</div>
					<div class="row align-items-center">
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="email" class="custom-label">Enter E-mail Address</label>
								<input type="text" id="email" name="email" value="<?php echo $user->email; ?>"   class="custom-textbox txt-disable"  placeholder="Email Address" disabled>
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<?php if($user->date_of_birth){
								$UserDob = $user->date_of_birth;
								$newDate = date("m/d/Y", strtotime($UserDob));
								} else {
								$newDate = '';
								} ?>
								<label for="dateofbirthUpdate" class="custom-label">Date of Birth</label>
								@if($newDate != '')
								<input type="text" id="dateofbirthUpdate" name="date_of_birth" readonly="readonly" class="custom-textbox" value="<?php echo $newDate; ?>"  placeholder="Date of Birth" required disabled>
								@else
								<input type="text" id="dateofbirthUpdate" name="date_of_birth" readonly="readonly" class="custom-textbox" value="<?php echo $newDate; ?>"  placeholder="Date of Birth" required>
								

									

							
								@endif
							</div>
							
						</div>
					</div>

					<div class="row align-items-center">
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="gender" class="custom-label">Gender</label>

								<input type="text" id="gender" name="gender"  value="<?php echo $user->gender ?>"  class="custom-textbox"  placeholder="Enter gender" >
								
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="cityname" class="custom-label">City</label>
								<input type="text" id="cityname" name="city" value="{{ isset($userAddress->city) ? $userAddress->city : '' }}"  class="custom-textbox"  placeholder="Enter City">
							</div>
						</div>
						
					</div>
					<div class="row align-items-center">
						
						
					</div>
					<div class="row align-items-center">
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="state" class="custom-label">State</label>
								<input type="text" id="state" name="state" value="{{ isset($userAddress->state) ? $userAddress->state : '' }}"   class="custom-textbox"  placeholder="Enter State" >
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<div class="form-group">
								<label for="country" class="custom-label">Country</label>
								
								
								 <select id="country" name="country" class="custom-selectbox">
									@if(isset($userAddress))
										<option value="">Please Select</option>
									@endif
								    @foreach($countries as $c)
									   <option value="{{$c->name}}"  @if(isset($userAddress)) {{$userAddress->country == $c->name ? 'selected' : ''}} @endif>{{$c->name}}</option>
								    @endforeach
									 
								</select> 
							</div>
						</div>
					</div>
					<div class="d-flex flex-row-reverse">
						<div>
							<span class="lgt">Save</span>
							<button type="submit" id="edit_btnnn" class="login_btn updatePrbtn">
								<i class="fas fa fa-arrow-right"></i>
								<div class="disable-updateprof-doteBtn ">
									<i></i>
									<i></i>
									<i></i>
								</div>
							</button>
						</div>  
					</div>
					<div class="alert signup-success" style="display: none; margin-bottom: 30px;"> </div>
					<div class="alert signup-danger" style="display: none;  margin-bottom: 30px;"> </div>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- pieogram-details-2 modal -->
<!-- 	<script src="js/jquery-ui.js"></script>	 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript">
	$(function() {

		$("#dob").datepicker({
			changeMonth: true,
			changeYear: true,

		});
	});
	$(".editprofile_modal").scroll(function() {
		$('#dob').datepicker("hide");
		$('#dob').blur();
	});
	

//updateProfileform


$('#edit_btnnn').on('click',function(){
	setTimeout(function(){
	  $('#edit_btnnn').addAttr('disabled');
	}, 15000);
	
});



	
	
</script>
@endsection