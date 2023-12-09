<!-- sweet alert cdoe for message alert -->
<link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">

<script src="{{ asset('js/sweetalert.min.js')}}"></script>
@if(session()->has('error'))
<?php $get_error_message =  session()->get('error'); ?>
<script type="text/javascript">
 swal({title: "Failed", text: "<?php echo $get_error_message ; ?>" , type: "warning"});
 </script>
@endif
@if(session()->has('message'))
<?php $get_message =  session()->get('message'); ?>
<script type="text/javascript">
swal({title: "Success", text: "<?php echo $get_message ; ?>" , type: "success"});
</script>
@endif

{!! NoCaptcha::renderJs() !!}

<footer id="landingppage_footer">
	<div class="container footer-navbar">
		<div class="row justify-content-center align-items-center text-center">
			<div class="col-auto">
				<div class="footer_links">
					<ul>
						<li><a href="{!! url('/home'); !!}" class="transition {{ request()->is('/') ? 'active' : '' }}">HOME</a></li>
						<li><a href="{!! url('/privacy-policy'); !!}" class="transition {{ request()->is('privacy-policy') ? 'active' : '' }}">PRIVACY</a></li>
						<li><a href="{!! url('/terms-of-use'); !!}" class="transition {{ request()->is('terms-of-use') ? 'active' : '' }}">TERMS OF USE</a></li>
						<li><a href="{!! url('/contact-us'); !!}" class="transition {{ request()->is('contact-us') ? 'active' : '' }}">CONTACT</a></li>
						<li><a href="{!! url('/get-help'); !!}" class="transition {{ request()->is('get-help') ? 'active' : '' }}">GET HELP</a></li>
					</ul>
				</div>
			</div>
			<div class="col-auto">
				<div class="social_links">
					<ul>
						<li><a href="https://www.facebook.com/pieorama.fun " target="_blank" class="transition" ><i class="fa fa-facebook" style="margin-top: 12px;"></i></a></li>
						<li><a href="https://twitter.com/Pieorama1" target="_blank" class="transition"><i class="fa fa-twitter" style="margin-top: 12px;"></i></a></li>
						<li><a href="https://www.instagram.com/pieorama" target="_blank" class="transition" ><i class="fa fa-instagram" style="margin-top: 12px;"></i></a></li>
						<li class="socialyoutubeicon"><a href="https://www.youtube.com/channel/UCO2MNyg8kvvCzv47efPGXhg" target="_blank" class="transition" ><i class="fa fa-youtube-play" style="margin-top: 12px;"></i>
							<!-- <img src="{{ asset('website/images/youtubeimg.png')}}"> --></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="container copright-text">
		<div class="row">
			<div class="col-sm-12">
				<div class="copyright_innr justify-content-center">
					<p style="text-align:center">Copyright &copy; PieOrama Group LLC, <?php echo date('Y');?>. All Rights Reserved.</p>
					<!--<h6>Powered By - <a href="http://smartzitsolutions.com/" title="" target="_blank">SmartzITSolutions</a></h6>-->
				</div>
			</div>
		</div>
	</div>
</footer>

<!-- sign-up modal -->
<div class="modal login_modal registration_model" id="myModal2">
	<div class="modal-dialog signupmodel">
		<div class="modal-content">
			<button type="button" class="close md_close" data-dismiss="modal">&times;</button>
			<!-- Modal body -->
			<div class="modal-body">
				<div class="row align-items-center">
					<div class="col-12 col-lg-12">
						
						<form action="{{route('site.signup')}}" method="POST" autocomplete="off" id="signupform">
							@csrf
							<div class="login_txt">
								<span class="citation-text">Throwing custard pies should be a fundamental human right.</span>
								<img src="{{ asset('website/images/quote.png')}}" alt="images">
								<span class="citation-author-name">-- Frederick Forsyth</span>
							</div>
							<div class="form_area signUp-formBox" >
								<div class="form-group">
									<input type="text" id="firstname" name="first_name" class="material-input"  placeholder="E-mail Address">
									<label for="firstname" class="form__label">First Name</label>
								</div>

								<div class="form-group">
									<input type="text" id="lastname" name="last_name" class="material-input"  placeholder="Last Name">
									<label for="lastname" class="form__label">Last Name</label>
								</div>
								<!--
								<div class="form-group">
									<input type="text" id="dateofbirth" name="date_of_birth" class="material-input"  placeholder="Date of Birth">
									<label for="dateofbirth" class="form__label">Date of Birth</label>
								</div>
								-->
								<div class="form-group">
									<input type="text" id="emailaddressSignup" name="email" class="material-input"  placeholder="E-mail Address" autocomplete= "off">
									<label for="emailaddressSignup" class="form__label">E-mail Address</label>
								</div>
								<div class="prel">
									<input type="password" id="PasswordSignup" name="password" class="material-input passwordChange"  placeholder="Password">
									<label for="PasswordSignup" class="form__label">Password</label>
									<div class="eyw-icon">
										<img src="{{ asset('website/images/eye-open.png')}}" alt="" class="openEye">
										<img src="{{ asset('website/images/eye-close.png')}}" alt="" class="closeEye">
									</div>
								</div>
								<div class="mt-2">
									<div class="tc-secWrap">
										<div class="tc-secInner d-flex justify-content-between align-items-center newsletterbox">
											<div class="tc-box">
												<input type="checkbox" class="checkInpt tc-checkbox" id="dateofbirthUpdateval" value="1" name="dateofbirthUpdateval" > <a class="frg" style="text-decoration: none;">I am older than 13</a>
											</div>
											<div class="tc-box subs-News-secWrap">
												<input type="checkbox" class="checkInpt tc-checkbox" id="agree" value="1" name="agree" > <a href="{!! url('/terms-of-use'); !!}" target="_blank" class="frg">   I accept the Terms of Use</a>
											</div>
											
										</div>
										
										<div class="News-secWrap subs-News-secWrap" >
												<input type="checkbox" class="checkInpt news-checkbox" id="newsletters" name="newsletters" checked> <a target="_blank" class="frg" style="text-decoration: none;"> Subscribe to newsletter</a>
											</div> 

										<div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}" style="padding-top: 20px;" >
			                            <label class="col-md-4 control-label"></label>
			                            <div class="captcha-signBtn-wrap d-flex justify-content-between align-items-center">
				                            <div class="captcha-wrap">
					                                {!! app('captcha')->display() !!}
					                                @if ($errors->has('g-recaptcha-response'))
					                                    <span class="help-block">
					                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
					                                    </span>
					                                @endif
					                            </div>

					                             <div class="signUp-btnwrap">
												<span class="lgt">Sign Up</span>
												<button type="submit" class="login_btn signupbtn"><i class="fas fa fa-arrow-right" style="color: #fff !important;"></i><div class="disable-signUp-doteBtn" style="display: none;">
												<i></i>
												<i></i>
												<i></i>
												</div></button>
											</div>
					                        </div>

					                       </div>

									</div>
									
										
										
									
									
									
								</div>
								<div class="mt-4 text-center btm_txt">ALREADY HAVE AN ACCOUNT? <a href="javascript:;" data-dismiss="modal"  data-toggle="modal" data-target="#myModal" style="text-decoration: underline;" >LOGIN</a>
								</div>
							</div>
						</form>
						<div class="alert signup-success" style="display: none; margin-bottom: 0px !important;"> </div>
						<div class="alert signup-danger" style="display: none;  margin-bottom: 0px !important;"> </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- login modal -->
