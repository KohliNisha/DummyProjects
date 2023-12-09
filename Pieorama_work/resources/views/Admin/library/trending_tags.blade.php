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
<script type="text/javascript">
  document.ready(function(){
    $(".maintagslink").addClass("active");
    $(".trending_taglink").addClass("active");
    $(".Tagslink").removeClass("active");
    $(".collapse").addClass("show"); 
  });
</script>
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
     Trending Tags
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
           <a href="{!! url('/admin/add_trending_tags'); !!}" class="btn btn-info  btn-sm">Add New</a>  
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
            <!--   <div class="form-group"> 
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
                      },
                      data : {type :2 },
                });
                $('#usersjtable').jtable({
                        title: 'Users List',
                        paging: true, //Enable paging
                        pageSize: 10, //Set page size (default: 10)
                        sorting: true, //Enable sorting
                        defaultSorting: 'Name ASC', //Set default sorting
                        
                        actions: {

                            listAction: "{{ route('admin.getaudience_reaction') }}",
                            
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

                      
                      name: {
                                title: 'Tag',
                                width: '8%',
                            },

                        
                        status: {
                            title: 'Tag status',
                            width: '10%',
                            sorting: true, //This column is not sortable!
                            display:function(data)
                            {
                              if(data.record.status == 1){
                                 return "<label class='badge badge-gradient-success activatedaudience_reactions' data-id='"+data.record.id+"'  data-id1='0'>Active</label>";
                                } else {
                                 return "<label class='badge badge-gradient-warning activatedaudience_reactions' data-id='"+data.record.id+"' data-id1='1'>Inactive</label>";                              
                                }
                              }
                          },       

                       Action: {
                            title: 'Action',
                            width: '10%',
                            sorting: false, //This column is not sortable!
                            display:function(data)
                            {
                               return "<a title='Delete trending tag' class='audienceReaction_Delete' data-id='"+data.record.id+"' href='javascript:void(0)'><i class='mdi mdi-delete size25px'></i></a> <a title='Edit audience reaction' href='{!! url('/admin/edit-trending_tags'); !!}/"+data.record.id+"'><i class='mdi mdi-pencil size25px'></i></a>";                               
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