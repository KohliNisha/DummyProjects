
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Plendify Admin</title>
  <!-- plugins:css -->
 
  <link href="{{ asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/css/vendor.bundle.base.css') }}" rel="stylesheet">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('images/Plendify_RGB.png') }}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row w-100">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left p-5">
              <div class="brand-logo">
                <img src="{{ asset('images/Plendify_RGB.png') }}">
              </div>
              <h4 style="text-align: center;" >Welcome to the Amin panel</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>
              @if (session('status'))
                  <div class="alert alert-danger">
                      {{ session('status') }}
                  </div>
              @endif
                <form method="POST" autocomplete="off" action="{{ route('admin.login') }}" id="donarlogin"  class="pt-3">
                        @csrf
                <div class="form-group">
                  <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Email address " required="required" name="email"  value="{{ old('email') }}" >
                </div>
                <div class="form-group">
                  <input type="password"  name="password"  class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password">
                </div>
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" name="remember" id="remember" value="1" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                <div class="mt-3">
                  <input type="submit" name="submit" value="SIGN IN" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
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
  
</body>

</html>

