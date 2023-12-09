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
  var data = '{{Request::segment(2)}}';
  
  if(data == 'edit-audience_reaction'){
    $(".librarylink").addClass("active");
    $(".audience_reactionlink").addClass("active");
  }else if(data == 'edit-trending_tags'){
    $(".maintagslink").addClass("active");
    $(".trending_taglink").addClass("active");
  }
   $(".collapse").addClass("show");
});
</script>
<div class="content-wrapper">
  <div class="page-header">
      <h3 class="page-title">  Library Management </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            @if(Request::segment(2) == 'edit-audience_reaction')
                <a href="{!! url('/admin/audience_reaction'); !!}" class="btn btn-info  btn-sm">Back</a> 
            @else
                 <a href="{!! url('/admin/trending_tags'); !!}" class="btn btn-info  btn-sm">Back</a> 
            @endif
            
          </li>
        </ol>
      </nav>
    </div>
          <div class="row">
       <!------->
       <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                   @if(Request::segment(2) == 'edit-audience_reaction')
                      <h4 class="card-title">Edit Audience Reaction</h4> 
                  @else
                       <h4 class="card-title">Edit Trending Tag</h4> 
                  @endif
                 
                  <hr/><br/> 
                  @if ($errors->any())
                  <div class="alert alert-danger fadeout">
                  @foreach ($errors->all() as $error)
                  {{$error}}
                  @endforeach
                  </div>
                  @endif
                  @if(session()->has('message'))
                  <div class="alert alert-success fadeout">
                  {{ session()->get('message') }}
                  </div>
                  @endif

                  <form class="forms-inline" autocomplete="off" method="post" id="AudioForm" action="" enctype="multipart/form-data">
                  @csrf       
                  <div class="row">
                    <div class="col-md-9">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Update Title <sup >*</sup></label>
                        <div class="col-sm-6">
                            <input type="text" name="name" maxlength="256"  value="{{ old('name', $data->name) }}" placeholder="Title of Image" class="form-control"  >
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  @if(Request::segment(2) == 'edit-audience_reaction')
                   <div class="row">
                    
                    <div class="col-md-7">
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Landscape Or Portrait</label>
                        <div class="col-sm-8">  
                          <select class="form-control" name="shape" id="shape_id">
                          <option value="1" @if($data->shape_id == 1) selected @endif>Landscape</option>
                          <option value="2" @if($data->shape_id == 2) selected @endif>Portrait</option>
                          </select>             
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    
                    <div class="col-md-7">
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Update Audience Reaction</label>
                        <div class="col-sm-8">  
                          <input type="file" name="url" class="" id="url" class="form-control" />             
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group row">
                        <label class="col-sm-4 col-form-label"></label>
                        <div class="col-sm-4">
                           @if(!empty($data->url))
                          <video id="video1" class="postervideo" width="60%" height="70%" controls style="background: none;">
                          <source src="{{ $data->url }}" type="video/mp4"></video>    
                          @endif
                        </div>
                      </div>
                  
                   @endif
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
            
       <!----->           
            
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
        extension: "jpeg,jpg,png"
      }         
    },
    submitHandler: function(form){
        $('.submit').attr('disabled', 'disabled');
        $(".submit").html('Please wait..');
        form.submit();
    }
});

$('#url').bind('change', function() {
  var file_size = $('#url')[0].files[0].size;
  if(file_size>102428800) {
    swal("File size should not be greater than 5MB");
    $('#url').val('');
    return false;
  } 
  return true;
});



function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image_upload_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#url").change(function () {
    readURL(this);
});
</script>


@endsection
