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
  // $(".collapse").addClass("show");
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
       <!------->
       <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                 <h4 class="card-title">Edit Pie flavor</h4>  
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
                  @if(session()->has('error'))
                  <div class="alert alert-danger fadeout">
                  {{ session()->get('error') }}
                  </div>
                  @endif

                  <form class="forms-inline" autocomplete="off" method="post" id="AudioForm" action="" enctype="multipart/form-data">
                  @csrf       
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Update Title <sup >*</sup></label>
                        <div class="col-sm-6">
                            <input type="text" name="p_name" maxlength="256"  value="{{ old('p_name', $data->p_name) }}" placeholder="Title of Image" class="form-control"  >
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  <input type="hidden" name="data_id" id="data_id" value="{{$data->id}}">
                 {{--<div class="row">
                    
                    <div class="col-md-12">
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Orientation</label>
                        <div class="col-sm-6">  
                          <select name="chroma_key_id" id="chroma_key_id" class="form-control">
                            <option value="1" @if($data->chroma_key_id == 1) selected @endif> Left  </option>
                            <option value="2" @if($data->chroma_key_id == 2) selected @endif> Right </option>
                            <option value="3" @if($data->chroma_key_id == 3) selected @endif> Main </option>
                          </select>

                        </div>
                      </div>
                    </div>
                  </div>--}}

                  <div class="row">
                    
                    <div class="col-md-12">
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Update Thumbnail</label>
                        <div class="col-sm-6">  
                             <input type="file" name="p_img" class="" id="p_img" class="form-control" accept="image/*"/>

                        </div>
                      </div>
                    </div>
                  </div>

                   <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                          @if($data->p_img)
                         <img src="{{  $data->p_img }}" id="image_upload_preview" style="background: none; height: 100%; width: 28%;" />  @endif             

                        </div>
                      </div>
                      <div class="col-sm-4"></div>
              <div class="row">
            
                <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Landscape Or portrait<sup>*</sup></label>
                    <div class="col-sm-9">
                      <select class="form-control" name="is_landscape" id="chroma_key_id">
                         <option value="">Please select</option>
                        <option value="{{old('chroma_key_id')}}1">Landscape</option>
                        <option value="{{old('chroma_key_id')}}2">Portrait</option>
                         
                      </select>
                    </div>
                  </div>
                </div>
               <div class="col-md-6">
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">upload chroma keys <sup>*</sup></label>
                    <div class="col-sm-9">
                        <input type="file" name="ChromaKeyImage[]" class="" id="ChromaKeyImage" class="form-control" accept="image/png, image/jpg, image/jpeg" multiple />
                        <!-- <span>Should be a gif*</span> -->
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
              <div style="margin-top: 20px; margin-bottom: 20px;"> <div><b>Chroma keys</b></div></div>
               <div style = "text-align: right;">
                <a href='javascript:void(0)' data-id='{{$data->id}}' class="btn btn-info btn-fill mr-2 allchroma_key_Delete">Delete chroma keys</a></div>   
                <div class="table-responsive">
              <div id="usersjtable"></div>
             </div>

   
            <script type="text/javascript">             
             $(document).ready(function () {
              var data_id = $('#data_id').val();
             // alert(data_id);
                $.ajaxSetup({
                          headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                      }
                });
                $('#usersjtable').jtable({
                        title: 'Users List',
                        paging: true, //Enable paging
                        pageSize: 10, //Set page size (default: 10)
                        sorting: true, //Enable sorting
                        defaultSorting: 'Name ASC', //Set default sorting
                        actions: {

                            listAction: "{{ route('admin.chroma_keys_list') }}/"+data_id,
                            
                        },
                        fields: {
                     /* sno: {
                            key: true,
                            create: false,
                            edit: false,
                            list: true,
                            sorting: false,                
                            title: 'S.no',
                            width: '2%'
                        },*/
                        id: {
                                title: 'ID',
                                width: '4%',
                            }, 
                        /* first_name: {
                            title: 'Name',
                            width: '10%',
                            sorting: true, //This column is not sortable!
                            display:function(data)
                            {
                               return ""+data.record.title+"  "+data.record.first_name+" "+data.record.last_name+"";
                               
                            }
                          }, */  

                      
                      /*name: {
                                title: 'Name',
                                width: '8%',
                            },*/

                       p_img: {
                            title: 'Chroma Key',
                            width: '8%',
                            sorting: false, //This column is not sortable!
                            display:function(data)
                            {
                              var p_image = data.record.chromak_keys_img;
                              return "<a title='View Image' class='btn btn-gradient-primary btn-sm' data-id='"+data.record.id+"' href='"+p_image+"' target='_blank'><i class='mdi mdi-image'></i></a>";
                                
                            }
                          
                        },  

                         chroma_key_id: {
                                title: 'Landscape/Portrait',
                                width: '10%',
                                sorting: true, //This column is not sortable!
                                display:function(data)
                                {
                                  if(data.record.chroma_key_id == 1){
                                     return "<label class='badge badge-gradient-success '>Landscape</label>";
                                    
                                    } else{
                                       return "<label class='badge badge-gradient-success'>Portrait</label>";
                                    }
                                  }
                                
                        }, 
            
                        status: {
                            title: 'Status',
                            width: '10%',
                            sorting: true, //This column is not sortable!
                            display:function(data)
                            {
                              if(data.record.status == 1){
                                 return "<label class='badge badge-gradient-success activatedchromakey' data-id='"+data.record.id+"'  data-id1='0'>Active</label>";
                                } else {
                                 return "<label class='badge badge-gradient-warning activatedchromakey' data-id='"+data.record.id+"' data-id1='1'>Inactive</label>";                              
                                }
                              }
                          },       

                     /*  Action: {
                            title: 'Action',
                            width: '10%',
                            sorting: false, //This column is not sortable!
                            display:function(data)
                            {
                               return "<a title='Delete Chroma key' class='chroma_key_Delete' data-id='"+data.record.id+"' href='javascript:void(0)'><i class='mdi mdi-delete size25px'></i></a> <a title='Edit Chroma key' href='{!! url('/admin/edit_chroma_keys'); !!}/"+data.record.id+"'><i class='mdi mdi-pencil size25px'></i></a>";
                                                              
                            }
                          },*/ 
                        }
                    });
             
                    //Load Category list from server
                    $('#usersjtable').jtable('load');
                    $('#filter').click(function (e) {
                        e.preventDefault();
                        $('#usersjtable').jtable('load', {
                            keyword: $('#keyword').val(),
                            status: $('#status').val(),
                            
                        });
                    });
             
                      $('#reset_button').click(function (e) {
                       $('#usersjtable').jtable('load');
                       $('#search')[0].reset();
                   });
              
                    
                }); 
