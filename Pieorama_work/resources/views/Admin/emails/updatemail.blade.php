@extends('layouts.Admin.appadmin')
@section('content')

<div class="content-wrapper">
<div class="page-header">
      <h3 class="page-title">
      Update Email 
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <a href="{!! url('/admin/emails'); !!}" class="btn btn-info btn-sm">Back</a>
          </li>
        </ol>
      </nav>
    </div>
          <div class="row">
       <!------->
       <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <!-- <h4 class="card-title">Add Email</h4> -->
                  @if ($errors->any())
                  <div class="alert alert-danger">
                  <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                  </ul>
                  </div>
                  @endif
                  <?php //dd($email); ?>
                  <form class="forms-sample" autocomplete="off" method="post" action="{{ route('admin.updatemail',$email->id) }}">
                  @csrf
					            <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Title</label>
                      <div class="col-sm-9">
                        <input type="text" name="title" class="form-control" value="{{ old('title', $email->title) }}">
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label for="exampleInputPassword2" class="col-sm-2 col-form-label">Subject</label>
                      <div class="col-sm-9">
                        <input type="text" name="subject" class="form-control"  value="{{ old('subject', $email->subject) }}">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputConfirmPassword2" class="col-sm-2 col-form-label">Replace variable</label>
                      <div class="col-sm-9">
                      <input type="text" name="replace_vars" class="form-control" value="{{ old('replace_vars', $email->replace_vars) }}">
                        
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputConfirmPassword2" class="col-sm-2 col-form-label">Contents</label>
                      <div class="col-sm-9">
                      <textarea name="body" id="editor1">{{ old('body', $email->body) }}</textarea>
                        <!-- <textarea name="body" class="jqte-test form-control"></textarea> -->
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="exampleInputConfirmPassword2" class="col-sm-2 col-form-label"></label>
                      <div class="col-sm-9">
                         <button type="submit" class="btn btn-gradient-primary mr-2">update</button>
                    <!-- <a href="{!! url('/admin/emails'); !!}" class="btn btn-light">Cancel</a> -->
                      </div>
                    </div>
                   
                  </form>
                 
                </div>
              </div>
            </div>
       <!----->           
          </div>
       
@endsection


