@extends('layouts.Admin.appadmin')
<style type="text/css">
span.select2-container{
  width: 573px!important;
 }
</style>
@section('content')
<style type="text/css">
 sup, .error {color: red;}
 #library_file-error {display: block !important;
 padding-top: 5px !important;
 }
</style>
<script type="text/javascript">
$(document).ready(function(){
   $(".Channelslink").addClass("active");
});
</script>
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">  Channel Management </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
           <a href="{!! url('/admin/channels'); !!}" class="btn btn-info  btn-sm">Back</a>  
          </li>
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">         
          <h4 class="card-title">Edit Channel</h4>  
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
          <form class="forms-sample"  autocomplete="off" id="ChannelForm" method="post" action="" enctype="multipart/form-data">
           @csrf
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Channel Name <sup >*</sup></label>
                <div class="col-sm-8">
                    <input type="text" name="channel_title" maxlength="256" value="{{ old('channel_title', $profile->channel_title) }}" placeholder="Channel Name" class="form-control" value="">
                </div>
              </div>
            </div>
           
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Channel tags <sup >*</sup></label>
                <div class="col-sm-8">
                  <div style= "width:150px; margin: 3px 3px 5px 8px;">
                   
                     <select class="js-example-basic-multiple" name="states[]" id= "states" multiple="multiple">
                          @if(isset($channeltags))
                              @foreach($channeltags as $tag)
                              <option <?php if($tag->id) { if (in_array($tag->id, $profile->ids)) { echo "selected"; } }?> value="{{ $tag->id }}">{{ $tag->tag_text }}</option> 
                               <!--  <option value="{{$tag->id}}" {{$tag->id == $profile->ids ? 'selected="selected"' : '' }}>{{$tag->tag_text}}</option> -->
                                 
                              @endforeach
                          @endif
                      </select>

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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
  $('.js-example-basic-multiple').select2();
});
$("#ChannelForm").validate({
    rules: {
         channel_title: {
           required: true,
           maxlength: 255
        }, 
        states: {
           required: true,
           maxlength: 555
        }, 
          
    },
    submitHandler: function(form){
        $('.submit').attr('disabled', 'disabled');
        $(".submit").html('Please wait..');
        form.submit();
    }
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

$("#logo_file").change(function () {
    readURL(this);
});
</script>
@endsection
