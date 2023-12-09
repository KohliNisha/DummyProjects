

@extends('layouts.Admin.appadmin')
@section('content')

<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
      Query Management
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <!-- <a href="{!! url('/admin/create-template'); !!}" class="btn btn-gradient-info btn-rounded btn-sm">Add New</a> -->
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

                  <table id="example" class="table display" style="width:100%">
                    <thead>
                      <tr>
                      <th> S.N</th>
                      <th>Name</th>
                     <!--  <th>Subject</th>  -->
                      <th>Related To </th> 
                      <th>Email</th>
                      <th>Phone Number</th>
                      <th>Status</th>
                      <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                   
                    @foreach($contactus as $key=>$contact)
                      <tr>
                      <td>  {{++$key}}  </td>
                      <td >
                      {{$contact->first_name.' '.$contact->last_name}}</td>
                     <!--  <td> {{$contact->subject}}  </td> -->
                      <td> {{$contact->related_to}}  </td>
                      <td> {{$contact->email}}  </td>
                      <td> {{$contact->phone_code.$contact->phone_number}} </td> 
                      <td>  @if($contact->status =='1') 
                       <label class="badge badge-gradient-success">Replied</label> 
                      @else
                      <label class="badge badge-gradient-warning">Pending</label>     
                      @endif
                      </td>
                      <td>
                        <!-- <a href="{!! url('/admin/views-contactus',$contact->id); !!}" class="btn btn-gradient-warning btn-sm btn-rounded" title="View"><i class=" mdi mdi-eye"></i></a> -->
                        <a href="{!! url('/admin/views-contactus',$contact->id); !!}" class="btn btn-gradient-primary btn-sm btn-rounded" title="View or Reply"><i class=" mdi mdi-reply"></i></a>
                        <!-- <a href="mailto:{{$contact->email}}?Subject={{$contact->subject}}" target="_top" class="btn btn-gradient-success btn-sm btn-rounded" title="reply" ><i class=" mdi mdi-reply"></i></a> -->
                        <!-- <a href="{!! url('/admin/update-template',$contact->id); !!}" class="btn btn-gradient-success  btn-sm btn-rounded" title="Edit"><i class="mdi mdi-grease-pencil"></i></a> -->
                        <!-- <a href="{!! url('/admin/delete-template',$contact->id); !!}" class="btn btn-gradient-danger btn-sm btn-rounded" title="Delete"><i class="mdi mdi-close-box"></i></a> -->
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
