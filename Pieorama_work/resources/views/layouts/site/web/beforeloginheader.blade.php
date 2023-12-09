	<header>
		<div class="container-fluid">
			<div class="d-flex justify-content-between align-items-center">
				<div class="d-flex align-items-center">
					<div class="hamburger" onclick="myFunction(this)">
						<div class="bar_1"></div>
						<div class="bar_2"></div>
						<div class="bar_3"></div>
					</div>
					<div class="logo">
						<a href="{!! url('/welcome'); !!}">
							<img src="{{ asset('images/Animated_PieOrama_logo_small.gif')}}" alt="Logo">
						</a>
					</div>
					<div class="search_br">
						<input type="text" id="search_text" placeholder="Search"  @if(isset($search_text)) value="{{$search_text}}" @else value="" @endif>
						<div class="h-search-btn">
							<img src="{{ asset('website/images/search.png')}}" alt="image">
						</div>
						<!-- Auto serarch popup -->
						<div class="autosearch-popup">	
							<ul>
								<li>
									<a href="javaScript:;">lorem ipsum</a>
								</li>
								<li>
									<a href="javaScript:;">lorem ipsum</a>
								</li>
								<li>
									<a href="javaScript:;">lorem ipsum</a>
								</li>
								<li>
									<a href="javaScript:;">lorem ipsum</a>
								</li>
							</ul>						
						</div>
						<!-- Auto serarch popup end-->
					</div>
				</div>
				<div class="d-flex align-items-center">
					<div class="h_links transition">
						<ul>
							<li>
								<a href="{!! url('/home'); !!}" class="transition {{ request()->is('home') ? 'active' : '' }}">Home</a>
							</li>
							<li>
								<a href="{!! url('/about-us'); !!}" class="transition">About Pieorama</a>
							</li>
							<li>
								<a href="{!! url('/pie-history'); !!}" class="transition">A Bit of Pie History</a>
							</li>
						</ul>
						<i class="fas fa-times"></i>
					</div>
					<div class="mb_srch_bar">
						<i class="fas fa-search"></i>
					</div>
					<div class="mb_slide">
						<i class="fas fa-ellipsis-v"></i>
					</div>
					<div class="h_links_2">
						<ul>
							<li>
								<a href="javascript:;" data-toggle="modal" data-target="#myModal">
									Login
								</a>
							</li>
							<li>
								<a href="javascript:;" data-toggle="modal" data-target="#myModal2">
									Sign Up
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>