<div class="modal login_modal" id="myModal">
	<div class="modal-dialog">
		<div class="modal-content">
			<button type="button" class="close md_close" data-dismiss="modal">&times;</button>
			<!-- Modal body -->
			<div class="modal-body">
				<div class="row align-items-center">
					<div class="col-12 col-lg-12">
						<form action="{{route('site.signin')}}" name="loginuserform" id="loginuserform"  method="post" class="form-group">
							@csrf
							<div class="login_txt">
								<span class="citation-text">You can't imagine what satisfaction can be gotten from throwing a pie into someone's face</span>
								<img src="{{ asset('website/images/quote.png')}}" alt="images">
								<span class="citation-author-name">-- Emma Thompson</span>
							</div>
							<div class="form_area">
								<div class="alert login-success" style="display: none; margin-bottom: 30px;"> </div>
								<div class="alert login-danger" style="display: none;  margin-bottom: 30px;"> </div>
								<div class="form-group">
									<input type="text" id="emailaddressLogin" name="email" class="material-input"  placeholder="E-mail Address">
									<label for="emailaddressLogin" class="form__label">E-mail Address</label>
								</div>
								<div class="prel">
									<input type="password" id="PasswordLogin" name="password" class="material-input passwordChange"  placeholder="Password">
									<label for="PasswordLogin" class="form__label">Password</label>
									<div class="eyw-icon">
										<img src="{{ asset('website/images/eye-open.png')}}" alt="" class="openEye">
										<img src="{{ asset('website/images/eye-close.png')}}" alt="" class="closeEye">
									</div>
								</div>
								<div class="mt-2 d-flex justify-content-between align-items-center">
									<div>
										<a href="javascript:;" class="frg" data-dismiss="modal"  data-toggle="modal" data-target="#myModal3">Forgot Password?</a>
									</div>
									<div>
										<span class="lgt">Login</span>
										<button type="submit" class="login_btn loginbtn"><i class="fas fa fa-arrow-right" style="color: #fff !important;"></i>
										<div class="disable-login-doteBtn" style="display: none;">
											<i></i>
											<i></i>
											<i></i>
										</div>
									</button>
									</div>
								</div>
								<!-- <div class="mt-4 text-center">
									<span class="or">Or Login Using</span>
								</div> -->
								<!-- <div class="mt-4">
									<ul class="social_login">
										<li><a href="{{ route('site.facebook') }}"><i class="fa fa-facebook"></i></a></li>
										<li><a href="{{ route('site.twitter') }}"><i class="fa fa-twitter"></i></a></li>
										<li><a href="{{ route('site.instagram') }}"><i class="fa fa-instagram"></i></a></li>
										<li><a href="{{ route('site.linkedin') }}"><i class="fa fa-linkedin"></i></a></li>
										<li><a href="{{ route('site.google') }}"><i class="fa fa-google"></i></a></li>
									</ul>
								</div> -->
								<div class="mt-4 text-center btm_txt">DON'T HAVE AN ACCOUNT? <a href="javascript:;" data-dismiss="modal"  data-toggle="modal" data-target="#myModal2" style="text-decoration: underline;" >SIGN UP</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>





@if(session()->has('setnewpasswordwebsite'))
<?php $get_urleoncodeId =  session()->get('setnewpasswordwebsite'); ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#myModalsetnewpassword').modal('show');
	});
</script>
<!-- Set new password modal -->
<div class="modal login_modal" id="myModalsetnewpassword">
	<div class="modal-dialog">
		<div class="modal-content">
			<button type="button" class="close md_close" data-dismiss="modal">&times;</button>
			<!-- Modal body -->
			<div class="modal-body">
				<div class="row align-items-center">
					<div class="col-12 col-lg-12">
							<form action="{{route('site.setnewpassword')}}" name="setnewpassword" id="setnewpassword"  method="post" class="form-group">
							@csrf
							<input type="hidden" name="urlcode" value="<?php echo $get_urleoncodeId ; ?>">
							<div class="login_txt">
								<span class="citation-text">You can't imagine what satisfaction can be gotten from throwing a pie into someone's face</span>
								<img src="{{ asset('website/images/quote.png')}}" alt="images">
								<span class="citation-author-name">-- Emma Thompson</span>
							</div>
							<div class="form_area">
								<div class="alert login-success" style="display: none; margin-bottom: 30px;"> </div>
								<div class="alert login-danger pass-danger" style="display: none;  margin-bottom: 30px;"> </div>
							<div class="form-group">
                                <input type="password" id="pass" name="password" class="material-input passwordChange"  placeholder="E-mail Address" title="The password must be at least 8 characters long. It cannot consist of only lowercase characters.">
                                <label for="pass" class="form__label">Set New Password</label>
                                <div class="eyw-icon">
                                    <img src="{{ asset('website/images/eye-open.png')}}" alt="" class="openEye">
                                    <img src="{{ asset('website/images/eye-close.png')}}" alt="" class="closeEye">
                                </div>
                            </div>
                            <div class="prel">
                                <input type="password" id="Password" name="cpassword" class="material-input passwordconfirm"  placeholder="Password">
                                <label for="Password" class="form__label">Confirm Password</label>
                                <div class="eyw-iconconfirm">
                                    <img src="{{ asset('website/images/eye-open.png')}}" alt="" class="openEyeconfirm">
                                    <img src="{{ asset('website/images/eye-close.png')}}" alt="" class="closeEyeconfirm">
                                </div>
                            </div>

							<div class="mt-2 d-flex justify-content-between align-items-center">
                            	<div>
                            		<a href="javascript:;" class="frg" data-dismiss="modal"  data-toggle="modal" data-target=""></a>
                            	</div>
                            	<div>
                            		<span class="lgt">Submit</span>
                            		<button type="submit" class="login_btn pass-btn">
                            			<i class="fas fa fa-arrow-right"></i><div class="disable-resetPass-doteBtn" style="display: none;">
												<i></i>
												<i></i>
												<i></i>
												</div>
                            		</button>
                            	</div>
                            </div>
                           
							</div>
						</form>
						<div class="alert login_btn-success" style="display: none; margin-bottom: 0px !important; color: white; background: #4e927b;" > </div>
						<div class="alert login_btn-danger" style="display: none;  margin-bottom: 0px !important; color: white; background: #e76565;"> </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif




