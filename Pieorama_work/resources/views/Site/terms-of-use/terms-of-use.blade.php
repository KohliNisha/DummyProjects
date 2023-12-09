@extends('layouts.site.web.webapp')@section('content')	<!-- right-panel -->		<div class="right_panel1">		
	<?php		
	  foreach($pages as $row)		
	  	{			
	  		$title=$row->name;				
	  		$updated_at=$row->updated_at;				
	  		$updated_at=date("d M, Y", strtotime($updated_at));			
	  		$description=$row->description;			
	  	}	 		
	  ?>		
	  <div class="vd_container fff_bg">			
	  	<h1 class="page-title">
	  		<?php echo $title; ?></h1>			
	  		<!-- <h4> <span class="static-page-sunHD">Last updated:</span> <span class=""><?php echo $updated_at; ?></span></h4>		 -->			
	  		<div class="mt-4 body-text"> 				
	  			<?php echo $description; ?>			
	  		</div>		
	  	</div>
	  </div>
	 @endsection        