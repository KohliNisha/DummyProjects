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
   $(".librarylink").addClass("active");
   $(".videolink").addClass("active");
   $(".collapse").addClass("show");
});
</script>
<div class="content-wrapper">
    <div class="page-header">
     <h3 class="page-title">  Library Management </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
           <a href="{!! url('/admin/video-library'); !!}" class="btn btn-info  btn-sm">Back</a>  
          </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">         
          <h4 class="card-title">Add New Video File (Only mp4 are allowed, MAX 10MB)</h4>  
          <hr/><br/>  
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
          <form class="forms-sample"  autocomplete="off" id="AudioForm" method="post" action="{{ route('admin.videoAdd') }}" enctype="multipart/form-data">
           @csrf
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Title <sup >*</sup></label>
                <div class="col-sm-9">
                    <input type="text" name="title" maxlength="256" value="{{ old('title') }}" placeholder="Title of Video" class="form-control" value="">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Internal Note</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="comment_note" id="exampleTextarea1" rows="4" spellcheck="false">{{ old('comment_note') }}</textarea>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Add Tags</label>
                <div class="col-sm-9">
                   <textarea class="form-control" name="library_tags" id="library_tags" rows="4" spellcheck="false" placeholder="Example: #pop-song #Amazing #realityPieogram">{{ old('library_tags') }}</textarea>

                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Video file <sup>*</sup></label>
                <div class="col-sm-9">
                    <input type="file" name="library_file" class="" id="library_file" class="form-control" />
                </div>
              </div>
            </div>
          </div>
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
<script>
$("#AudioForm").validate({
    rules: {
         title: {
           required: true,
           maxlength: 255
        },  

      library_file: {
        required: true,
        extension: "mp4"
      },
    },
    submitHandler: function(form){
        $('.submit').attr('disabled', 'disabled');
        $(".submit").html('Please wait..');
        form.submit();
    }
});

$('#library_file').bind('change', function() {
  var file_size = $('#library_file')[0].files[0].size;
  if(file_size>102428800) {
    swal("File size should not be greater than 10MB");
    $('#library_file').val('');
    return false;
  } 
  return true;
});
</script>
@endsection