<!-- forgot password -->
<div class="modal login_modal" id="myModal3">
	<div class="modal-dialog">
		<div class="modal-content">
			<button type="button" class="close md_close" data-dismiss="modal">&times;</button>
			<!-- Modal body -->
			<div class="modal-body">
				<div class="row align-items-center">
					<div class="col-12 col-lg-12">
						<form id="fgotemailform" name="fgotemailform" method="post"  action="{{ route('site.forgotpassword') }}">
							@csrf
							<div class="login_txt">
								<span class="citation-text">God’s always got a custard pie up his sleeve.</span>
								<img src="{{ asset('website/images/quote.png')}}" alt="images">
								<span class="citation-author-name">-- Margaret Forster</span>
							</div>
							<div class="form_area">
								<div class="alert forgot-success" style="display: none;  margin-bottom: 30px;"> </div>
								<div class="alert forgot-danger" style="display: none;  margin-bottom: 30px;"> </div> 
								<div class="alert forgot-danger1" style="display: none;  margin-bottom: 30px;"> </div>
								<div class="form-group">
									<input type="text" id="emailaddressForgot" name="email"  value="{{ old('email') }}" class="material-input"  placeholder="E-mail Address">
									<label for="emailaddressForgot" class="form__label">E-mail Address</label>
								</div>
								<div class="mt-2 d-flex flex-row-reverse">
									<div>
										<span class="lgt">Reset Password</span>
										<button type="submit" class="login_btn forgetbtn"><i class="fas fa fa-arrow-right"></i><div class="disable-forgotPass-doteBtn" style="display: none;">
												<i></i>
												<i></i>
												<i></i>
												</div></button>
									</div>
								</div>
								<!-- <div class="mt-4 text-center">
									<span class="or">Or Login Using</span>
								</div>
								<div class="mt-4">
									<ul class="social_login">
										<li><a href="javascript:;"><i class="fa fa-facebook"></i></a></li>
										<li><a href="javascript:;"><i class="fa fa-twitter"></i></a></li>
										<li><a href="javascript:;"><i class="fa fa-instagram"></i></a></li>
										<li><a href="javascript:;"><i class="fa fa-linkedin"></i></a></li>
										<li><a href="javascript:;"><i class="fa fa-google"></i></a></li>
									</ul>
								</div> -->
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="{{ asset('website/js/jquery.min.js')}}"></script>
<script src="{{ asset('website/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{ asset('website/js/Popper.min.js')}}"></script>
<script src="{{ asset('website/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('website/js/slick.min.js')}}"></script>
<script src="{{ asset('website/js/function.js')}}"></script>
<script src="{{ asset('website/js/jquery-ui.js')}}"></script>
<script src="{{ asset('js/share.js') }}"></script>
<!-- Jquery Validate -->
<script src="{{ asset('js/admin/js/jquery.validate.js')}}"></script>
<script src="{{ asset('js/admin/js/additional-methods.min.js')}}"></script>
<!--Jquery for the loader on every page  -->
<script src="{{ asset('website/js/modernizr.js')}}"></script>
<script type="text/javascript">
	// Wait for window load
	$(window).load(function() {
		// Animate loader off screen
		$(".se-pre-con").fadeOut("slow");
		

	 	setTimeout(function() {
			$('#video2')[0].load();
		   $("#video2")[0].play();
		   // 
		}, 4000);
		/*var seg = '{{Request::segment(1)}}';
		if(seg == 'watch'){
			$("#video1")[0].play();
		}*/
	});
	///// Header Sticky /////
  window.onscroll = function () { myFunction() };
  var header = document.getElementById("header");
  var sticky = header.offsetTop;
  function myFunction() {
    if (window.pageYOffset > sticky) {
      header.classList.add("sticky");
    } else {
      header.classList.remove("sticky");
    }
  }
