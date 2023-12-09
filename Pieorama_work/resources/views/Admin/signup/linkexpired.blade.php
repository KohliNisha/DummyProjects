
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
              <h4 style="text-align: center;" >Your link has been expired.</h4>
              <!-- <h6 class="font-weight-light" style="text-align: center;">Link Expired.</h6> -->
                  @if (session('message'))
                      <div class="alert alert-danger">
                          {{ session('message') }}
                      </div>
                  @endif

                  <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                    </label>
                  </div>
                    <a href="{!! url('/admin/forgot-password'); !!}" class="auth-link text-black">Forgot password?</a>
                </div>



              
              </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  
</body>

</html>

