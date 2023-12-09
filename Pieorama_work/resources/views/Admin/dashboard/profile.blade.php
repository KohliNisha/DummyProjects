@extends('layouts.Admin.appadmin')
@section('content')
<div class="content-wrapper">

<div class="page-header">
      <h3 class="page-title">
      Update Profile
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <a href="{!! url('/admin/dashboard'); !!}" class="btn btn-info btn-sm">Back</a>
          </li>
        </ol>
      </nav>
    </div>
          <div class="row">
       <!------->
       <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title"></h4>
                  @if ($errors->any())
                  <div class="alert alert-danger">
                  @foreach ($errors->all() as $error)
                  {{$error}}
                  @endforeach
                  </div>
                  @endif
                  @if(session()->has('message'))
                  <div class="alert alert-success">
                  {{ session()->get('message') }}
                  </div>
                  @endif
                  <form class="forms-inline" autocomplete="off" method="post" action="{{ route('admin.userprofile') }}" enctype="multipart/form-data">
                  @csrf

                  <?php //dd($profile->first_name); ?>
					            <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-3 col-form-label">First Name</label>
                      <div class="col-sm-9">
                        <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{ old('first_name', $profile->first_name) }}">
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label for="" class="col-sm-3 col-form-label">Last Name</label>
                      <div class="col-sm-9">
                        <input type="text" name="last_name" class="form-control"  placeholder="Last Name" value="{{ old('last_name', $profile->last_name) }}">

                      </div>
                    </div>
                    

                    <div class="form-group row">
                      <label for="" class="col-sm-3 col-form-label">Email Address</label>
                      <div class="col-sm-9">
                        <input type="text" name="email"class="form-control" placeholder="Email Address" value="{{ old('email', $profile->email) }}">
                      </div>
                    </div>

                  <div class="form-group row">
                      <label for="" class="col-sm-3 col-form-label">File upload </label>
                      <input type="file" name="profile_image" class="file-upload-default">
                      <div class="input-group col-sm-9">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image">
                        <span class="input-group-append">
                          <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                        </span>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-sm-3 col-form-label"></label>
                      <div class="col-sm-9">                      
                      <?php if(!empty($profile->profile_image)){?>
                        <img src="{{$profile->profile_image}}" class="img-rounded">
                      <?php }else{?>
                        <img src="{{ asset('images/faces/face1.jpg') }}" width="120" height="90" class="img-rounded">
                      <?php } ?>                      
                      </div>
                    </div>

                     
                     <input type="hidden" name="exits_image"class="form-control"  value="{{ old('profile_image', $profile->profile_image) }}">
                    <div class="form-group row">
                      <label for="exampleInputConfirmPassword2" class="col-sm-3 col-form-label"></label>
                      <div class="col-sm-9">
                         <button type="submit" class="btn btn-primary mr-2">Submit</button>
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