</script>
<script type="text/javascript">
	// Friend search on my friend list
	$(document).ready(function() {
		$(".wholesrchmain").keypress(function(e) {
			var str = $('.wholesrchmain').val();
			string = str;
			var code = (e.keyCode ? e.keyCode : e.which);
			if (code == 13) {
				var base_url = "<?php url('/') ?>";
				window.location.replace(base_url + "/my-friend-list/" + string);
			}
		});
	});
	//Forgot password code
	$("#fgotemailform").validate({
		rules: {
			email: {
				required: true,
				email: true,
			}
		},
		submitHandler: function(form) {
			$.ajax({
				url: "{{ url('/forgotpassword') }}",
				data: $(form).serialize(),
				dataType: 'json',
				type: 'post',
				beforeSend: function() {
					/*$(".forgetbtn").html("<i class='fas fa fa-ellipsis-h'></i>");
					$(".forgetbtn").attr("disabled", true);*/

					$(".forgetbtn .fas").hide();
					$('.disable-forgotPass-doteBtn').show();
					
					$(".forgetbtn").attr("disabled", true);


				},
				success: function(response) {

					/*$(".forgetbtn").html("<i class='fas fa fa-arrow-right'></i>");
					if (response['status']) {
						$('.forgot-success').html(response['message']).show();
						setTimeout(function() {
							$(".forgot-success").fadeOut();
							window.location.reload();
						}, 30000);
					} else if (response['status'] == false) {
						$(".forgetbtn").attr("disabled", false);*/
						
						/*if (response['emailverification']) {
							$('.login-danger').html(response.message).show();
							setTimeout(function() {
								$(".login-danger").fadeOut();
							}, 30000);
						}*/


						if (response['status']) {
							$(".forgot-danger1").hide();
						$('.forgot-success').html(response['message']).show();
						setTimeout(function() {
							$(".forgot-success").fadeOut();
							$('.disable-forgotPass-doteBtn').show();
							$('#myModal3').modal('hide');
							$(".forgetbtn").attr("disabled", true);
							// $('#editProfile').modal('hide');
							window.location.reload();
						}, 10000);
						} else if (response['status'] == false) {

							$(".forgetbtn .fas").show();
							$('.disable-forgotPass-doteBtn').hide();
							$(".forgetbtn").attr("disabled", false);


						var errMsg1 = '';
						if (response['errors_res']) {
							errMsg1 += response['errors_res'] + '<br>';
							$('.forgot-danger1').html(errMsg1).show();
							setTimeout(function() {
								$(".forgot-danger1").fadeOut();
							}, 30000);
						}
						var errMsg = '';
						if (response['errors']['email']) {
							errMsg += response['errors']['email'] + '<br>';
							$('.forgot-danger').html(errMsg).show();
							setTimeout(function() {
								$(".forgot-danger").fadeOut();
							}, 30000);
						} else if (response['message']['err']) {
							$('.forgot-danger').html(response['message']['err']).show();
							setTimeout(function() {
								$(".forgot-danger").fadeOut();
							}, 30000);
						}
					} else {
						$(".forgetbtn").attr("disabled", false);
						$('.forgot-danger').html('Something went wrong.').show();
						setTimeout(function() {
							$(".forgot-danger").fadeOut();
						}, 30000);
					}
				}
			});
		}
	});





	//Login code 
	$("#loginuserform").validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
			}
		},
		submitHandler: function(form) {
			$.ajax({
				url: "{{ url('/signin') }}",
				data: $(form).serialize(),
				dataType: 'json',
				type: 'post',
				beforeSend: function() {
					
					$(".loginbtn .fas").hide();
					$('.disable-login-doteBtn').show();
					$(".loginbtn").attr("disabled", true);
				},
				success: function(response) {
					$(".loginbtn").html("<i class='fas fa fa-arrow-right'></i>");
					$(".loginbtn").attr("disabled", false);

					if (response['status']) {
						if (response['user_role'] == 1) {
							/* $('.login-success').html("You have login successfully,").show();
							 setTimeout(function () {
									 $(".login-success").fadeOut();
							 }, 3000);*/
							window.location.reload();
							// window.location = 'admin/dashboard';
						} else if (response['user_role'] == 2) {
							/* $('.login-success').html("You have login successfully,").show();
							 setTimeout(function () {
									 $(".login-success").fadeOut();
							 }, 3000);*/
							window.location.reload();
							// window.location = '/home';
						} else {
							$('.login-danger').html("Something went wrong.").show();
							setTimeout(function() {
								$(".login-danger").fadeOut();
							}, 30000);
						}

					} else if (response['status'] == false) {
						if (response['emailverification']) {
							$('.login-danger').html(response.message).show();
							setTimeout(function() {
								$(".login-danger").fadeOut();
							}, 30000);
						} else {
							var err = '';
							if (response['message']['email']) {
								err += response['message']['email'] + '<br>';
							}
							if (response['message']['password']) {
								err += response['message']['password'] + '<br>';
							}
							if (response['message']['invalid_detail']) {
								err += response['message']['invalid_detail'] + '<br>';
							}
							if (response['message']['err']) {
								err += response['message']['err'] + '<br>';
							}

							$('.login-danger').html(err).show();
							setTimeout(function() {
								$(".login-danger").fadeOut();
							}, 30000);
						}

					} else {
						$('.login-danger').html('Something went wrong.').show();
						setTimeout(function() {
							$(".login-danger").fadeOut();
						}, 30000);
					}
				}
			});
		}
	});

	// Signup code 
	$("#signupform").validate({
		rules: {
			first_name: {
				required: true,
				maxlength: 255
			},
			last_name: {
				required: true,
				maxlength: 255
			},
			email: { 
				required: true,
				email: true,
				maxlength: 255
			},
			password: {
				required: true,
				maxlength: 55
			},
			agree: {
				required: true,
				maxlength: 255
			},
			
			dateofbirthUpdateval: {
				required: true,
				maxlength: 255
			},
			hiddenRecaptcha: {
                required: function () {
                    if (grecaptcha.getResponse() == '') {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
		},
		messages: { 
			agree: "This box must be checked." 
		},
		
		messages: { 
			dateofbirthUpdateval: "This box must be checked." 
		},

	 submitHandler: function(form) {
		 if (grecaptcha.getResponse() == ''){
       	         // alert("Captcha can't be blank");
       	         $('.signup-danger').html('Captcha can not be blank').show();
					setTimeout(function() {
						$(".signup-danger").fadeOut();
				}, 30000);
                  
         } else {	
			$.ajax({
				url: "{{ url('/signup') }}",
				data: $(form).serialize(),
				dataType: 'json',
				type: 'post',
				beforeSend: function() {
					//$(".signupbtn").html("<i class='fas fa fa-ellipsis-h'></i>");
					$(".signupbtn .fas").hide();
					$('.disable-signUp-doteBtn').show();
					
					$(".signupbtn").attr("disabled", true);


				},
				success: function(response) {
					/*setTimeout(function(){
					  $(".signupbtn").html("<i class='fas fa fa-arrow-right'></i>");
					$(".signupbtn").attr("disabled", false);
					}, 10000);
					*/
					

					if (response['status']) {
						$(".signup-danger").hide();
						$('.signup-success').html(response['message']).show();

						setTimeout(function() {
							$(".signup-success").fadeOut();

							$('.disable-signUp-doteBtn').show();
							$('#myModal2').modal('hide');
							$(".signupbtn").attr("disabled", true);

							// $('#editProfile').modal('hide');
							window.location.reload();
						}, 10000);
					} else if (response['status'] == false) {
						$(".signupbtn .fas").show();
						$('.disable-signUp-doteBtn').hide();
						$(".signupbtn").attr("disabled", false);


						var errMsg = '';
						if (response['message']['first_name']) {
							errMsg += response['message']['first_name'] + '<br>';
						}
						if (response['message']['email']) {
							errMsg += response['message']['email'] + '<br>';
						}
						if (response['message']['name']) {
							errMsg += response['message']['name'] + '<br>';
						}
						if (response['message']['password']) {
							errMsg += response['message']['password'] + '<br>';
						}
						if (response['message']['emailExist']) {
							errMsg += response['message']['emailExist'] + '<br>';
						}
						if (response['message']['passmessage']) {
							errMsg += response['message']['passmessage'] + '<br>';
						}
						if (errMsg) {
							$('.signup-danger').html(errMsg).show();
							setTimeout(function() {
								$(".signup-danger").fadeOut();
							}, 30000);
						} else {
							$('.signup-danger').html('Something went  wrong. Please try again later.').show();
							setTimeout(function() {
								$(".signup-danger").fadeOut();
							}, 30000);
						}

					} else {
						$('.signup-danger').html('Something went  wrong.').show();
						setTimeout(function() {
							$(".signup-danger").fadeOut();
						}, 30000);
					}
				}
			});
		   }
		}
	});
	// cobtact us form code 
	$("#contactusform").validate({
		rules: {
			name: {
				required: true,
				maxlength: 255
			},
			/*phone: {
				required: true,
				maxlength: 15
			},*/
			
			email: {
				required: true,
				email: true,
				maxlength: 255
			},
			message: {
				required: true,
				maxlength: 2255
			},
			hiddenRecaptcha: {
                required: function () {
                    if (grecaptcha.getResponse() == '') {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
		},
		submitHandler: function(form) {
			
	       if (grecaptcha.getResponse() == ''){
	       	          alert("Captcha can't be blank");
                      // if error I post a message in a div
                      $( '#reCaptchaError' ).html( '<p>Please verify youare human</p>' );

           } else {	

			$.ajax({
				url: "{{ url('/contact-us') }}",
				data: $(form).serialize(),
				dataType: 'json',
				type: 'post',
				beforeSend: function() {
					$(".contctpbtn .fas").hide();
					$('.disable-contact-doteBtn').show();
					$(".contctpbtn").attr("disabled", true);
				},
				success: function(response) {
					
					$(".contctpbtn").html("<i class='fas fa fa-arrow-right'></i>");
					$(".contctpbtn").attr("disabled", false);

					if (response['status']) {						
						setTimeout(function() {
						swal({
							title: "Thank you!",
							text: response['message'],
							
							cancelButtonColor: "#DD6B55",
							imageUrl: '{{ asset("website/images/Rocket-Pie-Black-Matte.gif")}}',
							//type: "success"
							
						},
						function() {
									location.reload();
								}
							);
						}, 100);



					} else if (response['status'] == false) {
						var errMsg = '';
						
						if (response['message']['email']) {
							errMsg += response['message']['email'] + '<br>';
						}
						if (response['message']['name']) {
							errMsg += response['message']['name'] + '<br>';
						}
						/*if (response['message']['phone']) {
							errMsg += response['message']['phone'] + '<br>';
						}*/
						if (response['message']['emailExist']) {
							errMsg += response['message']['emailExist'] + '<br>';
						}
						if (errMsg) {
							$('.signup-danger').html(errMsg).show();
							setTimeout(function() {
								$(".signup-danger").fadeOut();
							}, 30000);
						} else {
							$('.signup-danger').html('Something went wrong. Please try again later.').show();
							setTimeout(function() {
								$(".signup-danger").fadeOut();
							}, 30000);
						}

					} else {
						$('.signup-danger').html('Something went wrong.').show();
						setTimeout(function() {
							$(".signup-danger").fadeOut();
						}, 30000);
					}


				}
			});

          }
		}
	});
	// update profile code  
	$("#updateProfileform").validate({ 

		rules: {
			first_name: {
				required: true,
				maxlength: 255
			},
			last_name: {
				required: true,
				maxlength: 255
			},
			email: {
				required: true,
				email: true,
				maxlength: 255
			},
			
			/*dateofbirthUpdateval: {
				required: true,
				maxlength: 255
			},*/

		},
		/*messages: { 
			dateofbirthUpdateval: "This box must be checked." 
		},*/

		submitHandler: function(form) {
			var formData = new FormData(form);
			$.ajax({
				url: "{{ url('/update-profile') }}",
				type: 'POST',
				data: formData,
				dataType: 'json',
				processData: false,
				contentType: false, 
				/*
				data: $(form).serialize(),
				dataType: 'json',
				type: 'post',*/
				beforeSend: function() {
					/*$(".updatePrbtn").html("<i class='fas fa fa-ellipsis-h'></i>");*/
					$(".updatePrbtn .fas").hide();
					$('.disable-updateprof-doteBtn').show();
					$(".updatePrbtn").attr("disabled", true);
				},
				success: function(response) {
					

					if (response['status']) {
						$('.signup-success').html(response['message']).show();
						setTimeout(function() {
							$(".signup-success").fadeOut();
							$('.disable-updateprof-doteBtn ').show();
							$(".updatePrbtn").attr("disabled", true);
							// $('#editProfile').modal('hide');
							window.location.reload();
						}, 2000);
					} else if (response['status'] == false) {
						$(".updatePrbtn .fas").show();
						$('.disable-updateprof-doteBtn ').hide();
						$(".updatePrbtn").attr("disabled", false);
						//console.log(response);
						var errMsg = '';
						if (response['message']['first_name']) {
							errMsg += response['message']['first_name'] + '<br>';
						}
						if (response['message']['last_name']) {
							errMsg += response['message']['last_name'] + '<br>';
						}
						if (response['message']['email']) {
							errMsg += response['message']['email'] + '<br>';
						}
						if (response['message']['emailExist']) {
							errMsg += response['message']['emailExist'] + '<br>';
						}
						if (response['image_error']) {
							
							errMsg += response['image_error'] + '<br>';
							
						}
						if (errMsg) {
							$('.signup-danger').html(errMsg).show();
							setTimeout(function() {
								$(".signup-danger").fadeOut();
							}, 3000);
						} else {
							$('.signup-danger').html('Something went wrong. Please try again later.').show();
							setTimeout(function() {
								$(".signup-danger").fadeOut();
							}, 3000);
						}

					} else { 
						$('.signup-danger').html('Something went wrong.').show();
						setTimeout(function() {
							$(".signup-danger").fadeOut();
						}, 3000);
					}
				}
			});
		}
	});
	// Signup code 
	$("#deletepie").validate({
		rules: {
			encoded_pieogramid: {
				required: true
			},
		},
		submitHandler: function(form) {
			swal({
					title: "Confirm!",
					text: "Are you sure? you want to delete this pieogram?",
					type: "warning",
					cancelButtonColor: "#DD6B55",
					showCancelButton: true,
					cancelButtonText: "Cancel",
					confirmButtonText: "Confirm"
				},
				function(isConfirm) {
					if (isConfirm) {
						$.ajax({
							url: "{{ url('/delete-pieograms') }}",
							data: $(form).serialize(),
							dataType: 'json',
							type: 'post',
							beforeSend: function() {
								$(".signupbtn").html("<i class='fas fa fa-ellipsis-h'></i>");
								$(".signupbtn").attr("disabled", true);
							},
							success: function(response) {
								$(".signupbtn").html("<i class='fas fa fa-arrow-right'></i>");
								$(".signupbtn").attr("disabled", false);
								if (response['status']) {
									setTimeout(function() {
										swal({
												title: "Deleted!",
												text: response['message'],
												type: "success"
											},
											function() {
												window.location.href = "{{ url('/my-profile') }}";
											}
										);
									}, 100);
								} else if (response['status'] == false) {
									setTimeout(function() {
										swal({
												title: "Error!",
												text: response['errors_res'],
												type: "warning"
											},
											function() {
												location.reload();
											}
										);
									}, 100);

								} else {
									setTimeout(function() {
										swal({
												title: "Error!",
												text: response['errors_res'],
												type: "warning"
											},
											function() {
												location.reload();
											}
										);
									}, 100);

								}
							}
						});
					}
				});
		}
	});
	// Reset New Password Code
	$("#setnewpassword").validate({
		rules: {
			password: {
				required: true,
				minlength: 8,
			},
			cpassword: {
				required: true,
				equalTo: '#pass',
			},
		},
		messages: {
			confirmpassword: "Confirm password does not match."
		},
		submitHandler: function(form) {
			
			$.ajax({
				url: "{{ url('/setnewpassword') }}",
				data: $(form).serialize(),
				dataType: 'json',
				type: 'post',
				beforeSend: function() {
					
					$(".pass-btn .fas").hide();
					$('.disable-resetPass-doteBtn').show();
					
					$(".pass-btn").attr("disabled", true);


				},
				success: function(response) {
					console.log(response);

					if (response['status'] != false) {
						$(".login_btn-danger").hide();
						$('.login_btn-success').html('Password has been reset successfully. Please login now. ').show();

						setTimeout(function() {
							$(".login_btn-success").fadeOut();

							$('.disable-resetPass-doteBtn').show();
							$('#myModalsetnewpassword').modal('hide');
							$(".pass-btn").attr("disabled", true);

							// $('#editProfile').modal('hide');
							window.location.reload();
						}, 10000);
					} else if (response['status'] == false) {
						$(".pass-btn .fas").show();
						$('.disable-resetPass-doteBtn').hide();
						$(".pass-btn").attr("disabled", false);


						var errMsg = '';
						
						if (response['message']['passmessage']) {
							errMsg += response['message']['passmessage'] + '<br>';
						}
						if (errMsg) {
							$('.login_btn-danger').html(errMsg).show();
							setTimeout(function() {
								$(".login_btn-danger").fadeOut();
							}, 30000);
						} else {
							$('.login_btn-danger').html('Something went  wrong. Please try again later.').show();
							setTimeout(function() {
								$(".login_btn-danger").fadeOut();
							}, 30000);
						}

					} else {
						$('.login_btn-danger').html('Something went  wrong.').show();
						setTimeout(function() {
							$(".login_btn-danger").fadeOut();
						}, 30000);
					}
				}
			});
		   }
		
			/*if (pass.match(/[a-z]/)) {
				    alert('lower case letter');
				    return false;
			}
		if ((pass.match(/[a-z]/)) && (!pass.match(/[a-z]/)) && (pass.match(/[0-9]/)) && (pass.match(/[0-9]/)) && pass.match(/^[^a-zA-Z0-9]+$/)) {
		 		alert('lowercase');
       	         return false;
       	         $('.pass-danger').html('It cannot consist of only lowercase characters.').show();
       	         return false;
					setTimeout(function() {
						$(".pass-danger").fadeOut();
				}, 30000);
                  
         } else {
         	form.submit();
		   }
		}*/
	
		/*submitHandler: function(form) {
			form.submit();


		}*/
	});
	
	
	// Search functionality
	
	$("#search").validate({
		rules: {
			search_text: {
				required: false 
			},
		}, 
		messages: {
			confirmpassword: "This field is required"
		},
		submitHandler: function(form) {
			  if ($("#search_text").val() == "") {
    			
    			return false;
		        $('#csrf-token').value('{{Session::token()}}');
		        
		    }else{
		    	
		    	$('#csrf-token').value('{{Session::token()}}');
		    	return true;
		    	form.submit();
		    }
			

		}
	});
	
	
	
</script>
@if(session()->has('usersignupmodal'))
<?php $usersignupmodal_msg =  session()->get('usersignupmodal'); ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#myModal2').modal('show');
	});
</script>
@endif
<script>
	$(function() {
		$("#dateofbirth").datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "-90:-1",
			reverseYearRange: false,
			maxDate: '-13Y',
		});
	});
	$(function() {
		$("#dateofbirthUpdate").datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: "-90:-1",
			reverseYearRange: false,
			maxDate: '-13Y',
		});
	});
	$(function() {
		$("#dob").datepicker({
			changeMonth: true,
			changeYear: true,
			maxDate: '-13Y',
		});
	});
	$(".editprofile_modal").scroll(function() {
		$('#dob').datepicker("hide");
		$('#dob').blur();
	});
	$(document).on('click', '.searchableon', function(e) {
		var formData = {
			'_token': "{{ csrf_token() }}",
			'pieogram_id': $("#video_id").val(),
			'status': '0'
		};
		console.log(formData);
		$.ajax({
			url: "{{ url('/change-search-status') }}",
			data: formData,
			dataType: 'json',
			type: 'post',
			beforeSend: function() {
				/*  $(".signupbtn").html("<i class='fas fa fa-ellipsis-h'></i>");
				  $(".signupbtn").attr("disabled", true);*/
			},
			success: function(response) {
				/*  $(".signupbtn").html("<i class='fas fa fa-arrow-right'></i>");
				  $(".signupbtn").attr("disabled", false);   */
				if (response['status']) {
					setTimeout(function() {
						swal({
								title: "Success!",
								text: response['message'],
								type: "success"
							},
							function() {
								location.reload();
							}
						);
					}, 100);
				} else if (response['status'] == false) {
					var errMsg = '';
					if (response['message']['status']) {
						errMsg += response['message']['status'] + '';
					}
					if (response['message']['pieogram_id']) {
						errMsg += response['message']['pieogram_id'] + '';
					}
					if (errMsg) {
						setTimeout(function() {
							swal({
									title: "Error!",
									text: errMsg,
									type: "warning"
								},
								function() {
									location.reload();
								}
							);
						}, 100);
					} else {
						if (response['message']['error']) {
							setTimeout(function() {
								swal({
										title: "Error!",
										text: response['message']['error'],
										type: "warning"
									},
									function() {
										location.reload();
									}
								);
							}, 100);
						} else {
							setTimeout(function() {
								swal({
										title: "Error!",
										text: "Something went  wrong. Please try again later.",
										type: "warning"
									},
									function() {
										location.reload();
									}
								);
							}, 100);
						}
					}
				} else {
					setTimeout(function() {
						swal({
								title: "Error!",
								text: "Error",
								type: "warning"
							},
							function() {
								location.reload();
							}
						);
					}, 100);
				}
			}
		});
	});
	$(document).on('click', '.searchableoff', function(e) {
		var formData = {
			'_token': "{{ csrf_token() }}",
			'pieogram_id': $("#video_id").val(),
			'status': '1'
		};
		console.log(formData);
		$.ajax({
			url: "{{ url('/change-search-status') }}",
			data: formData,
			dataType: 'json',
			type: 'post',
			beforeSend: function() {
				/*  $(".signupbtn").html("<i class='fas fa fa-ellipsis-h'></i>");
				  $(".signupbtn").attr("disabled", true);*/
			},
			success: function(response) {
				/*  $(".signupbtn").html("<i class='fas fa fa-arrow-right'></i>");
				  $(".signupbtn").attr("disabled", false);   */
				if (response['status']) {
					setTimeout(function() {
						swal({
								title: "Success!",
								text: response['message'],
								type: "success"
							},
							function() {
								location.reload();
							}
						);
					}, 100);
				} else if (response['status'] == false) {
					var errMsg = '';
					if (response['message']['status']) {
						errMsg += response['message']['status'] + '';
					}
					if (response['message']['pieogram_id']) {
						errMsg += response['message']['pieogram_id'] + '';
					}
					if (errMsg) {
						setTimeout(function() {
							swal({
									title: "Error!",
									text: errMsg,
									type: "warning"
								},
								function() {
									location.reload();
								}
							);
						}, 100);
					} else {
						if (response['message']['error']) {
							setTimeout(function() {
								swal({
										title: "Error!",
										text: response['message']['error'],
										type: "warning"
									},
									function() {
										location.reload();
									}
								);
							}, 100);
						} else {
							setTimeout(function() {
								swal({
										title: "Error!",
										text: "Something went  wrong. Please try again later.",
										type: "warning"
									},
									function() {
										location.reload();
									}
								);
							}, 100);
						}
					}

				} else {
					setTimeout(function() {
						swal({
								title: "Error!",
								text: "Error",
								type: "warning"
							},
							function() {
								location.reload();
							}
						);
					}, 100);

				}
			}
		});
	});
	$(document).on('click', '.publicavailableon', function(e) {
		var formData = {
			'_token': "{{ csrf_token() }}",
			'pieogram_id': $("#video_id").val(),
			'status': '0'
		};
		console.log(formData);
		$.ajax({
			url: "{{ url('/change-public-available') }}",
			data: formData,
			dataType: 'json',
			type: 'post',
			beforeSend: function() {
				/*  $(".signupbtn").html("<i class='fas fa fa-ellipsis-h'></i>");
				  $(".signupbtn").attr("disabled", true);*/
			},
			success: function(response) {
				/*  $(".signupbtn").html("<i class='fas fa fa-arrow-right'></i>");
				  $(".signupbtn").attr("disabled", false);   */
				if (response['status']) {
					setTimeout(function() {
						swal({
								title: "Success!",
								text: response['message'],
								type: "success"
							},
							function() {
								location.reload();
							}
						);
					}, 100);
				} else if (response['status'] == false) {
					var errMsg = '';
					if (response['message']['status']) {
						errMsg += response['message']['status'] + '';
					}
					if (response['message']['pieogram_id']) {
						errMsg += response['message']['pieogram_id'] + '';
					}
					if (errMsg) {
						setTimeout(function() {
							swal({
									title: "Error!",
									text: errMsg,
									type: "warning"
								},
								function() {
									location.reload();
								}
							);
						}, 100);
					} else {
						if (response['message']['error']) {
							setTimeout(function() {
								swal({
										title: "Error!",
										text: response['message']['error'],
										type: "warning"
									},
									function() {
										location.reload();
									}
								);
							}, 100);
						} else {
							setTimeout(function() {
								swal({
										title: "Error!",
										text: "Something went  wrong. Please try again later.",
										type: "warning"
									},
									function() {
										location.reload();
									}
								);
							}, 100);
						}
					}
				} else {
					setTimeout(function() {
						swal({
								title: "Error!",
								text: "Error",
								type: "warning"
							},
							function() {
								location.reload();
							}
						);
					}, 100);
				}
			}
		});
	});
	$(document).on('click', '.publicavailableoff', function(e) {
		var formData = {
			'_token': "{{ csrf_token() }}",
			'pieogram_id': $("#video_id").val(),
			'status': '1'
		};
		console.log(formData);
		$.ajax({
			url: "{{ url('/change-public-available') }}",
			data: formData,
			dataType: 'json',
			type: 'post',
			beforeSend: function() {
				/*  $(".signupbtn").html("<i class='fas fa fa-ellipsis-h'></i>");
				  $(".signupbtn").attr("disabled", true);*/
			},
			success: function(response) {
				/*  $(".signupbtn").html("<i class='fas fa fa-arrow-right'></i>");
				  $(".signupbtn").attr("disabled", false);   */
				if (response['status']) {
					setTimeout(function() {
						swal({
								title: "Success!",
								text: response['message'],
								type: "success"
							},
							function() {
								location.reload();
							}
						);
					}, 100);
				} else if (response['status'] == false) {
					var errMsg = '';
					if (response['message']['status']) {
						errMsg += response['message']['status'] + '';
					}
					if (response['message']['pieogram_id']) {
						errMsg += response['message']['pieogram_id'] + '';
					}
					if (errMsg) {
						setTimeout(function() {
							swal({
									title: "Error!",
									text: errMsg,
									type: "warning"
								},
								function() {
									location.reload();
								}
							);
						}, 100);
					} else {
						if (response['message']['error']) {
							setTimeout(function() {
								swal({
										title: "Error!",
										text: response['message']['error'],
										type: "warning"
									},
									function() {
										location.reload();
									}
								);
							}, 100);
						} else {
							setTimeout(function() {
								swal({
										title: "Error!",
										text: "Something went  wrong. Please try again later.",
										type: "warning"
									},
									function() {
										location.reload();
									}
								);
							}, 100);
						}
					}
				} else {
					setTimeout(function() {
						swal({
								title: "Error!",
								text: "Error",
								type: "warning"
							},
							function() {
								location.reload();
							}
						);
					}, 100);
				}
			}
		});
	});
	$(document).on('click', '.clickonviewVideo', function(e) {
		var formData = {
			'_token': "{{ csrf_token() }}",
			'pieogram_id': $("#video_id").val()
		};
		console.log(formData);
		$.ajax({
			url: "{{ url('/watched-pieogram') }}",
			data: formData,
			dataType: 'json',
			type: 'post',
			beforeSend: function() {},
			success: function(response) {
				console.log(response);
			}
		});
	});
