@extends('layouts.Admin.appadmin')
@section('content')
<style type="text/css">
 sup, .error {color: red;}
 #library_file-error {display: block !important;
 padding-top: 5px !important;
 }

</style>
<script type="text/javascript">
$(document).ready(function(){
  // $(".Videoslink").addClass("active");
});
</script>
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title"> Send Email </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <!--  <a href="{!! url('/admin/pieograms'); !!}" class="btn btn-info  btn-sm">Back</a>   -->
          </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">         
          <h4 class="card-title">Mail</h4>
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
          <form class="forms-inline" autocomplete="off" method="post" id="BulkmailForm" action="" enctype="multipart/form-data">
           @csrf
           @if(Request::segment(2) != 'bulkmail')
             <div class="row">
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">E- mail</label>
                    <div class="col-sm-8">
                      
                        <input type="text" name="subject" class="form-control"  value="@if(isset($users->email)) {{$users->email}} @endif" disabled>
                        
                    </div>
                  </div>
                </div>
                 
              </div>
            @endif
                <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Subject</label>
                      <div class="col-sm-9">
                        <input type="text" name="subject" class="form-control"  value="">
                      </div>
                </div>
                

                 <div class="form-group row">
                      <label for="exampleInputConfirmPassword2" class="col-sm-2 col-form-label">Contents</label>
                      <div class="col-sm-9">
                      <textarea name="message" id="editor1"></textarea>
                        <!-- <textarea name="body" class="jqte-test form-control"></textarea> -->
                      </div>
                    </div>
             <!--  <div class="form-group row" id="subscribemailtemplate">
                      <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Email-template</label>
                      <div class="col-sm-9">
                        @if(isset($mailtemplate))
                          <div class="disablebox">
                             <h2><span>{!! $mailtemplate->body !!}</span></h2>
                          </div>
                        @endif
                      </div>
                    </div> -->
           
                

           
         
            <div class="form-group row">       
               <div class="col-sm-4"></div>
                <div class="col-sm-4">
               <button type="submit" class="btn btn-primary mr-2 submit">Submit</button>
               <button type="reset" class="btn btn-gradient-light mr-2">Reset</button>  
               </div>
                <div class="col-sm-4"></div>             
            </div>        
        </form>
         <span style="color: red;">*</span><span style="font-size: 13px;"> Required field</span>
      </div>
      </div>
    </div>
  </div>

<script src="{{ asset('js/admin/js/jquery.validate.js')}}"></script>
<script src="{{ asset('js/admin/js/additional-methods.min.js')}}"></script>
<script type="text/javascript">
   
    

</script>
@endsection
