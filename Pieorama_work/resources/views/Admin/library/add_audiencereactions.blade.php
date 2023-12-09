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
   
    if(data == 'add-audiencereactions'){
       $(".librarylink").addClass("active");
       $(".audience_reactionlink").addClass("active");
    }else if(data == 'add_trending_tags'){
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
             @if(Request::segment(2) == 'add-audiencereactions')
            <a href="{!! url('/admin/audience_reaction'); !!}" class="btn btn-info  btn-sm">Back</a>
            @else
            <a href="{!! url('/admin/trending_tags'); !!}" class="btn btn-info  btn-sm">Back</a>
            @endif  
          </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body"> 
          @if(Request::segment(2) == 'add-audiencereactions')
           <h4 class="card-title">Add Audience Reaction</h4>
            @else
           <h4 class="card-title">Add Trending tag</h4>
            @endif          
            
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
          <form class="forms-sample"  autocomplete="off" id="AudioForm" method="post" action="{{ route('admin.add-audiencereactions') }}" enctype="multipart/form-data">
           @csrf
            @if(Request::segment(2) == 'add-audiencereactions')
           <input type="hidden" name="type" id="type" value="1">
           @elseif(Request::segment(2) == 'add_trending_tags')
           <input type="hidden" name="type" id="type" value="2">
           @endif
          <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Title <sup >*</sup></label>
                <div class="col-sm-9">
                    <input type="text" name="name" maxlength="256" value="{{ old('name') }}" placeholder="Title" class="form-control" value="">
                </div>
              </div>
            </div>
           
          </div>
          @if(Request::segment(2) != 'add_trending_tags')
           <div class="row">
            
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Landscape Or portrait<sup>*</sup></label>
                <div class="col-sm-9">
                  <select class="form-control" name="shape" id="shape_id">
                    <option value="{{old('shape_id')}}1" selected>Landscape</option>
                    <option value="{{old('shape_id')}}2">Portrait</option>
                     
                  </select>
                </div>
              </div>
            </div>
           
          </div>
          <div class="row">
            
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Audience Reaction <sup>*</sup></label>
                <div class="col-sm-9">
                    <input type="file" name="url" class="" id="url" class="form-control" />
                </div>
              </div>
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

      url: {
        required: true,
        extension: "mp4"
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


</script>

@endsection