</script>
@if(session()->has('messageresetPassword'))
<script type="text/javascript">
	$(document).ready(function() {
		$('#myModal').modal('show');
	});
</script>
@endif
@if(session()->has('messageEmailVerification'))
<?php $get_message =  session()->get('messageEmailVerification'); ?>
<script type="text/javascript">
	swal({
			title: "You are all set!",
			text: "<?php echo $get_message ; ?>",
			//type: "success",
			cancelButtonColor: "#DD6B55",
			showCancelButton: true,
			imageUrl: '{{ asset("website/images/Rocket-Pie-Black-Matte.gif")}}',
			//cancelButtonText: "Login Later",
			confirmButtonText: "Log in now"
		},
		
		function(isConfirm) {
			if (isConfirm) {
				$('#myModal').modal('show');
			}
		});
</script>
@endif  

 



@if(session()->has('resendverificationMail'))
<?php $get_message =  session()->get('resendverificationMail'); 

?>
<script type="text/javascript">
	
	swal({
			title: "Alrightie then!",
			text: "<?php echo $get_message; ?>",
			//type: "success",
			cancelButtonColor: "#DD6B55",
			html: true,
			 className: "sweetalert_desc",
			//showCancelButton: true,
			imageUrl: '{{ asset("website/images/Rocket-Pie-Black-Matte.gif")}}',
			//cancelButtonText: "Login Later",
			//confirmButtonText: "Log in now"
		},
		
		function(isConfirm) {
			if (isConfirm) {
				$('#myModal').modal('show');
			}
		});
