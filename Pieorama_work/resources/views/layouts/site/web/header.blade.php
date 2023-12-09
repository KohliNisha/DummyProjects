

<header id="header">
	<div class="container-fluid header-part">
		<div class="row justify-content-between align-items-center">
			<div class="col-auto">
				<div class="logo">
					<a href="{!! url('/welcome'); !!}">
						<img src="{{ asset('images/Animated_PieOrama_logo_small.gif')}}" alt="Logo">
					</a>
				</div>
			</div>
			@if(Request::segment(1) != 'landingPage')
			<div class="col-auto">
				<div class="search_br transition">
					<form name="search" id="search" action="{{route('site.search')}}" method="post"> 
						
						<input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
						<input type="text" id="search_text" placeholder="Search" name="search_text"  @if(isset($search_text)) value="{{$search_text}}" @else value="" @endif>
						<button class="h-search-btn" id="searchbtn" type="submit" name="submit"><i class="fa fa-search"></i></button>
					</form>
					
					
				</div>
				<div class="h_links transition">
					<ul>
						<li>
							<a href="{!! url('/home'); !!}" class="transition {{ request()->is('home') ? 'active' : '' }}">Home</a>
						</li>
						<li>
							<a href="{!! url('/about-pieorama'); !!}" class="transition {{ request()->is('about-pieorama') ? 'active' : '' }}">PieOrama</a>
						</li>
						<li>
							<a href="{!! url('/gif-corner'); !!}" class="transition {{ request()->is('gif-corner') ? 'active' : '' }}">GIF Corner</a>
						</li>
						<!-- <li> 
							<a href="{!! url('/pie-history'); !!}" class="transition {{ request()->is('pie-history') ? 'active' : '' }}">Pie Throwing</a>
						</li> -->
					</ul>
					<i class="fa fa-times"></i>
					<!--new-->
					<div class="content-hide">
						@if(auth()->user())
						<ul class="h_icons pop_sec">
							<li>
								<a href="javascript:;">
									<img src="{{ asset('website/images/list.png')}}" alt="images">
								</a>
							</li>
							<li>
								<a href="javascript:;" class="notifi-icon">	
									<span class="pend-notifi" style="display: none;">0</span>
								</a>
							</li>
							<li>
								<a class="name dropdown-toggle " href="javascript:;" data-toggle="dropdown">
									<?php  $profile_image = auth()->user()->profile_image; 
									if($profile_image == "" || $profile_image == null){ 
									echo "<span class='h_unfl'>"; 
									$fname = auth()->user()->first_name; 
									$fnameUser = substr($fname,0,1);
									echo strtoupper($fnameUser);
									echo "</span>";
									} else { ?>
									<img src="{{ $profile_image }}" alt="" class="h_prof-image">
									<?php } ?>
								</a>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="{!! url('/my-profile'); !!}">My Profile</a>
									<!--<a class="dropdown-item" href="{!! url('/my-friend-list/friends'); !!}">My Pieorama Friends</a>-->
									<a class="dropdown-item" href="{!! url('/logout'); !!}">Logout</a>
							    </div>
							</li>
						</ul>
						@else
						<div class="h_links_2 pop_sec">
							<ul>
								<li>
									<a href="javascript:;" data-toggle="modal" data-target="#myModal">
										Sign In
									</a>
								</li>
								<li>
									<a href="javascript:;" data-toggle="modal" data-target="#myModal2">
										Sign Up
									</a>
								</li>
							</ul>
						</div>
						@endif
					</div>
					<!--new-->
				</div>
				<div class="mb_srch_bar">
					<i class="fa fa-search"></i>
				</div>
				<div class="mb_slide">
					<i class="fa fa-ellipsis-v"></i>
				</div>
			</div>
			<div class="col-auto">
				<div class="login-hide">
						@if(auth()->user())
						<ul class="h_icons pop_sec">
							<li>
								<a href="javascript:;">
									<img src="{{ asset('website/images/list.png')}}" alt="images">
								</a>
							</li>
							<li>
								<a href="javascript:;" class="notifi-icon">	
									<span class="pend-notifi" style="display: none;">0</span>
								</a>
							</li>
							<li>
								<a class="name dropdown-toggle " href="javascript:;" data-toggle="dropdown">
									<?php  $profile_image = auth()->user()->profile_image; 
									if($profile_image == "" || $profile_image == null){ 
									echo "<span class='h_unfl'>"; 
									$fname = auth()->user()->first_name; 
									$fnameUser = substr($fname,0,1);
									echo strtoupper($fnameUser);
									echo "</span>";
									} else { ?>
									<img src="{{ $profile_image }}" alt="" class="h_prof-image">
									<?php } ?>
								</a>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="{!! url('/my-profile'); !!}">My Profile</a>
									<!-- <a class="dropdown-item" href="{!! url('/my-friend-list/friends'); !!}">My Pieorama Friends</a> -->
									<!-- <a class="dropdown-item" href="{!! url('/pie-moments'); !!}">Pieable Moments</a> -->
									<a class="dropdown-item" href="{!! url('/logout'); !!}">Sign Out</a>
								</div>
							</li>
						</ul>
						@else  
						<div class="h_links_2 pop_sec">
							<ul>
								<li>
									<a href="javascript:;" data-toggle="modal" data-target="#myModal">
										Sign In
									</a>
								</li>
								<li>
									<a href="javascript:;" data-toggle="modal" data-target="#myModal2">
										Sign Up  
									</a>
								</li>
							</ul>
						</div>
						 @endif
						
				</div>
			</div>
			@endif
		</div>
	</div>
</header>
<script src="{{ asset('website/js/jquery.min.js')}}"></script>
<script type="text/javascript">
	$(window).load(function(){
		$.ajaxSetup({
			statusCode:{
				419:function(){
					location.reload();
				}
			}
		});
	});


	

</script>