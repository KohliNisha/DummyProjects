@extends('layouts.Admin.appadmin')
@section('content')
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
            <h3 class="page-title">
              <span class="page-title-icon bg-gradient-primary text-white mr-2">
                <i class="mdi mdi-home"></i>                 
              </span>
              Dashboard
            </h3>
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                 <!--  <span></span>Overview
                  <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i> -->
                </li>
              </ul>
            </nav>
          </div>
          <div class="row">
            <div class="col-md-6 stretch-card grid-margin">
              <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                  <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
                  <h4 class="font-weight-normal mb-3"> User Management
                    <i class="mdi mdi-account-multiple mdi-24px float-right"></i>
                  </h4>
                  <a href="{!! url('/admin/users'); !!}"  style="color: white;"><h2 class="mb-5" style="color: white;">Total {{$total_user}}</h2></a>
                  
                </div>
              </div>
            </div>
            <!--
			<div class="col-md-4 stretch-card grid-margin">
              
			  <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="{{ asset('images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image"/>                  
                  <h4 class="font-weight-normal mb-3">Channels Management
                      <i class="mdi mdi-database mdi-24px float-right"></i>                  
                  </h4>
                  <a href="{!! url('/admin/channels'); !!}"  style="color: white;"><h2 class="mb-5" style="color: white;">Total {{$total_channel}}</h2></a>
                  
                </div>
              </div>
			  
            </div>
			-->
            <div class="col-md-6 stretch-card grid-margin">
              <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                  <img src="{{ asset('images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image"/>                                    
                  <h4 class="font-weight-normal mb-3">Pieograms Management 
                     <i class="mdi mdi-credit-card mdi-24px float-right"></i>
                   
                  </h4>
                  <a href="{!! url('/admin/pieograms'); !!}"  style="color: white;">
                  <h2 class="mb-5">Total {{$total_video}}</h2>
                  </a>
                  
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-danger card-img-holder text-white">
                <div class="card-body">
                  <img src="{{ asset('images/dashboard/circle.svg') }}" class="card-img-absolute" alt="circle-image"/>
                  <h4 class="font-weight-normal mb-3">Tags Management
                    <i class="mdi mdi-google-wallet mdi-24px float-right"></i>
                  </h4>
                   <a href="{!! url('/admin/tags'); !!}"  style="color: white;">
                   <h2  style="color: white;" class="mb-5">Total {{$total_tag}}</h2> 
                  </a>
                  
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                  <img src="{{ asset('images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image"/>                  
                  <h4 class="font-weight-normal mb-3">Reports 
                    <i class="mdi mdi-bank mdi-24px float-right"></i>
                  </h4>
                  <h2 class="mb-5">Total 0</h2>
                  
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card grid-margin">
              <div class="card bg-gradient-success card-img-holder text-white">
                <div class="card-body">
                  <img src="{{ asset('images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image"/>                                    
                  <h4 class="font-weight-normal mb-3">Pending Queries for Reply
                    <i class="mdi mdi-headset-off mdi-24px float-right"></i>
                  </h4>
                  <a href="{!! url('/admin/query'); !!}" style="color: white;" > <h2 class="mb-5">Total {{$query_total}}</h2></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
 
  <script type="text/javascript">
  $(document).ready(function() {
  window.history.pushState(null, "", window.location.href);        
  window.onpopstate = function() {
      window.history.pushState(null, "", window.location.href);
  };
  });
  </script>
@endsection
