@extends('layouts.site.web.webapp')
@section('content')

	<!-- right-panel -->
	<div class="right_panel">
		
	
	   <div class="" id="">
	    <div class="-dialog">
	      <div class="-content">
	        <button type="button" class="close md_close" data-dismiss="">&times;</button>
	       
	        <div class="modal-body">
	        	<div class="row align-items-center">
	           		<div class="col-12 col-lg-3 text-center login_left">
	           			
	           		</div>
	           		<div class="col-12 col-lg-6">
	           		 <form action="{{route('site.setnewpassword')}}" name="setnewpassword" id="setnewpassword"  method="post" class="form-group">
	           		 	 @csrf
	           		 	<input type="hidden" name="urlcode" value="<?php echo $urlcode ; ?>">
	           			<div class="login_txt"> 
	           		
	           			</div>
	           			<div class="form_area">
	           				<div class="alert login-success" style="display: none; margin-bottom: 30px;"> </div>
                           <div class="alert login-danger" style="display: none;  margin-bottom: 30px;"> </div> 

	           				<div class="form-group">
                                <input type="password" id="pass" name="password" class="material-input passwordChange"  placeholder="E-mail Address">
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
                            		<a href="javascript:;" class="frg" data-dismiss="modal"  data-toggle="modal" data-target="#myModal">Login</a>
                            	</div>
                            	<div>
                            		<span class="lgt">Submit</span>
                            		<button type="submit" class="login_btn">
                            			<i class="fas fa fa-arrow-right"></i>
                            		</button>
                            	</div>
                            </div>
                            <div class="mt-4 text-center">
                            	<span class="or">Or SignUp</span>
                            </div>
                            <div class="mt-4">
                            
                            </div>
                              <div class="mt-4"> </div>
                              <div class="mt-4"> </div>                            
                            <div class="mt-4 text-center btm_txt">
                            	DON'T HAVE AN ACCOUNT? <a href="javascript:;" data-dismiss="modal"  data-toggle="modal" data-target="#myModal2" >SIGN UP</a>
                            </div>
	           			</div>
	           		  </form>	
	           		</div>
	        	</div>
	        </div>
	      </div>
	    </div>
  	    </div>

  	    <div style="height: 200px;"></div>
	</div>

<script>


</script>




@endsection        
