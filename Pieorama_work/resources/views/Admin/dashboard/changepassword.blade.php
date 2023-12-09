@extends('layouts.Admin.appadmin')
@section('content')
<div class="content-wrapper">

<div class="page-header">
      <h3 class="page-title">
      Change Password
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <a href="{!! url('/admin/dashboard'); !!}" class="btn btn-info btn-sm">Back</a>
          </li>
        </ol>
      </nav>
    </div>
          <div class="row">
       <!------->
       <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"></h4>
                  @if ($errors->any())
                  <div class="alert alert-danger">
                  @foreach ($errors->all() as $error)
                  {{$error}}
                  @endforeach
                  </div>
                  @endif
                  @if(session()->has('message'))
                  <div class="alert alert-success">
                  {{ session()->get('message') }}
                  </div>
                  @endif
                  <form class="forms-sample" autocomplete="off" method="post" action="{{ route('admin.changepassword') }}">
                  @csrf
					            <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Current Password</label>
                      <div class="col-sm-9">
                        <input type="password" name="current_password"  class="form-control" id="oldpassword" placeholder="Current Password">
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-3 col-form-label">New Password</label>
                      <div class="col-sm-9">
                        <input type="password" name="password" required="required" class="form-control" id="newpassword" placeholder="New Password">
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label">Confirm Password</label>
                      <div class="col-sm-9">
                        <input type="password" required="required" name="password_confirmation"class="form-control" id="confirmnewpassword" placeholder="Confirm Password">
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label"></label>
                      <div class="col-sm-9">
                         <button type="submit" class="btn btn-primary mr-2 click">Submit</button>
                    <a href="{!! url('/admin/dashboard'); !!}" class="btn btn-light">Cancel</a>
                      </div>
                    </div>
                   
                  </form>
                 
                </div>
              </div>
            </div>
            
       <script type="text/javascript">
         $(document).ready(function(){
            $(".click").click(function(){
              var oldpassword =  $("#oldpassword").val();
              var newpassword =  $("#newpassword").val();
              var confirmnewpassword =  $("#confirmnewpassword").val();
              if(oldpassword == ""){
                swal("Warning!", "Current password can't be blank");
                return false;
              }
              if(newpassword == ""){
                swal("Warning!", "New password can't be blank");
                return false;
              }
              if(confirmnewpassword == ""){
                swal("Warning!", "Confirm password can't be blank");
                return false;
              }

              if(confirmnewpassword != newpassword){
                swal("Warning!", "Confirm password and new password do not match");
                return false;
              }



            });

           });
       </script>
       
       <!----->           
            
          </div>
       
@endsection
