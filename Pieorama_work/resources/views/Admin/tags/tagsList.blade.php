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
<script type="text/javascript">
  document.ready(function(){
   
    $(".maintagslink").addClass("active");
    $(".Tagslink").addClass("active");
    $(".trending_taglink").removeClass("active");
    $(".collapse").addClass("show"); 
  });
</script>
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
      Tags Management
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
         <!--   <a href="{!! url('/admin/create-parking-owner'); !!}" class="btn btn-info  btn-sm">Add New</a>  -->
          </li>
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
                    <input type="text" class="form-control" id="keyword" placeholder="Keyword (don't include #)">
                </div>
             <!--  <div class="form-group"> 
                <select id="status" class="form-control mr-2">
                        <option value="">--Filter Account Type--</option>
                        <option value="0">Inactive </option>
                        <option value="1">Active </option>
                 </select>
                 </div>  -->
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
                        title: 'Tags List',
                        paging: true, //Enable paging
                        pageSize: 10, //Set page size (default: 10)
                        sorting: true, //Enable sorting
                        defaultSorting: 'Name ASC', //Set default sorting
                        actions: {

                            listAction: "{{ route('admin.tagajax') }}",
                            
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
                      tag_text: {
                                title: 'Tags',
                                width: '28%',
                                 display:function(data)
                                {
                                  return "#"+data.record.tag_text+"";
                                 
                                  }
                                
                            },
                      /*channel_description: {
                                title: 'Channel Description',
                                width: '50%',
                            },*/

                       created_at: {
                                title: 'Created',
                                width: '10%',
                                
                            }, 

                       /* status: {
                            title: 'Channels Status',
                            width: '10%',
                            sorting: true, //This column is not sortable!
                            display:function(data)
                            {
                              if(data.record.status == 1){
                               return "<label class='badge badge-gradient-success activatedAccountChannel' data-id='"+data.record.id+"'  data-id1='1'>Active</label>";
                              } else {
                                 return "<label class='badge badge-gradient-warning activatedAccountChannel' data-id='"+data.record.id+"' data-id1='0'>Inactive</label>";
                               
                                }
                              }
                          },*/ 
                       Action: {
                            title: 'Action',
                            width: '10%',
                            sorting: false, //This column is not sortable!
                            display:function(data)
                            {
                             //  var ids = btoa(data.record.id);
                               return "<a title='Delete User' class='tagDelete' data-id='"+data.record.id+"' href='javascript:void(0)'><i class='mdi mdi-delete size25px'></i></a> ";
                               
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
