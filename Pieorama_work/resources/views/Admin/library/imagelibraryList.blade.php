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
      Library Management- Image
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
           <a href="{!! url('/admin/add-image-file'); !!}" class="btn btn-info  btn-sm">Add New</a>  
          </li>
        </ol>
      </nav>
    </div>
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"></h4>
            @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fadeout">
            @foreach ($errors->all() as $error)
            {{$error}}
            @endforeach
            </div>
            @endif
            @if(session()->has('message'))
            <div class="alert alert-success alert-dismissible fadeout">
            {{ session()->get('message') }}
            </div>
            @endif
            <div class="positionright">
             <form class="form-inline" id="search" onSubmit="return false">
                <div class="form-group">
                    <input type="text" class="form-control" id="keyword" placeholder="Search by Title">
                </div>
                &nbsp; &nbsp;
                <div class="form-group">
                    <button type="submit" id="filter" class="btn btn-info btn-fill mr-2">Filter</button>
                    <button id="reset_button" class="btn btn-info btn-fill mr-2">Reset</button>
                </div>
            </form>
          </div>
            <div class="clearfix"></div><hr/>
            <div class="table-responsive">
              <div id="usersjtable"></div>
             </div>
            <script type="text/javascript">             
             $(document).ready(function () { 
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
                            listAction: "{{ route('admin.libraryajaximage') }}",
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
                              width: '4%',
                          },
                       file_type: {
                            title: 'Media Type',
                            width: '10%',
                            sorting: false, //This column is not sortable!
                            display:function(data)
                            {
                              if(data.record.file_type == 1){
                                return "Image";
                              } else if(data.record.file_type == 2){
                                return "Audio";
                              } else {
                                 return "Video";                               
                                }
                              }
                          },
                      title: {
                                title: 'Title',
                                width: '8%',
                            },

                       file_name: {
                            title: 'File',
                            width: '8%',
                            sorting: false, //This column is not sortable!
                            display:function(data)
                            {
                              var file_path = data.record.file_name;
                               return "<a title='View Audio' class='btn btn-gradient-primary btn-sm' data-id='"+data.record.id+"' href='"+file_path+"' target='_blank'><i class='mdi mdi-image'></i></a>";
                               
                            }
                          
                        },

                        library_tags: {
                                title: 'Tags',
                                sorting: false, //
                                width: '10%',
                                
                        },  

                         comment_note: {
                                title: 'Internal Note',
                                width: '10%',
                                
                        },  
  
                                 
                   /*   file_mime_type: {
                                title: 'File Tipe',
                                width: '10%',
                                sorting: false,
                                
                            }, */
                      file_size: {
                                title: 'File Size',
                                width: '10%',
                                
                        },  

                       /*view_count: {
                                title: 'No. of used',
                                width: '10%',
                                sorting: false,
                        }, */   
                     /*  created_at: {
                                title: 'Registered On',
                                width: '10%',
                                
                            },*/

                        status: {
                            title: 'Status',
                            width: '10%',
                            sorting: true, //This column is not sortable!
                            display:function(data)
                            {
                              if(data.record.status == 0){
                                 return "<label class='badge badge-gradient-success activatedlibrary' data-id='"+data.record.id+"'  data-id1='0'>Active</label>";
                                } else {
                                 return "<label class='badge badge-gradient-warning activatedlibrary' data-id='"+data.record.id+"' data-id1='1'>Inactive</label>";                              
                                }
                              }
                          },       

                       Action: {
                            title: 'Action',
                            width: '10%',
                            sorting: false, //This column is not sortable!
                            display:function(data)
                            {
                               return "<a title='Delete Media' class='libraryMediaDelete' data-id='"+data.record.id+"' href='javascript:void(0)'><i class='mdi mdi-delete size25px'></i></a> <a title='Edit Media' href='{!! url('/admin/edit-media-image'); !!}/"+data.record.id+"'><i class='mdi mdi-pencil size25px'></i></a>";
                               
                            }
                          },    
                     /* status: {
                                title: 'Status',
                                width: '5%',
                                type: 'checkbox',
                                defaultValue: 'true',
                                key :false,
                                sorting: false,                           
                          
                          }, 
                       Action: {
                                title: 'Action',
                                width: '15%',
                                sorting: false, //This column is not sortable!                         
                                
                          }*/
                            
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
