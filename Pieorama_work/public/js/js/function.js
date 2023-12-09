/*-----------------tabs------------------*/
$(document).ready(function(){

/*	$(".mobile-menu").click(function(){
		$(".header-right-list ").slideToggle(200);
		$(this).toggleClass("active");
	});
	$(".closePopupall").click(function() {        
		$(".overlay").fadeOut(300);
		$("body").css("overflow","auto");
		$(window).resize();
	});          
	$(".showPopup").on('click',function (e) {
		e.preventDefault();
		var popId=$(this).attr("href");
		$(popId).fadeIn(300);
		$("body").css("overflow","hidden")
		$(window).resize();
	});  
	$(".mobile-menu").click(function(event) {
	event.stopPropagation();
	});          
	$("body").click(function(event) {
	$(".header-right-list").slideUp();

	});
*/



$(".closePopupall").click(function() { 	 
	$(".overlay").fadeOut(300);
	$("body").css("overflow","auto");
	$(window).resize();
});	
 $(".showPopup").on('click',function (e) {
	e.preventDefault();
	var popId=$(this).attr("href");
	$(popId).fadeIn(300);
	$("body").css("overflow","hidden")
	$(window).resize();
});	
$('a.scroll[href^="#"]').bind('click.smoothscroll',function (e) {
		e.preventDefault();
		var target = this.hash,
		$target = $(target);
		$('html, body').stop().animate( {
			'scrollTop': $target.offset().top-60
		}, 900, 'swing');
	});

if ($(window).width() < 767) {
	 $(".mobile-menu").click(function(){
	 	$(".header-right-list ").slideToggle(200);
	 	$(this).toggleClass("active");
	 });

	$(".mobile-menu").click(function(event) {
		event.stopPropagation();
	});	
	$("body").click(function(event) {
		$(".header-right-list").slideUp();
	});
}	




});

