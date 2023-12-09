@extends('layouts.site.web.webapp')
@section('content')


	

<!-- right-panel -->
<div class="right_panel">
	<div class="vd_container fff_bg">
		<div class="row align-items-center">
			<div class="col-12 col-lg-5">
				<h1 class="page-title">Contact</h1>
				<span class="page-subtitle">Drop us a line and tell us how you're doing.</span>
				<div class="mt-4">
					<!-- <div class="alert signup-success" style="display: none; margin-bottom: 30px;"> </div> -->
					@if(Session::has('message'))
						<p class="alert alert-success" style="display: none; margin-bottom: 30px;">{{ Session::get('message') }}</p>
					@endif
					<div class="alert signup-danger" style="display: none;  margin-bottom: 30px;"> </div>
					<form action="{{route('site.contactus')}}" method="POST" autocomplete="off" id="contactusform">

						@csrf
						<div class="form-group">
							<input type="text" id="name" name="name" class="material-input" placeholder="name" required>
							<label for="name" class="form__label">Name</label>
						</div>
					<!-- 	<div class="form-group">
							<input type="tel" id="phone" name="phone" class="material-input" placeholder="phone">
							<label for="phone" class="form__label">Phone</label>
						</div> -->
						<div class="form-group">
							<input type="text" id="email" name="email" class="material-input" placeholder="email" required>
							<label for="email" class="form__label">Email</label>
						</div>
						<div class="form-group">
							<textarea class="material-input msg_area" rows="8" name="message" placeholder="Message" required></textarea>
						</div>


						 <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">

                            <label class="col-md-4 control-label">Captcha</label>

                            <div class="col-md-6">

                                {!! app('captcha')->display() !!}

                                @if ($errors->has('g-recaptcha-response'))

                                    <span class="help-block">

                                        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>

                                    </span>

                                @endif

                            </div>

                        </div>


						<div class="d-flex flex-row-reverse">
							<div>
								<span class="lgt">Go</span>
								<button type="submit" class="login_btn contctpbtn"><i class="fas fa fa-arrow-right"></i>
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