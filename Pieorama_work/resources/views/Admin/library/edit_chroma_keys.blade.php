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
   $(".chroma_keyslink").addClass("active");
   $(".collapse").addClass("show");
});
</script>
<div class="content-wrapper">
  <div class="page-header">
      <h3 class="page-title">  Library Management </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
           <a href="{!! url('/admin/chroma_keys'); !!}" class="btn btn-info  btn-sm">Back</a>  
          </li>
        </ol>
      </nav>
    </div>
          <div class="row">
       <!------->
       <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                 <h4 class="card-title">Edit Chroma key</h4>  
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
                  <!-- <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Update Title <sup >*</sup></label>
                        <div class="col-sm-9">
                            <input type="text" name="name" maxlength="256"  value="{{ old('name', $data->name) }}" placeholder="Name" class="form-control"  >
                        </div>
                      </div>
                    </div>
                    
                  </div> -->

                    <div class="row">
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">pie flavors <sup >*</sup></label>
                        <div class="col-sm-9">
                          <select name="pieflavor_id" id="pieflavor_id" class="form-control">
                            @foreach($pieflavors as $f)
                              <option value="{{$f->id}}" @if($f->id == $data->pieflavor_id) selected @endif> {{$f->p_name}} </option>
                             
                            @endforeach
                          </select>
                        </div>
                      </div>
                    </div>
                    
                  </div>
                   <div class="row">
                    
                    <div class="col-md-7">
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Landscape Or Portrait</label>
                        <div class="col-sm-8">  
                          <select class="form-control" name="is_landscape" id="chroma_key_id">
                          <option value="1" @if($data->chroma_key_id == 1) selected @endif>Landscape</option>
                          <option value="2" @if($data->chroma_key_id == 2) selected @endif>Portrait</option>
                          </select>             
                        </div>
                      </div>
                    </div>
                  </div>
                                  
                  <div class="row">
                    
                    <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Update Image</label>
                        <div class="col-sm-9">  
                          <input type="file" name="ChromaKeyImage" class="" id="ChromaKeyImage" class="form-control" accept="image/png, image/jpg, image/jpeg"/> 
                         <!--  <span>Should be a gif*</span>   -->          
                        </div>
                      </div>
                    </div>
                  </div>
                    
                  
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                          @if($data->chromak_keys_img)
                         <img src="{{  $data->chromak_keys_img }}" id="image_upload_preview" style="background: none; height: 100%; width: 28%;" />  @endif             

                        </div>
                      </div>
                   
                    <!-- <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">  
                       
                        </div>
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
            
       <!----->           
            
          </div>
       
<script src="{{ asset('js/admin/js/jquery.validate.js')}}"></script>
<script src="{{ asset('js/admin/js/additional-methods.min.js')}}"></script>
<script>
$("#AudioForm").validate({
    rules: {
         /*name: {
           required: true,
           maxlength: 255
        }, */ 

      ChromaKeyImage: {
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

$('#ChromaKeyImage').bind('change', function() {
  var file_size = $('#ChromaKeyImage')[0].files[0].size;
  if(file_size>102428800) {
    swal("File size should not be greater than 5MB");
    $('#ChromaKeyImage').val('');
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

$("#ChromaKeyImage").change(function () {
    readURL(this);
});
</script>


@endsection
