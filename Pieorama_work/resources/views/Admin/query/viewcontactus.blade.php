@extends('layouts.Admin.appadmin')
@section('content')

<div class="content-wrapper">
<div class="page-header">
      <h3 class="page-title">
      View & reply
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
          <a href="{!! url('/admin/query'); !!}" class="btn btn-gradient-info btn-rounded btn-sm">Back</a>
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
                  <form class="forms-sample" autocomplete="off" method="post" action="">
                  @csrf
                  <div class="form-group row">
                    <input type="hidden" name="id" value="{{$contactus->id}}">
                  </div>

                    <div class="form-group row">
                      <div class="col-sm-2">From </div>
                      <div class="col-sm-10">{{$contactus->email}}</div>
                    </div>

                    @if($contactus->related_to)
                    <div class="form-group row">
                      <div class="col-sm-2">Related To </div>
                        <div class="col-sm-10">{{$contactus->related_to}}</div>
                    </div>
                    @endif


                    @if($contactus->subject)
                    <div class="form-group row">
                      <div class="col-sm-2">Subject </div>
                        <div class="col-sm-10">{{$contactus->subject}}</div>
                    </div>
                    @endif


                    <div class="form-group row">
                        <div class="col-sm-2">Message</div>
                          <div class="col-sm-10">
                           {{$contactus->message}}
                          </div>
                    </div>
                    

                   @if($contactus->status == 1)
                   <div class="form-group row">
                      <div class="col-sm-12">
                          <button type="button"  class="btn btn-gradient-success">Replied</button>
                      </div>
                    </div> 
              


                  @else
                   <div class="form-group row">
                      <div class="col-sm-12">
                          <textarea name="message" id="editor1">{{ old('message') }}</textarea>
                      </div>
                    </div>


                    <div class="form-group row">
                      <div class="col-sm-9">
                         <button type="submit" class="btn btn-gradient-primary mr-2">Reply</button>
                      </div>
                    </div> 
                    @endif



                  </form>
                </div>
              </div>
            </div>
       <!----->           
          </div>
       
@endsection
