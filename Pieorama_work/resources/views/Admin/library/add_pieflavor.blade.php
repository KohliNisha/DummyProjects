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
   //$(".librarylink").addClass("active");
   $(".pieflavorlink").addClass("active");
   //$(".collapse").addClass("show");
});
</script>
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">  Library Management </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
           <a href="{!! url('/admin/pie_flavor'); !!}" class="btn btn-info  btn-sm">Back</a>  
          </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">         
          <h4 class="card-title">Add Pie flavor</h4>  
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
          <form class="forms-sample"  autocomplete="off" id="AudioForm" method="post" action="{{ route('admin.add-pieflavor') }}" enctype="multipart/form-data">
           @csrf
          <div class="row">
            <div class="col-md-8">
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Title <sup >*</sup></label>
                <div class="col-sm-6">
                    <input type="text" name="p_name" maxlength="256" value="{{ old('p_name') }}" placeholder="Title of pie flavor" class="form-control" value="">
                </div>
              </div>
            </div>
           
          </div>
            {{--<div class="row">
                                     <div class="col-md-8">
                                          <div class="form-group row">
                                              <label class="col-sm-4 col-form-label">Orientation<sup>*</sup></label>
                                              <div class="col-sm-9">
                                                  <select class="form-control" name="chroma_key_id" id="chroma_key_id">
                                                      <option value="{{ old('chroma_key_id') }}1" selected>left</option>
                                                      <option value="{{ old('chroma_key_id') }}2">right</option>
                                                      <option value="{{ old('chroma_key_id') }}3">Main</option>
                                                  </select>
                                              </div>
                                          </div>
                                      </div>
                                  </div>--}}
         <div class="row">
            
             
            <div class="col-md-8">
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Thumbnail <sup>*</sup></label>
                <div class="col-sm-6">
                    <input type="file" name="p_img" class="" id="p_img" class="form-control" accept="image/*"/>
                   
                </div>
              </div>
            </div>
            
           
          </div>


          <!-- <div class="row">
            
             
            <div class="col-md-8">
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Front - Portrait (gif) <sup>*</sup></label>
                <div class="col-sm-6">
                    <input type="file" name="portrait_img" class="" id="portrait_img" class="form-control" accept="image/gif"/>
                   
                </div>
              </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-8">
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Front - Landscape (gif) <sup>*</sup></label>
                <div class="col-sm-6">
                    <input type="file" name="landscape_img" class="" id="landscape_img" class="form-control" accept="image/gif"/>
                    
                </div>
              </div>
            </div>
            <div class="col-md-8">
              
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
<script>
$("#AudioForm").validate({
    rules: {
         p_name: {
           required: true,
           maxlength: 255
        },  

      portrait_img: {
        required: true,
        extension: "gif"
      }, 
      landscape_img: {
        required: true,
        extension: "gif"
      },
      p_img: {
        required: true,
        extension: "jpeg,jpg,png"
      }        
    },
    submitHandler: function(form){
        $('.submit').attr('disabled', 'disabled');
        $(".submit").html('Please wait..');
        form.submit();
    }
});

$('#p_img').bind('change', function() {
  var file_size = $('#p_img')[0].files[0].size;
  if(file_size>102428800) {
    swal("File size should not be greater than 5MB");
    $('#p_img').val('');
    return false;
  } 
  return true;
});


</script>

@endsection
