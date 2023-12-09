@extends('layouts.Admin.appadmin')
@section('content')
<style>
.userimage{
/*width: 192px !important;*/
border-radius: 10px;
max-height: 150px;
}
</style>

<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
      User Details
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <?php
            $pre_url = url()->previous();
            $getseg = explode("/",$pre_url);
           
            ?>
            @if($getseg[4] == 'subscribeuserlist')
              <a href="{!! url('/admin/subscribeuserlist'); !!}" class="btn btn-info  btn-sm">Back</a>
            @else

            <a href="{!! url('/admin/users'); !!}" class="btn btn-info  btn-sm">Back</a>
            @endif
          </li>
        </ol>
      </nav>
    </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"></h4>
                <div class="pull-right">
                </div>

                  <?php //dd($user); ?>
                  <div class="col-md-12 col-lg-12">

                  <div class="row">
                    <div class="col-md-6">Profile Image</div>
                  <div class="col-md-6">
                      @if($user->profile_image !='')         
                      <a target="_blank" href="{{$user->profile_image}}"><img src="{{$user->profile_image}}" class="img-rounded userimage" ></a>
                      @else
                      <img src="{{ asset('images/nouserimage.png') }}" class="img-rounded userimage">
                      @endif
                  </div>
                  </div>
                  <br/>

                  <div class="row">
                    <div class="col-md-6">Title</div>
                    <div class="col-md-6">{{$user->title}}</div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-6">First Name</div>
                    <div class="col-md-6">{{$user->first_name}}</div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-6">Last Name</div>
                    <div class="col-md-6">{{$user->last_name}}</div>
                  </div>
                 <br>
                  <div class="row">
                    <div class="col-md-6">Email</div>
                    <div class="col-md-6">{{$user->email}}</div>
                  </div>
                  <br>

                   <div class="row">
                    <div class="col-md-6">OTP</div>
                    <div class="col-md-6">
                      @if($user->otp !='')
                      {{$user->otp}}
                      @endif
                    </div>
                   </div>
                  <br>


                  <div class="row">
                    <div class="col-md-6">Phone Number</div>
                    <div class="col-md-6">
                      @if($user->phone_number !='')
                      {{$user->phone_code. '-' .$user->phone_number}}
                        @if($user->is_phone_verify ==0)
                        <label class='badge badge-gradient-success verifyOtp' data-id="{{$user->id}}"  data-id1="{{$user->otp}}">Verify</label> 
                         @endif 
                      @endif
                    </div>
                  </div>
                  <br>


                    <div class="row">
                    <div class="col-md-6">Last login device type</div>
                    <div class="col-md-6">
                    @if($user->device_type =='1')   
                                   Android    @else      iOS  
                        @endif
                    </div>
                  </div>
                  <br>

                  <div class="row">
                    <div class="col-md-6">Want to Promotional offers?</div>
                    <div class="col-md-6">
                    @if($user->promotional_offers =='1')   
                                   Yes    @else      No  
                        @endif
                    </div>
                  </div>
                    <br>

                    <div class="row">
                    <div class="col-md-6">Is signup complete</div>
                    <div class="col-md-6">
                    @if($user->signupstep =='2')   
                                   Yes    
                                   @else  
                               No  
                        @endif
                    </div>
                  </div>

                  <br>
                  <div class="row">
                    <div class="col-md-6">Phone Number Verify Status</div>
                    <div class="col-md-6">
                    @if($user->is_phone_verify =='1')   
                                  <label class='badge badge-gradient-success'>Verified</label>    @else    
                                  <label class='badge badge-gradient-warning'>Pending</label>    
                        @endif
                    </div>
                  </div>
                  <br>
                   
                    <div class="row">
                    <div class="col-md-6">Email Verify Status</div>
                    <div class="col-md-6">
                    @if($user->is_confirm =='1')    
                              <label class='badge badge-gradient-success activatedEmail' data-id="{{$user->id}}"  data-id1='1'>Verified</label>     
                        @else
                           <label class='badge badge-gradient-warning activatedEmail' data-id="{{$user->id}}"  data-id1='0'>UnVerified</label>     
                        @endif
                    </div>
                  </div> 
                  <br>
                     

                  <div class="row">
                    <div class="col-md-6">Account Activation Status</div>
                    <div class="col-md-6">
                    @if($user->status =='1')    
                              <label class='badge badge-gradient-success activatedAccount' data-id="{{$user->id}}"  data-id1='1'>Activated</label>     
                        @else
                            <label class='badge badge-gradient-warning activatedAccount' data-id="{{$user->id}}" data-id1='0'>Deactivated</label>       
                        @endif
                    </div>
                  </div>
                   <br>

                   <div class="row">
                    <div class="col-md-6">Newsletter</div>
                    <div class="col-md-6">
                    @if($user->newsletter =='1')    
                              <label class='badge badge-gradient-success unsubscribe' data-id="{{$user->id}}"  data-id1='1'>Subscribed</label>     
                        @else
                            <label class='badge badge-gradient-warning' data-id="{{$user->id}}" data-id1='0'>Unsubscribed</label>       
                        @endif
                    </div>
                  </div>
                   <br>

                  <div class="row">
                    <div class="col-md-6">Last Updated Profile Date</div>
                    <div class="col-md-6">{{$user->updated_at->format('Y/m/d')}}  </div>
                  </div>
                    <br>
                    
                  <div class="row">
                    <div class="col-md-6">Account Registration Date</div>
                    <div class="col-md-6">{{$user->created_at->format('Y/m/d')}}  </div>
                  </div>




                  </div>

                </div>
              </div>
            </div>
          </div>
@endsection
