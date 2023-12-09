$(document).ready(function(){
	$('.showMobMenu').click(function() {
		$('body').addClass('active');
		$('.menuLinks').addClass('active');
		$('.closeMobMenu').addClass('active');
	});
	$('.closeMobMenu').click(function() {
		$('body').removeClass('active');
		$('.menuLinks').removeClass('active');
		$('.closeMobMenu').removeClass('active');
	});	
	$('.showSearch').click(function() {
		$('#search').slideToggle(300);
		$(this).toggleClass('active');
	});	
	$(".showPopup").on('click',function (e) {
		e.preventDefault();
		var popId=$(this).attr('data-');
		$('.overlay').fadeOut(0);
		$(popId).fadeIn(300);
		$("body").css("overflow","hidden");
		$(window).resize();
		$(".ErrorBox").css('display','none');
	});	
	$(".closePopup").click(function() {
		$(".overlay").fadeOut(300);
		$("body").css("overflow","auto");
		$(".ErrorBox").css('display','none');
		$('#verificationotp')[0].reset();
		$('#forgot-otp')[0].reset();
		$('#reset-new-password')[0].reset();
		$('#donarforgotpassword')[0].reset();
		$('#donarsignupform')[0].reset();
		$('#donarlogin')[0].reset();
	});	
	$(".footHd").click(function(){
		$(".footMobBox").slideUp(300);
		if($(this).hasClass("active")){
			$(".footHd").removeClass("active");
			$(this).next(".footMobBox").slideUp(300);
		}
		else{
			$(".footHd").removeClass("active");
			$(this).addClass("active");
			$(this).next(".footMobBox").slideDown(300);
		}
	});	
	$(document).mouseup(function (e)
		{ 
		var container = $(".showMobMenu");
		var container1 = $(".menuLink");
		var container2 = $(".menuLink *");
		if (!container.is(e.target)  && !container2.is(e.target) && !container.is(e.target) && !container1.is(e.target)   && container.has(e.target).length === 0) // ... nor a descendant of the container
		{	
			container1.stop().slideUp(0);
			$(".showMobMenu").removeClass("active");
		} 
	});	
	$(".showMobMenu").click(function(){
		$(".menuLink").slideToggle(300);
		$(this).toggleClass('active');
	});
	$('.checkInpt').each(function() {
		$(this).wrap("<span class='checkWrapper'></span>");
		$(this).after("<i class='bg'></i>");	
	});	
	$(".q").click(function() {
		$(this).next('.ans').slideToggle(300);
		$(this).toggleClass('active');
	});
	
	
	$(document).mouseup(function (e)
		{ 
		var ddcontainer = $(".ddShow");
		var ddcontainer1 = $(".ddBox");
		var ddcontainer2 = $(".ddBox *");
		if (!ddcontainer.is(e.target)  && !ddcontainer2.is(e.target) && !ddcontainer.is(e.target) && !ddcontainer1.is(e.target)   && ddcontainer.has(e.target).length === 0) // ... nor a descendant of the container
		{	
			ddcontainer1.stop().slideUp(0);
			$(".ddShow").removeClass("active");
		}
	});	
	$(".ddShow").click(function(){
		$(".ddBox").slideUp(300);
		if($(this).hasClass("active")){
			$(".ddShow").removeClass("active");
			$(this).next(".ddBox").slideUp(300);
		}
		else{
			$(".ddShow").removeClass("active");
			$(this).addClass("active");
			$(this).next(".ddBox").slideDown(300);
		}
	});
	
	
	
	$(document).mouseup(function (e)
		{ 
		var ddcontainer = $(".showDbMenu");
		var ddcontainer1 = $(".ddMenu");
		var ddcontainer2 = $(".ddMenu *");
		if (!ddcontainer.is(e.target)  && !ddcontainer2.is(e.target) && !ddcontainer.is(e.target) && !ddcontainer1.is(e.target)   && ddcontainer.has(e.target).length === 0) // ... nor a descendant of the container
		{	
			ddcontainer1.stop().slideUp(0);
			$(".showDbMenu").removeClass("active");
		}
	});	
	$(".showDbMenu").click(function(){
		$(".ddMenu").slideUp(300);
		if($(this).hasClass("active")){
			$(".showDbMenu").removeClass("active");
			$(this).next(".ddMenu").slideUp(300);
		}
		else{
			$(".showDbMenu").removeClass("active");
			$(this).addClass("active");
			$(this).next(".ddMenu").slideDown(300);
		}
	});
	
	
	$(".closePopupLogin").click(function() {
		$(".overlay").fadeOut(300);
		$("body").css("overflow","auto");
		$(".errorloginbox").css('display','none');
		$(".mobileVerification").css('display','none');
		$('#donarlogin')[0].reset();
	});	

	$(".closePopupSignup").click(function() {
		$(".overlay").fadeOut(300);
		$("body").css("overflow","auto");
		$(".donarSignupError").css('display','none');
		$(".mobileVerification").css('display','none');
		$('#donarsignupform')[0].reset();
	});	

	$(".closePopupForgot").click(function() {
		$(".overlay").fadeOut(300);
		$("body").css("overflow","auto");
		$(".donarforgotpassworderror").css('display','none');
		$(".succeotpforgotpassword").css('display','none');
		$('#donarforgotpassword')[0].reset();
		
	});
	
	$(".closePopupResetpwd").click(function() {
		$(".overlay").fadeOut(300);
		$("body").css("overflow","auto");
		$(".resetpwderror").css('display','none');
		$(".resetpassword").css('display','none');
		$('#reset-new-password')[0].reset();
	});

	
	$(".closePopupResetOTP").click(function() {
		$(".overlay").fadeOut(300);
		$("body").css("overflow","auto");
		$(".errorresetotpbox").css('display','none');
		$(".succeotpforgotpassword").css('display','none');
		$('#forgot-otp')[0].reset();
	});

	$(".closePopupMobileVerification").click(function() {
		$(".overlay").fadeOut(300);
		$("body").css("overflow","auto");
		$(".mobileVerification").css('display','none');
		$(".mobileverificationerror").css('display','none');
		$('#verificationotp')[0].reset();
		
	});


});

