@extends('layouts.site.web.webapp')
@section('content')

<!-- right-panel -->
<div class="right_panel pieorama-friends-wrapper">
	<div class="vd_container">
		<div class="spf-wrappers">
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
					</div>
				</div>
			</div>
			<div class="search-pieorama-friends">
				<!-- <form action="" method="post"> -->
				<div class="form-group">
					<input type="text" id="pieorama-friends" name="search" class="custom-textbox custom-textbox2 wholesrchmain" placeholder="Search Your Pieorama Friends">
				</div>
				<!-- </form> -->
				<div class="pf-list">
					<ul>
						<?php if($searchedusers){
						//print_r($searchedusers); die;
						foreach ($searchedusers as $key => $value) { ?>
						<li class="pfl-in">
							<div class="profLeft">
								<a href="{!! url('pieorama-user-profile/'.base64_encode(base64_encode($value['id']))) !!}">
									<?php  $profile_image = $value['profile_image'];
									if($profile_image == "" || $profile_image == null){ ?>
									<img src="{{ asset('website/images/nouserimage.png')}}" alt="Pieorama user" class='user-image3'>
									<?php } else { ?>
									<img src="{{ $profile_image }}" alt="Pieorama user" class='user-image3'>
									<?php } ?>
									<div class="pf-name">{{$value['first_name'] .' '. $value['last_name']}}</div>
								</a>
							</div>
							<div class="unfriend-btn-wrap">
								<a href="javascript:;" class="btn btn-primary unfriend-btn">Add Friend</a>
							</div>
						</li>
						<?php }
						} else {
						echo "No pieorama friend found. Search user by the name and add friend or visit profile.";
						} ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection