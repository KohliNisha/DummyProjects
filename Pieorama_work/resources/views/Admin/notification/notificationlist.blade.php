@extends('layouts.Admin.appadmin')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
      Notification Management
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <a href="{!! url('/admin/broadcast-message'); !!}" class="btn btn-info btn-sm">Broadcast message</a> 
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
                <div class="pull-right">
                </div>
                  <table class="table display" id="clientList">
                    <thead>
                      <tr>
                        <th>
                        S.No
                        </th>
                        <th>
                        Name
                        </th>
                       <!-- <th>
                        Type
                        </th>
                        <th>Read 
                        </th> -->
                        <th>Message
                        </th>
                        <th>
                          Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                   
                    @foreach($notifications as $key=>$notification) 
                      <tr>
                        <td>
                          {{ ++$key }}
                        </td>
                        <td >
                         {{$notification->userdetals[0]->first_name}}
                        </td>
                       
                        <!-- <td>
                        @if($notification->type =='1')         
                      
                        <label class="badge badge-gradient-success" >Verified</label> 
                        @else
                          
                        <label class="badge badge-gradient-warning">Unverified</label>     
                        @endif
                        </td> 
                       <td>
                        @if($notification->is_read =='1')         
                      
                        <label class="badge badge-gradient-success">Yes</label> 
                        @else
                          
                        <label class="badge badge-gradient-warning">No</label>     
                        @endif
                        </td>  -->
                       <td>
                      {{$notification->message}}
                       </td>
                        <td>
                        <!-- <a href="#" class="btn btn-gradient-primary btn-sm btn-rounded"><i class=" mdi mdi-eye"></i></a> -->
                        <!-- <a href="#" class="btn btn-gradient-success btn-sm btn-rounded"><i class=" mdi mdi-pencil"></i></a> -->
                        <a href="javascript:void(0)" class="btn btn-gradient-danger btn-sm btn-rounded deleteNotification" data-id="{{$notification->id}}"><i title="Delete notification" class=" mdi mdi-close"></i></a>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>


  <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
  <link rel="stylesheet" href="{{ asset('css/dataTables.jqueryui.min.css') }}">
  <link href="{{ asset('css/newcss/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css" /> 
  <script src="{{ asset('js/jquery.dataTables.min.js')}}"></script> 
  <script src="{{ asset('js/dataTables.jqueryui.min.js')}}"></script>
  <script src="{{ asset('js/newjs/dataTables.buttons.min.js')}}"></script>
  <script src="{{ asset('js/newjs/jszip.min.js')}}"></script>
  <script src="{{ asset('js/newjs/pdfmake.min.js')}}"></script>
  <script src="{{ asset('js/newjs/vfs_fonts.js')}}"></script>
  <script src="{{ asset('js/newjs/buttons.html5.min.js')}}"></script>

          
@endsection
