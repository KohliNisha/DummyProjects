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
      <h3 class="page-title"> While You Wait video </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
           <a href="{!! url('/admin/tvscreeninglist'); !!}" class="btn btn-info  btn-sm">Back</a>  
          </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">         
          <h4 class="card-title">Update New Video File (MAX 10MB)</h4>  
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
          <form class="forms-inline" autocomplete="off" method="post" id="AudioForm" action="" enctype="multipart/form-data">
           @csrf
           <div class="row">
                <div class="col-md-12">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Update Title <sup >*</sup></label>
                    <div class="col-sm-7">
                        <input type="text" name="title" maxlength="256"  value="{{ old('title', $profile->title) }}" placeholder="Title of Video" class="form-control"  >
                    </div>
                  </div>
                </div>
                 
              </div> 



            <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Update Video <sup>*</sup></label>
                  <div class="col-sm-6">
                    <input type="file" name="library_file" id="library_file" class="form-control" accept="video/mp4"/>

                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-9"> 
                    
                      <?php  $path = url("uploads/"); 
                              ?>
                              <?php if(!empty($profile->file_name))
                              {
                                ?>
                                       <video id="video1" class="postervideo" width="100%" height="100%" controls>
                                        <source src="{{ $profile->file_name }}" type="video/mp4"></video>  
                              <?php
                              }
                              ?>  
                                  
                  </div>
                </div>
              </div>

            </div>
           <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><!-- Tags -->Internal Note</label>
                <div class="col-sm-6">
                 
                   <textarea class="form-control" name="notes" id="exampleTextarea1" rows="4" spellcheck="false">{{ old('notes', $profile->notes) }}</textarea>
                </div>
              </div>
            </div>
          </div>
           {{--  <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Update Thumbnail Image <sup>*</sup></label>
                  <div class="col-sm-9">
                   <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept="image/*"/> 

                  </div>
                </div>
              </div>
             <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-9"> 
                    <img src="{{$profile->thumbnail}}" width="200px" height="100px">
                                
                  </div>
                </div>
              </div>
              
            </div> --}}
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
      //  required: true,
        extension: "mp4"
      }         
    },
    submitHandler: function(form){
        $('.submit').attr('disabled', 'disabled');
        $(".submit").html('Please wait..');
        form.submit();
    }
});

$('#library_file').bind('change', function() {
  var file_size = $('#library_file')[0].files[0].size;
  if(file_size>30097152) {
    swal("File size should not be greater than 10MB");
    $('#library_file').val('');
    return false;
  } 
  return true;
});
</script>
@endsection
