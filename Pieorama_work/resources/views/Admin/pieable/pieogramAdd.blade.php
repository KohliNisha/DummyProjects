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
   $(".Pieablelink").addClass("active");
  
});
</script>
<div class="content-wrapper">
    <div class="page-header">
       <h3 class="page-title"> Pieable moments </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
         <li class="breadcrumb-item">
		  
           <a href="{!! url('/admin/pieable-moments'); !!}" class="btn btn-info  btn-sm">Back</a>  
          </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">         
          <h4 class="card-title">Add Pie</h4>  
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
          <form class="forms-sample"  autocomplete="off" id="PieogramForm" method="post" action="{{ route('admin.addpieable')}}" enctype="multipart/form-data">
           @csrf
		          
		  
		    <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Pie Title <sup >*</sup></label>
                <div class="col-sm-9">
                    <input type="text" name="video_title" maxlength="256" value="{{ old('video_title') }} " placeholder="Video Title" class="form-control" value="">
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Pie Description <sup >*</sup></label>
                <div class="col-sm-9">
                     <textarea class="form-control" name="video_description" id="exampleTextarea1" rows="4" spellcheck="false">{{ old('video_description') }}</textarea>
                </div>
              </div>
            </div>
          </div>
		  
		  
           <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Upload Video</label>
                <div class="col-sm-9">
                   <div class="form-group row">
                       <div class="col-sm-9">     
                          <input type="file" name="video_file" id="video_file" class="form-control" accept="video/mp4" />           
                        </div>
                    </div>
                 
                </div>
              </div>
            </div>
             <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Upload Source Video</label>
                <div class="col-sm-9">
                   <div class="form-group row">
                       <div class="col-sm-9">     
                          <input type="file" name="original_video" id="original_video" class="form-control" accept="video/mp4" />           
                        </div>
                    </div>
                 
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"><!-- Tags -->Internal Note</label>
                <div class="col-sm-9">
                
                   <textarea class="form-control" name="comment_note" id="exampleTextarea12" rows="4" spellcheck="false">{{ old('comment_note') }}</textarea>
                </div>
              </div>
            </div>
          </div>
		  <div class="row">
            <div class="col-md-12"> 
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Thumb image</label>
                <div class="col-sm-9"> 
                   <div class="form-group row">
                       <div class="col-sm-9">     
                          <input type="file" name="thumb_file" id="thumb_file" class="form-control" accept="image/*"/>           
                        </div>
                    </div>
                 
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
$("#PieogramForm").validate({
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
  if(file_size>10097152) {
    swal("File size should not be greater than 10MB");
    $('#library_file').val('');
    return false;
  } 
  return true;
});
</script>
@endsection
  