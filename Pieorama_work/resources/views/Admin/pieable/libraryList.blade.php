@extends('layouts.Admin.appadmin')
@section('content')
<style type="text/css">
  div.jtable-main-container {
    font-family: "ubuntu-regular", sans-serif;
    font-size: 14px;}
   .clearfix { clear: both; height: 10px;  } 
   .positionright { float: right !important;  }
   .form-control {
    border: 1px solid #cdcfd6;
    margin: 5px;
    color: #3a3737;
}
select.form-control{
  border: 1px solid #cdcfd6;
  margin: 5px;
  color: #3a3737;

}
div.jtable-main-container div.jtable-title {
      background: linear-gradient(to bottom, #a6a9ad 0%, #a7b4c1 100%);
}  
.centertext{text-align: center;}  
div.jtable-main-container > table.jtable > tbody > tr.jtable-data-row > td {
    text-align: center;
} 
.btn-outline-primary {padding: 5px;} 
</style>
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
      Pieable moments
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
           <a href="{!! url('/admin/add-pieable'); !!}" class="btn btn-info  btn-sm">Add New</a>  
          </li>
        </ol>
      </nav>
    </div>
 <a  style="display:none;" class="watch" href="http://smartzitsolutions.com/pieorama/public/uploads/Sample320.mp4" data-lity=""><i class="fa fa-play" aria-hidden="true"></i> Watch Video</a>   
 <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"></h4>
                  
                @if(session()->has('message'))
                  <div class="alert alert-success alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  {{ session()->get('message') }}
                  </div>
                  @endif
                <div class="pull-right"></div>


             <div class="positionright">
             <form class="form-inline" id="search" onSubmit="return false">
                <div class="form-group">
                    <input type="text" class="form-control" id="keyword" placeholder="Keyword">
                </div>
              <div class="form-group"> 
                <select id="status" class="form-control mr-2">
                        <option value="">--Filter Account Type--</option>
                        <option value="0">Inactive </option>
                        <option value="1">Active </option>
                 </select>
                 </div> 
                  &nbsp; &nbsp;
                <div class="form-group">
                    <button type="submit" id="filter" class="btn btn-info btn-fill mr-2">Filter</button>
                    <button id="reset_button" class="btn btn-info btn-fill mr-2">Reset</button>
                </div>
            </form>
            </div>
            <div class="clearfix"></div>
            <hr/>

             <div class="table-responsive">
              <div id="usersjtable"></div>
             </div>
            <script type="text/javascript">    

      function show_video(id)
      {
       // alert(id);
        var val=$('.video_'+id).attr('video_url');  
        //alert(val);
        $('.watch').attr('href',val); 
        $('.watch').trigger('click');
         
      } 
      
             $(document).ready(function () { 
                $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                      }
                });
                $('#usersjtable').jtable({
                        title: 'Library List',
                        paging: true, //Enable paging
                        pageSize: 10, //Set page size (default: 10)
                        sorting: true, //Enable sorting
                        defaultSorting: 'Name DESC', //Set default sorting
                        actions: {
                            listAction: "{{ route('admin.videoajaxpie') }}",
                        },
                        fields: {
                      /*sno: { 
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
                                width: '5%',
                            }, 
                        title: {
                                title: 'Pie Title',
                                width: '15%',
                            },

                         piable_description: {
                                title: 'Pie Description',
                                width: '15%',
                            },

                         used_no: {
                                title: 'No. of used',
                                width: '15%',
                                sorting: false,
                            },    
         
                     /* created_by: {
                            title: 'Created By',
                            width: '15%',
                            sorting: false, //This column is not sortable!
                            display:function(data)
                            {
                                 
                             return "<a title='View Pie Created User' href='{!! url('/admin/userdetails'); !!}/"+data.record.created_by+"' target='_blank'> "+data.record.created_by+"  </a>";
                               
                            }
                          
                        }, */
                       created_at: { 
                                title: 'Created On',
                                width: '10%',
                                
                            },
                      file_name: {
                            title: 'Pie Video',
                            width: '10%',
                            sorting: false, //This column is not sortable!
                            display:function(data)
                            {
                          //     if(data.record.exists == 1)  
                          // { 
                          return "<a title='View Pie Video' class='btn btn-gradient-primary btn-sm video_"+data.record.id+"' data-id='"+data.record.id+"' video_url='"+data.record.file_path+"' onclick='show_video("+data.record.id+")'><i class='mdi mdi-video'></i></a>"; 
                            //   } 
                            }
                          
                        },
                     /* is_publish: {
                            title: 'Publish Status',
                            width: '10%',
                            sorting: true, //This column is not sortable!
                            display:function(data)
                            {
                              if(data.record.is_publish == 1){
                               return "<label class='badge badge-gradient-success publishUnpublishPieogram' data-id='"+data.record.id+"'  data-id1='1'>Publish</label>";
                              } else {
                                 return "<label class='badge badge-gradient-warning publishUnpublishPieogram' data-id='"+data.record.id+"' data-id1='0'>Unpublish</label>";                               
                                }
                            }
                      }, */ 
                      status: {
                            title: 'Status',
                            width: '10%',
                            sorting: true, //This column is not sortable!
                            display:function(data)
                            {
                              if(data.record.status == 0){
                               return "<label class='badge badge-gradient-success activatedAccountPie' data-id='"+data.record.id+"'  data-id1='1'>Active</label>";
                              } else {
                                 return "<label class='badge badge-gradient-warning activatedAccountPie' data-id='"+data.record.id+"' data-id1='0'>Inactive</label>";
                               
                                }
                              }
                          }, 
                       Action: {
                            title: 'Action',
                            width: '15%',
                            sorting: false, //This column is not sortable!
                            display:function(data)
                            {                             
                               return "<a title='Edit Pie' href='{!! url('/admin/pieable-moment-edit'); !!}/"+data.record.id+"'><i class='mdi mdi-pencil size25px'></i></a>  &nbsp;<a title='Delete Pie' class='pieDelete' data-id='"+data.record.id+"' href='javascript:void(0)'><i class='mdi mdi-delete size25px'></i></a> ";
                               
                            }
                          }, 
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
        </div>
      </div>
    </div>
  </div>
@endsection