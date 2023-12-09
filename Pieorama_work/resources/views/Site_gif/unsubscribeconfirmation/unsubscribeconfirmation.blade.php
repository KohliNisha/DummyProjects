@extends('layouts.site.web.webapp')
@section('content')


	

<!-- right-panel -->
<div class="right_panel">
	<div class="vd_container fff_bg">
		<div class="row align-items-center">
			<div class="col-12 col-lg-8">
				<?php		
							  foreach($page as $row)		
							  	{			
							  		$title=$row->name;				
							  		$updated_at=$row->updated_at;				
							  		$updated_at=date("d M, Y", strtotime($updated_at));			
							  		$description=$row->description;			
							  	}	 		
							  ?>	
				<h1 class="page-title">{{$title}}</h1>
				
				<div class="mt-4">
					<!-- <div class="alert signup-success" style="display: none; margin-bottom: 30px;"> </div> -->
					@if(Session::has('message'))
						<p class="alert alert-success" style="display: none; margin-bottom: 30px;">{{ Session::get('message') }}</p>
					@endif
					<div class="alert signup-danger" style="display: none;  margin-bottom: 30px;"> </div>
					<form action="{{route('site.unsubscribeconfirmation')}}" method="POST" autocomplete="off" id="unsubscribeform">

						@csrf


						<div class="form-group">
							
							<p>{!!$description!!}</p>
						</div>
						@if($email == '')
							<div class="form-group col-lg-6">
								<input type="text" id="emailnotexist" name="emailnotexist" class="material-input" placeholder="name" required>
								<label for="name" class="form__label" style="left: 27px;">Confirm your email</label>
							</div>
							<input type="hidden" id="name" name="name" value="">
						@else

							<input type="hidden" id="email" name="email" value="{{$email}}">
							<input type="hidden" id="name" name="name" value="{{$name}}">
						@endif
						
							
							
						
						

						<div class="d-flex flex-row-reverse col-lg-6">
							<div>
								<span class="lgt">Go</span>
								<button type="submit" class="login_btn unsubscribedbtn"><i class="fas fa fa-arrow-right"></i>
									<div class="disable-contact-doteBtn">
									<i></i>
									<i></i>
									<i></i>
								</div>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<!-- <div class="col-12 col-lg-7">
				<div class="img_right">
					<img src="{{ asset('website/images/tv.png')}}" alt="image" class="res_100 mb_hide">
				</div>
			</div> -->
		</div>
	</div>
</div>
@endsection