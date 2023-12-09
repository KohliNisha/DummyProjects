@extends('layouts.Admin.appadmin')
@section('content')
<style type="text/css">
 sup, .error {color: red;}
 #library_file-error {display: block !important;
 padding-top: 5px !important;
 }
</style>

<div class="content-wrapper">
  <div class="page-header">
      <h3 class="page-title"> Add Page </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
           <a href="{!! url('/admin/pages'); !!}" class="btn btn-info  btn-sm">Back</a>  
          </li> 
        </ol>
      </nav>
    </div>
          <div class="row">
       <!------->
       <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                
				 @if(session()->has('message'))
                  <div class="alert alert-success alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  {{ session()->get('message') }}
                  </div> 
                  @endif
				
				<h4 class="card-title">Add Static Page</h4> 

                  <form class="forms-inline" autocomplete="off" method="post" id="AudioForm" action="" enctype="multipart/form-data">
                  @csrf 
              
					<div class="row">
						<div class="col-md-12">
						  <div class="form-group row">
							<label class="col-sm-3 col-form-label">Page Title <sup >*</sup></label>
							<div class="col-sm-9">
								<input type="text" name="name" maxlength="256" placeholder="Page Title" class="form-control" value=""  >
							</div>
						  </div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
						  <div class="form-group row">
							<label class="col-sm-3 col-form-label">Page Description</label>
							 <div class="col-sm-9">
								
								<textarea id="editor1" name="description" style="height: 50%;">
								
								</textarea> 
							</div>    
						  </div>
						</div> 
                    </div>
                  
                  <br/>
                    <div class="form-group row">       
                       <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                       <button type="submit" class="btn btn-primary mr-2 submit">Submit</button>
                      
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
       
<!-- <script src="<?php echo url('/flora'); ?>/js/ckeditor.js"></script>  -->

<!-- <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script> -->

<!-- <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
 -->
<script>
	/*ClassicEditor
		.create( document.querySelector( '#editor' ), {
			// toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
		} )
		.then( editor => {
			window.editor = editor;
		} )
		.catch( err => {
			console.error( err.stack );
		} );*/

 // CKEDITOR.replace( 'description' );
</script>

<script src="{{ asset('js/admin/js/jquery.validate.js')}}"></script>
<script src="{{ asset('js/admin/js/additional-methods.min.js')}}"></script>
<script>
$("#AudioForm").validate({
    rules: {
        page_title: {
           required: true
        }
    },
    submitHandler: function(form){
        $('.submit').attr('disabled', 'disabled');
        $(".submit").html('Please wait..');
        form.submit();
    }
});
 

</script>

  

@endsection
