
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pieorama Admin</title>
  <!-- plugins:css -->
 
  <link href="{{ asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/css/vendor.bundle.base.css') }}" rel="stylesheet">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" />
  <style type="text/css">
   .auth .brand-logo img {
    width: auto;
   }
     .bg-gradient-primary {
    background: linear-gradient(to right, #6c6a7b, #7e7da6);
   }
  .btn-primary:hover,  .btn-info:hover{
      color: #fff;
      background-color: #5d5a92 !important;
      border-color: #e7c164;
  }
  .btn-primary, .btn-info, .border-primary {
      color: #fff;
      background-color: #727090 !important;
      border-color: #e7c164;
  }

  </style>
</head>

<body>


  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo" style="text-align: center;">
                <img src="{{ asset('images/logo.png') }}" style="max-width: 350px; margin: auto;">
              </div>
             <!--  for login  -->
              <h4 style="text-align: center;" >Set your new password</h4>
              <h6 class="font-weight-light" style="text-align: center;">Reset your password.</h6>

              @if (session('status'))
                  <div class="alert alert-danger">
                      {{ session('status') }}
                  </div>
              @endif
                <form method="POST" autocomplete="off" action="{{ route('admin.setnewpassword') }}" id="changepass"  class="pt-3">
                        @csrf                

                <div class="form-group">
                  <input type="password"  name="password"   class="form-control form-control-lg" id="password" placeholder="Set New Password">
                  <span class="error"></span>
                </div>

                <div class="form-group">
                  <input type="password"  name="cpassword" required="required"   class="form-control form-control-lg" id="cpassword" placeholder="Confirm New Password">
                  <span class="error1"></span>
                </div>
                <input type="hidden" name="urlcode" value="<?php echo $urlcode ; ?>">
                  <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                    </label>
                  </div>
                  <a href="{!! url('/admin'); !!}" class="auth-link text-black">Login</a>
                </div>

                
                <div class="mt-3">
                  <input type="submit" name="submit" value="SUBMIT" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn submtbtncl">
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                  </div>
                </div>
              </form>
              </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  

<script src="{{ asset('js/newjs/jquery-3.3.1.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $("#changepass").validate({
        rules: {  
            password: {
                required: true,
                minlength: 8,
                maxlength: 50
               
            },
            cpassword: {
                required: true,
                equalTo: "#password",
            },
           
        }
    });

});
</script>

<style type="text/css">
  .error{color: red;}
</style>

  
</body>
</html>

