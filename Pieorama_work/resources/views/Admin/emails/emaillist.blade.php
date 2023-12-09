@extends('layouts.Admin.appadmin')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
      Email Management
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <a href="{!! url('/admin/create-template'); !!}" class="btn btn-info btn-sm">Add New</a>
          </li> 
        </ol>
      </nav>
    </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"></h4>
                <?php //dd($emails); ?>
                @if(session()->has('message'))
                  <div class="alert alert-success alert-dismissible">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  {{ session()->get('message') }}
                  </div>
                  @endif
                <div class="pull-right">
                
                </div>
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                      <th>
                        S.N
                        </th>
                        <th>
                        Title
                        </th>
                        <th>
                        Subject
                        </th>
                        <th>
                        Replace
                        </th>
                        <!-- <th>
                        Slug
                        </th> -->
                        <th>
                          Action
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                   
                    @foreach($emails as $key=>$email)
                      <tr>
                      <td>
                        {{++$key}}
                        </td>
                        <td>
                        {{$email->title}}
                        </td>
                        <td>
                        {{$email->subject}}
                        </td>
                        <td>
                        {{$email->replace_vars}}
                        </td>
                        <!-- <td>
                        {{$email->slug}}
                        </td> -->
                        <td>
                        
                        <a href="{!! url('/admin/views-template',$email->slug); !!}" class="" target="_black" title="View"><i class="mdi mdi-eye size25px"></i></a>
                        <a href="{!! url('/admin/update-template',$email->id); !!}" class="" title="Edit"><i class="mdi mdi-pencil size25px"></i></a>
                        <!-- <a href="{!! url('/admin/delete-template',$email->id); !!}" class="btn btn-gradient-danger btn-sm btn-rounded" title="Delete"><i class="mdi mdi-close-box"></i></a> -->
                        </td>
                      </tr>
                      
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
           
            
          </div>
       
@endsection