</script> 
                   <!-- <div class="row">
            
             
                   <div class="col-md-12">
                    <div class="form-group row">
                      <label class="col-sm-4 col-form-label">Update Front - Portrait (gif) <sup>*</sup></label>
                      <div class="col-sm-6">
                          <input type="file" name="portrait_img" class="" id="portrait_img" class="form-control" accept="image/gif"/>
                         
                      </div>
                    </div>
                  </div>
                  </div> -->
                    
                  
                     <!--  <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                          @if($data->portrait_img)
                         <img src="{{  $data->portrait_img }}" id="portrait_upload_preview" style="background: none; height: 100%; width: 28%;" />  @endif             

                        </div>
                      </div> -->
                        <!-- <div class="row">
                          <div class="col-md-12">
                            <div class="form-group row">
                              <label class="col-sm-4 col-form-label">Update Front - Landscape (gif) <sup>*</sup></label>
                              <div class="col-sm-6">
                                  <input type="file" name="landscape_img" class="" id="landscape_img" class="form-control" accept="image/gif"/>
                                  
                              </div>
                            </div>
                          </div>
                          <div class="col-md-8">
                            
                          </div>
                        </div> -->
                  <!--   <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                          @if($data->landscape_img)
                         <img src="{{  $data->landscape_img }}" id="landscape_upload_preview" style="background: none; height: 100%; width: 28%;" />  @endif             

                        </div>
                      </div> -->
                    <!-- <div class="col-md-6">
                      <div class="form-group row">
                        <label class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">  
                       
                        </div>
                      </div>
                    </div> -->
                 

                   
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
        p_name: {
          // required: true,
           maxlength: 255
        },  

      portrait_img: {
       // required: true,
        extension: "gif"
      }, 
      landscape_img: {
       // required: true,
        extension: "gif"
      },
      p_img: {
       // required: true,
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
$('#landscape_img').bind('change', function() {
  var file_size = $('#landscape_img')[0].files[0].size;
  if(file_size>102428800) {
    swal("File size should not be greater than 5MB");
    $('#landscape_img').val('');
    return false;
  } 
  return true;
});
$('#portrait_img').bind('change', function() {
  var file_size = $('#portrait_img')[0].files[0].size;
  if(file_size>102428800) {
    swal("File size should not be greater than 5MB");
    $('#portrait_img').val('');
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

$("#p_img").change(function () {
    readURL(this);
});


</script>


@endsection
