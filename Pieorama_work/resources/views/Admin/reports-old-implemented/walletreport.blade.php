@extends('layouts.Admin.appadmin')
@section('content')
<style type="text/css">
	.page-title .page-title-icon {
    display: inline-block;
    width: 70px;
    height: 36px;
    border-radius: 4px;
    text-align: center;
    box-shadow: 0px 3px 8.3px 0.7px rgba(163, 93, 255, 0.35);
}
.col-md-4 {
    flex: 0 0 33.33333%;
    max-width: 20.33333%;
}
.bg-gradient-danger {
    background: transparent;
}
.text-white {
    color: black !important;
}
.btn {
    font-size: 1rem;
    line-height: 1;
    font-family: "ubuntu-bold", sans-serif;
}
.active {
    background: #dae0e6;
    color: #009cdf;
}
</style>

      <div class="main-panel">
        <div class="content-wrapper">
          <div class="page-header">
              <h3 class="page-title">
                     Wallet Report
              </h3>
          
            <nav aria-label="breadcrumb">
              <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                  <span></span>Overview
                  <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
              </ul>
            </nav>
          </div>

          <div class="card">
               <div class="card-body">

                   <div class="template-demo">
                      <a href="/admin/clientreports"> <button type="button" class="btn btn-secondary btn-fw">Client Report</button></a> 
                      <a href="/admin/loanreports"> <button type="button" class="btn btn-secondary btn-fw">Loan Report</button></a>
                      <a href="/admin/walletreports"> <button type="button" class="btn btn-primary btn-fw">Wallet Report</button></a>
                      <a href="/admin/repaymentreports"><button type="button" class="btn btn-secondary btn-fw">Repayment</button></a>
                      <a href="/admin/queryreports"><button type="button" class="btn btn-secondary btn-fw">Query Report</button></a>
                    </div>
                 </div>
          	



         <div class="card-body">

           <div class="row">
             <h1> Under Construction</h1> 

          </div>
           </div>


          <div class="row">
            
           
          </div>
        
        
        </div>
      <script type="text/javascript">

  $(document).ready(function() {
  window.history.pushState(null, "", window.location.href);        
  window.onpopstate = function() {
      window.history.pushState(null, "", window.location.href);
  };
  });
  </script>

  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dataTables.jqueryui.min.css') }}">
  <link href="{{ asset('css/newcss/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" /> 
  <script src="{{ asset('js/jquery.dataTables.min.js')}}"></script> 
  <script src="{{ asset('js/dataTables.jqueryui.min.js')}}"></script>
  <script src="{{ asset('js/newjs/dataTables.buttons.min.js')}}"></script>
  <script src="{{ asset('js/newjs/jszip.min.js')}}"></script>
  <script src="{{ asset('js/newjs/pdfmake.min.js')}}"></script>
  <script src="{{ asset('js/newjs/vfs_fonts.js')}}"></script>
  <script src="{{ asset('js/newjs/buttons.html5.min.js')}}"></script>
@endsection
