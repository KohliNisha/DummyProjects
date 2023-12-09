
@extends('layouts.site.web.webapp')


<!-- right-panel -->	
	<div class="right_panel1 landingpage_wrapper">	
		<?php		
		if($pages)	
			{			
				$title=$pages->name;				
								
						
				$description=$pages->description;			
			}	 		
		?>
		<div class="vd_container fff_bg">	
			
			<div class="body-text"> 
				<?php echo $description; ?>
			
			</div>
		</div>
	</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#landingppage_footer').hide();
		$('#header').addClass('landingpage-header');
		$('#cookie-msg').hide();
		$('.search_br').hide();
		$('.mb_srch_bar').hide();
		$('.mb_slide').hide();
		$('.h_links').hide();
		$('.login-hide').hide();
	});
	
</script>