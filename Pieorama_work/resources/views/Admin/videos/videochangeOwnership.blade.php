@extends('layouts.Admin.appadmin')
@section('content')
<style>
.userimage{
/*width: 192px !important;*/
border-radius: 10px;
max-height: 150px;
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
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
      Pieogram Details
      </h3>
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
                  <h4 class="card-title"></h4>
                <div class="pull-right">
                </div>             
                  <div class="col-md-12 col-lg-12">
                  <div class="row">
                    <div class="col-md-6">Pieogram Title</div>
                    <div class="col-md-6">{{$pieoramaDetails->video_title}}</div>
                  </div>
                  <br>

                  
                  <br> 
                  </div>
                </div>
              </div>
            </div>
          </div>



    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">         
          <h4 class="card-title">Change Ownership of Pieogram</h4>  
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
          <form class="forms-sample"  autocomplete="off" id="PieogramForm" method="post" action="" enctype="multipart/form-data">
           @csrf
           <div class="row">
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Assign To<sup>*</sup></label>
                <div class="col-sm-9">
                  <?php
                  //print_r($UserDetailsDetails); die;
                     if ($UserDetailsDetails->count()) { ?>

                      <select class="form-control" name="created_by" id="exampleFormControlSelect2">
                      <?php                     
                      $selected = '';
                      foreach ($UserDetailsDetails as $key => $userVal) {
                           if($userVal->id == $pieoramaDetails->created_by ){
                             $selected = "selected";
                           }
                           echo "<option value='".$userVal->id."' $selected >$userVal->first_name  $userVal->last_name</option>";
                            $selected = '';
                       } ?>                     
                     </select>
         
                     <?php } else {
                       echo "No user found.";
                     } 
                    ?>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label"></label>
                <div class="col-sm-9">        
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





@endsection
