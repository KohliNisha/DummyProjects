@extends('layouts.Admin.appadmin')
@section('content')
<style type="text/css">
 sup, .error {color: red;}
 #library_file-error {display: block !important;
 padding-top: 5px !important;
 }
 select.form-control {
    color: #3a3737;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
   $(".Videoslink").addClass("active");
});
</script>
<?php //echo $profile->profiled_pieogram; die;?>
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title"> Pieogram Management </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
		  
           <a href="{!! url('/admin/pieograms'); !!}" class="btn btn-info  btn-sm">Back</a>  
          </li>
		  
		  
        </ol>
      </nav>
    </div>

    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">         
          <h4 class="card-title">Edit Pieogram</h4>  
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
             @if(session()->has('error'))
            <div class="alert alert-warning">
            {{ session()->get('error') }}
            </div>
            @endif       
          <form class="forms-sample"  autocomplete="off" id="PieogramForm" method="post" action="" enctype="multipart/form-data">
           @csrf
            

 
          <div class="row">
            <div class="col-md-12">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Pieogram Title <sup >*</sup></label>
                <div class="col-sm-9">
                    <input type="text" name="video_title" maxlength="256" value="{{ old('video_title', $profile->video_title) }}" placeholder="Video Title" class="form-control" value="">
                </div>
              </div>
            </div>
         </div>
          <div class="row"> 
            <div class="col-md-12">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Pieogram Description </label>
                <div class="col-sm-9">
                     <textarea class="form-control" name="video_description" id="editor1" rows="4" spellcheck="false">{{ old('video_description', $profile->video_description) }}</textarea>
                </div>
              </div>
            </div>
          </div>

           <div class="row">
            <div class="col-md-12">
             
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Update Video</label>
                        <div class="col-sm-6">     
                          <input type="file" name="video_file" id="video_file" class="form-control" accept="video/mp4"  />           
                        </div>
                      </div>
                      <div class="form-group row">
                       
                        <div class="col-sm-9">     
                           <?php  $path = url("uploads/"); 
                              ?>
                              <?php if(!empty($profile->video_file_path))
                              {
                                ?>
                                        <video id="video1" class="postervideo" width="70%" height="100%" controls>
                                        <source src="{{ $profile->video_file_path }}" type="video/mp4"></video>    
                              <?php
                              }
                              ?>       
                        </div>
                      </div>
                       
                       <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Update Original video</label>
                        <div class="col-sm-6">     
                          <input type="file" name="original_video" id="original_video" class="form-control" accept="video/mp4"  />           
                        </div>
                      </div>
                       <div class="form-group row">
                       
                        <div class="col-sm-9">     
                           
                      <?php if(!empty($profile->original_video_path))
                      {
                        ?>
                                <video id="video1" class="postervideo" width="70%" height="100%" controls>
                                <source src="{{ $profile->original_video_path }}" type="video/mp4"></video>    
                      <?php
                      }
                      ?>        
                        </div>
                      </div>

                       <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Update video Gif</label>
                        <div class="col-sm-6">     
                          <input type="file" name="video_animated_file_path" id="video_animated_file_path" class="form-control" accept="image/gif" />           
                        </div>
                      </div>
                       <div class="form-group row">
                       
                        <div class="col-sm-9">     
                           
                      <?php if(!empty($profile->video_animated_file_path))

                      {
                        ?>
                                <img id="video1" class="postervideo" src="{{ $profile->video_animated_file_path }}" width="50%" height="100%">
                                 
                      <?php
                      }
                      ?>        
                        </div>
                      </div>


                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Update smaller version of GIF</label>
                        <div class="col-sm-6">     
                          <input type="file" name="small_gif" id="small_gif" class="form-control" accept="image/gif" />           
                        </div>
                      </div>
                       <div class="form-group row">
                       
                        <div class="col-sm-9">     
                           
                      <?php if(!empty($profile->small_gif))

                      {
                        ?>
                                <img id="video1" class="postervideo" src="{{ $profile->small_gif }}" width="50%" height="100%">
                                 
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
                 <!--    <textarea class="form-control" name="video_description" id="exampleTextarea1" rows="4" spellcheck="false">{{ old('video_description', $profile->video_description) }}</textarea> -->
                   <textarea class="form-control" name="comment_note" id="exampleTextarea1" rows="4" spellcheck="false">{{ old('comment_note', $profile->comment_note) }}</textarea>
                </div>
              </div>
            </div>
          </div>
			<div class="row">
				<?php
				$tagList='';
				$final_tag='';
				if(!empty($tagArray))
				{
					foreach($tagArray as $row)
					{
						$tagList .=$row.',';		
					}	
				
					$final_tag=substr($tagList,0,-1);
				
				}
				?>
				
				
				<div class="col-md-12">
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Pieogram Tags <sup >*</sup></label>
					<div class="col-sm-6">
						<input type="text" name="video_tags" maxlength="256" placeholder="Video Tags Seprated by comma(,)" class="form-control" value="<?php echo $final_tag; ?>"> 
					</div> 
				  </div>
				</div>
				</div>
        <div class="row">
				<div class="col-md-12">
				  <div class="form-group row">
					<label class="col-sm-3 col-form-label">Pieogram Thumbnail</label>
					<div class="col-sm-6">
						<input type="file" name="thumb_file" id="thumb_file" class="form-control" /> 
						<?php  $path = url("uploads/"); 
						
						if($profile->video_thumbnail_file_path!='')
						{
							$thumb=$profile->video_thumbnail_file_path;
							?>
								<img src="<?php echo $thumb; ?>" style="width:300px;">
							
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
                <label class="col-sm-3 col-form-label">Pieogram Large Thumbnail</label>
                <div class="col-sm-6">
                  <input type="file" name="video_large_thumbnail_file_path" id="video_large_thumbnail_file_path" class="form-control" /> 
                  <?php  $path = url("uploads/"); 
                  
                  if($profile->video_large_thumbnail_file_path!='')
                  {
                    $thumblarge=$profile->video_large_thumbnail_file_path;
                    
                    ?>
                      <img src="<?php echo $thumblarge; ?>" style="width:300px;">
                   
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
                  <label class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-9">
                  <!--   <input type="checkbox" name="profiled_pieogram" id="profiled_pieogram" class="form-control"> -->

				 
                   
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label"></label>
                  <div class="col-sm-9">
				  	           
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <div class="form-check">
                    <label class="form-check-label">
                     Profiled Pieogram  <input type="checkbox" class="form-check-input" name="profiled_pieogram" id="profiled_pieogram" <?php if($profile->profiled_pieogram==1){ ?> checked="checked" <?php }  ?> >  <i class="input-helper"></i></label>
                  </div>                            
                </div>
              </div> 
              <div class="col-md-6">
                <div class="form-group">
                  <div class="form-check">
                    <label class="form-check-label">
                     Available to non-authenticated users 
                    <input type="checkbox" class="form-check-input" name="gif_corner" id="gif_corner" <?php if($profile->gif_corner==1){ ?> checked="checked" <?php }  ?> > 
                       <i class="input-helper"></i></label>
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
         video_title: {
           required: true,
           maxlength: 255
        }, 
        video_description: {
          maxlength: 5555
        }, 
		
      video_file: {
      //  required: true,
        extension: "mp4"
      },   
      original_video: {
       // required: true,
        extension: "mp4"
      },
      video_animated_file_path: {
       // required: true,
        extension: "gif"
      },
      small_gif: {
       // required: true,
        extension: "gif"
      },
       thumb_file: {
        //required: true,
        extension: "jpeg,jpg,png"
      },
       video_large_thumbnail_file_path: {
        //required: true,
        extension: "jpeg,jpg,png"
      },         
	  
        comment_note: {
          maxlength: 5555
        }, 
        pie_channel_id: {
           required: true,
        }, 
          
          
    },
    submitHandler: function(form){
        $('.submit').attr('disabled', 'disabled');
        $(".submit").html('Please wait..');
        form.submit();
    }
});
$('#video_file').bind('change', function() {
  var file_size = $('#video_file')[0].files[0].size;
  if(file_size>102428800) {
    swal("File size should not be greater than 100MB");
    $('#video_file').val('');
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

$("#logo_file").change(function () {
    readURL(this);
});
</script>
@endsection
