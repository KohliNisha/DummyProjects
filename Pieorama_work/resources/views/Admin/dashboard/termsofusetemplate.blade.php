@extends('layouts.Admin.appadmin')
@section('content')
<div class="content-wrapper">

<div class="page-header">
      <h3 class="page-title">Loan Agreement Terms templates</h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <a href="{!! url('/admin/dashboard'); !!}" class="btn btn-gradient-info btn-rounded btn-sm">Back</a>
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
                  <div class="alert alert-danger">   @foreach ($errors->all() as $error)
                  {{$error}}
                  @endforeach
                  </div>
                  @endif


                  @if(session()->has('message'))
                  <div class="alert alert-success">
                      {{ session()->get('message') }}
                  </div>
                  @endif

                    <form class="forms-inline" autocomplete="off" method="post" action="{{ route('admin.user.terms.templates') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="exampleInputConfirmPassword2" class="col-sm-2 col-form-label">Template Description</label>
                        <div class="col-sm-9">
                        <textarea name="description"   id="editor1">{{ old('description', $profile->description) }}</textarea>
                        </div>
                      </div>            


                      <div class="form-group row">
                        <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label"></label>
                        <div class="col-sm-9">
                           <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                      <a href="{!! url('/admin/dashboard'); !!}" class="btn btn-light">Cancel</a>
                        </div>
                      </div>                   
                    </form>
                 
                </div>
              </div>
            </div>
       <!----->           
            
          </div>
       
@endsection
