@extends('layouts.Admin.appadmin')
@section('content')
<style>
.userimage{
/*width: 192px !important;*/
border-radius: 10px;
max-height: 150px;
}
.fontweightheigh {
  font-weight: 700;
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
             
                
                  <div class="row">
                    <div class="col-md-6 fontweightheigh">Pieogram Title</div>
                    <div class="col-md-6">{{$pieoramaDetails->video_title}}</div>
                  </div>
                  <br>

                  <div class="row">
                    <div class="col-md-6 fontweightheigh">Pieogram Video</div>
                    <div class="col-md-6">
					  <?php  $path = url("uploads/"); 
					?>
					 @if($pieoramaDetails->video_file_path !='') 
					<a class="watch btn btn-gradient-primary btn-sm" href="{{$pieoramaDetails->video_file_path }}" data-lity="" data-lity=""><i class="fa fa-play" aria-hidden="true"></i> <i class='mdi mdi-video'></i></a>
					@else 
                      N/A
                      @endif
                      </div>
                  </div>
                  <br>  

                  <div class="row">
                    <div class="col-md-6 fontweightheigh">Pieogram Description  </div>
                    <div class="col-md-6">
                      @if($pieoramaDetails->video_description !='') {{$pieoramaDetails->video_description}}
                      @else 
                      N/A
                      @endif
                    </div>
                  </div>
                  <br>

                   <div class="row">
                    <div class="col-md-6 fontweightheigh">Internal Note  </div>
                    <div class="col-md-6">
                      @if($pieoramaDetails->video_description !='') 
                      {{$pieoramaDetails->comment_note}}
                     @else 
                      N/A
                    @endif
                  </div>
                  </div>
                  <br>
  
                  <div class="row">
                  <div class="col-md-6 fontweightheigh">Public Available</div>
                  <div class="col-md-6">
                  @if($pieoramaDetails->public_available =='1')   
                                 Yes    @else      No  
                      @endif
                  </div>
                </div>
                <br>

                 <div class="row">
                  <div class="col-md-6 fontweightheigh">Is Publish</div>
                  <div class="col-md-6">
                  @if($pieoramaDetails->is_publish =='1')   
                                 Published    @else      Unpublished  
                      @endif
                  </div>
                </div>
                <br>


                  <div class="row">
                  <div class="col-md-6 fontweightheigh">Is Searchable</div>
                  <div class="col-md-6">
                  @if($pieoramaDetails->public_available =='1')   
                                 Yes    @else      No  
                      @endif
                  </div>
                </div>
                <br>

                  <div class="row">
                    <div class="col-md-6 fontweightheigh">Pieogram Status</div>
                    <div class="col-md-6">
                    @if($pieoramaDetails->status =='1')    
                              <label class='badge badge-gradient-success activatedAccountVideo' data-id="{{$pieoramaDetails->id}}"  data-id1='1'>Active</label>     
                        @else
                            <label class='badge badge-gradient-warning activatedAccountVideo' data-id="{{$pieoramaDetails->id}}" data-id1='0'>Inactive</label>       
                        @endif
                    </div>
                  </div>
                   <br>


                   <div class="row">
                    <div class="col-md-6 fontweightheigh">Published Date</div>
                    <div class="col-md-6">
                      @if($pieoramaDetails->public_available !='')
                      {{$pieoramaDetails->publish_date}} 
                      @else N/A
                      @endif
                       </div>
                  </div>
                  <br>


                  <div class="row">
                    <div class="col-md-6 fontweightheigh">Pieogram Last Updated  Date</div>
                    <div class="col-md-6">{{$pieoramaDetails->updated_at->format('Y/m/d')}}  </div>
                  </div>
                    <br>
                    
                  <div class="row">
                    <div class="col-md-6 fontweightheigh">Pieogram Creation Date</div>
                    <div class="col-md-6">{{$pieoramaDetails->created_at->format('Y/m/d')}}  </div>
                  </div>

                  </div>

                </div>
              </div>
            </div>
          
@endsection
