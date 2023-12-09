

// Toggle icon change

function myFunction(x) {
  x.classList.toggle("change");
}


// Adding class in left icons panel


$(".hamburger").on('click', function(){
  $(".left_panel").toggleClass("left_panel_ch");
  $(".right_panel").toggleClass("right_panel_lft");
  $(window).load();
});

// banner close

$(".banner_close").on('click', function(){
	$(".add_banner").hide();
	
});


// custom scrool bar 

(function($){
	$(window).load(function(){
		$(".mCustomScrollbar").mCustomScrollbar({
		});
	});
})(jQuery);


$(".mb_slide").on('click', function(){
  $(".h_links").toggleClass("right0")
})
$(".h_links .fa-times").on('click', function(){
  $(".h_links").removeClass("right0")
})

$(".mb_srch_bar .fa-search").on('click', function(){
  $(".search_br").toggleClass("left0")
})

// Filter 

$("#filter-btn").click(function(){
  $(".filter-category-wrap").slideToggle();
});

// $(".filter-category-list ul li").on('click', function(){
//   $(".filter-category-wrap").slideUp();
// });

// Filter End 

// Reply view list

$(".repl-view-list .view-reply").click(function(){
  //$(this).toggleClass('open-repl');
  $(this).parent().toggleClass('open-repl');
});

$(".repl-view-list .reply-comment").click(function(){
  $(this).parent().addClass('open-compt');
});

$(".cancel-btn2").click(function(){
  $(this).parentsUntil().removeClass('open-compt');
});

$(".nest-comment-box .repl-view-list .reply-comment").click(function(){
  $(this).parent().addClass('nested-open-compt');
});

$(".nested-cancel-btn2").click(function(){
  $(this).parentsUntil().removeClass('nested-open-compt');
});

$(document).on('click', '.edit-cancel-btn', function(){
   // alert();
  $(this).parents('.btn-2-warp').prev(".commnet-messa").removeClass('editable-commt');
  $(this).parents('.btn-2-warp').prev(".commnet-messa").attr('contenteditable', 'false');
  $(this).parents('.btn-2-warp').remove();

});


$(".edit-comment").click(function(){ 
  $(this).parents('.comment-opt').prev(".commnet-messa").attr('contenteditable', 'true'); 
   $(this).parents('.comment-opt').prev(".commnet-messa").addClass('editable-commt');

  $(this).parents('.comment-opt').prev(".commnet-messa").after("<div class='btn-2-warp'> <button type='button' class='btn btn-primary cancel-btn-bg edit-cancel-btn'>Cancel</button> <button type='button' class='btn btn-primary edit-save-btn'>Save</button> </div>");
   
});

// Reply view list end 

// Notification min height
$.myFunction = function(){
  var $w_height = $(window);
  var $h_height = $('header');
  var $f_height = $('footer');
  var add_hf_height = $h_height.height() + $f_height.height();
  var cal_height = $w_height.height() -  add_hf_height;
  $('.notifi-in').css({"min-height":cal_height + "px"} );
}

$.myFunction();

// window resize

$(window).on('resize', function(){
  $.myFunction();
  // var $w_height = $(window);
  // var $h_height = $('header');
  // var $f_height = $('footer');
  // var add_hf_height = $h_height.height() + $f_height.height();
  // var cal_height = $w_height.height() -  add_hf_height;
  // $('.notifi-in').css({"min-height":cal_height + "px"} ); 
});
// Report commnet popup

$('.rcp-btn').click(function(){
  $('.rpc-popup').addClass('rpc-open');
});

$('.rcp-cancel-btn').click(function(){
  $('.rpc-popup').removeClass('rpc-open');  
});

// Profile upload image

var readURL = function(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      $('.profile-pic').attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}    

$(".file-upload").on('change', function(){
  readURL(this);
});
    
$(".upload-button").on('click', function() {
  $(".file-upload").click();
});

// Profile upload image end

$('.responsive').slick({
    dots: false,
    speed: 600,
    slidesToShow: 5,
    slidesToScroll: 1,
    arrows: false,
    autoplay:false,
    autoplaySpeed:3000,
    draggable:false,
    cssEase: 'linear',
    responsive: [
    {
      breakpoint: 1300,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});



$('.eyw-icon').click(function(){
  $(this).toggleClass('showPass')
  var input = $(".passwordChange");
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }

});


$('.eyw-iconconfirm').click(function(){
  $(this).toggleClass('showPassconfirm')
  var input = $(".passwordconfirm");
  if (input.attr("type") === "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }

});






