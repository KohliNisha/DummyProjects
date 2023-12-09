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
</style>

<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
      Subscribed Users
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <!-- <li class="breadcrumb-item">
           <a href="{!! url('/admin/create-parking-owner'); !!}" class="btn btn-info  btn-sm">Add New</a> 
          </li> -->
        </ol>
      </nav>
    </div>
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
                   <a href="{!! url('/admin/bulkmail'); !!}" class="btn btn-info btn-fill mr-2">Broadcast</a>
                    <input type="text" class="form-control" id="keyword" placeholder="Keyword">
                </div>
              <!-- <div class="form-group"> 
                <select id="status" class="form-control mr-2">
                        <option value="">--Filter Account Type--</option>
                        <option value="0">Inactive </option>
                        <option value="1">Active </option>
                 </select>
                 </div> --> 
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
                        defaultSorting: 'Name ASC', //Set default sorting
                        actions: {

                            listAction: "{{ route('admin.subscribedusers') }}",
                            
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

                     

                      
                
                      email: {
                                title: 'Email Id',
                                width: '15%',
                                sorting: true,  
                            },
                      newsletter: {
                                title: 'Subscribed/Unsubscribed',
                                width: '20%',
                                sorting: true,
                                 display:function(data)
                            {
                              if(data.record.newsletter == 1){
                               return "<label class='badge badge-gradient-success unsubscribe' data-id='"+data.record.id+"' data-id1='1'>Subscribed</label>";
                              } else {
                                 return "<label class='badge badge-gradient-warning' data-id='"+data.record.id+"' data-id1='0'>Unsubscribed</label>";
                               
                                }
                              }  
                            },
                    


                    /*     digital_address_code: {
                                title: 'Postal<br/> Code',
                                width: '10%',
                                
                            },
                     */
                       created_at: {
                                title: 'Registered<br/> On',
                                width: '10%',
                                
                            }, 

                      

                       is_confirm: {
                            title: 'Email <br/> Status',
                            width: '10%',
                            sorting: true, //This column is not sortable!
                            display:function(data)
                            {
                              if(data.record.is_confirm == 1){
                               return "<label class='badge badge-gradient-success activatedEmail' data-id='"+data.record.id+"' data-id1='1'>Verified</label>";
                              } else {
                                 return "<label class='badge badge-gradient-warning activatedEmail' data-id='"+data.record.id+"' data-id1='0'>Not verified</label>";
                               
                                }
                              }
                          },    
      
                       Action: {
                            title: 'Action',
                            width: '10%',
                            sorting: false, //This column is not sortable!
                            display:function(data)
                            {
                               var ids = data.record.newsletter;
                               if(ids == 1){
                                  return "<a title='send email' href='{!! url('/admin/sendmailtouser'); !!}/"+data.record.id+"/1'><i class='mdi mdi-email menu-icon size25px'></i></a>";
                               }else{
                                  return "<a title='send email' href='{!! url('/admin/sendmailtouser'); !!}/"+data.record.id+"/2'><i class='mdi mdi-email menu-icon size25px'></i></a>";
                               }
                               
                               
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
