<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Pieorama Admin</title>
  <meta name="_token" content="{{csrf_token()}}" />
  <script src="{{ asset('vendors/js/vendor.bundle.base.js')}}"></script>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('vendors/iconfonts/mdi/css/materialdesignicons.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->

  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
  <link href="{{ asset('images/favicon.png')}}" rel="shortcut icon" />
  <!-- endinject -->
  <script src="{{ asset('js/newjs/jquery-3.3.1.min.js')}}"></script>
  <script src="{{ asset('scripts/jquery-ui-1.8.16.custom.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('scripts/jtable/jquery.jtable.js') }}" type="text/javascript"></script> 
  
  <!-- New js and css added for the style -->
  <script src="{{ asset('js/newjs/jquery.jtable.js')}}"></script>
  <link href="{{ asset('css/newcss/jtable.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{ asset('css/newcss/custom-jtable.css')}}" rel="stylesheet" type="text/css" />  
</head>
<body>
    <body>
		<div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
        @include('layouts.Admin.headeradmin')
        @yield('content')
        @include('layouts.Admin.footeradmin')
       
    </body>
</html> 