</script>
@endif 
<script type="text/javascript">
	function Copy() {
		$("#url").css("display", "block");
		var Url = document.getElementById("url");
		Url.innerHTML = window.location.href;
		console.log(Url.innerHTML)
		Url.select();
		document.execCommand("copy");
		$("#url").css("display", "none");
		$("#copyurl").html("Copied");
		$("#copyurl").css("background", "#f47d43");
	}


</script>
<script type="text/javascript">
function copyUrlgif(id) {
		
	
		  var link = $('#copyUrlgif_'+id).val();
		  var tempInput = document.createElement("input");
		  tempInput.style = "position: absolute; left: -1000px; top: -1000px";
		  tempInput.value = link;
		 
		  document.body.appendChild(tempInput);
		  tempInput.select();
		  document.execCommand("copy");
		  //console.log("Copied the text:", tempInput.value);
		  document.body.removeChild(tempInput);
		
		swal({
			title: "Copied!",
			//text: "Copied the text:", tempInput.value,
			//type: "success",
			cancelButtonColor: "#DD6B55",
			showCancelButton: false,
			imageUrl: '{{ asset("website/images/Rocket-Pie-Black-Matte.gif")}}',
			//cancelButtonText: "Login Later",
			//confirmButtonText: "Log in now"
		
		
		
		}); 
		   
	}

	$("#unsubscribeform").validate({
		
		submitHandler: function(form) {
			

			$.ajax({
				url: "{{ url('/unsubscribe-confirmation') }}",
				data: $(form).serialize(),
				dataType: 'json',
				type: 'post',
				beforeSend: function() {
					
					$(".unsubscribedbtn .fas").hide();
					$('.disable-contact-doteBtn').show();
					$(".unsubscribedbtn").attr("disabled", true);
				},
				success: function(response) {
					
					$(".unsubscribedbtn").html("<i class='fas fa fa-arrow-right'></i>");
					$(".unsubscribedbtn").attr("disabled", false);

					if (response['status'] == true) {						
						setTimeout(function() {
						swal({
							title: "Thank you!",
							text: response['message'],
							
							cancelButtonColor: "#DD6B55",
							imageUrl: '{{ asset("website/images/Rocket-Pie-Black-Matte.gif")}}',
							//type: "success"
							
						},
						function() {
									location.reload();
								}
							);
						}, 100);



					} else if (response['status'] == false) {
						var errMsg = '';

						setTimeout(function() {
						swal({
							title: "Thank you!",
							text: response['message'],
							
							cancelButtonColor: "#DD6B55",
							imageUrl: '{{ asset("website/images/Rocket-Pie-Black-Matte.gif")}}',
							//type: "success"
							
						},
						function() {
									location.reload();
								}
							);
						}, 100);


						
						/*if (response['message']['message']) {
							errMsg += response['message']['message'] + '<br>';
						}
						
						if (errMsg) {
							$('.signup-danger').html(errMsg).show();
							setTimeout(function() {
								$(".signup-danger").fadeOut();
							}, 30000);
						} else {
							$('.signup-danger').html('Something went wrong. Please try again later.').show();
							setTimeout(function() {
								$(".signup-danger").fadeOut();
							}, 30000);
						}*/

					} else {
						$('.signup-danger').html('Something went wrong.').show();
						setTimeout(function() {
							$(".signup-danger").fadeOut();
						}, 30000);
					}


				}
			});

		}
	});
	</script>



