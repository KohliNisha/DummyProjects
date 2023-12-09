@extends('layouts.Admin.appadmin')
@section('content')
<div class="content-wrapper">
    <div class="page-header">
      <h3 class="page-title">
        Broadcast message by Notification
      </h3>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
            <a href="{!! url('/admin/notifications'); !!}" class="btn btn-info btn-sm">Back</a> 
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


         
                    <div class="form-group row"></div>                 

                    <div class="form-group row">
                      <div class="col-sm-2">Message </div>
                      <div class="col-sm-10"><input type="text" class="form-control broacstmessagetext" maxlength="150" name="broadcast_message" placeholder="Write your message here" /></div>
                    </div>                  
                  
                    <div class="form-group row">
                      <div class="col-sm-9">
                       <button type="submit" class="btn btn-gradient-primary mr-2 broadcastmessage">Send</button>
                       </div>
                    </div> 

           


                </div>
              </div>
            </div>
          </div>


<script type="text/javascript">
 $(document).ready(function(){
   $('body').on('click', '.broadcastmessage', function() {
        var userid = 1;
        var elem=$(this);
        var broadcast_message= $(".broacstmessagetext").val();
        if(broadcast_message != ""){            
          // swal("Failed", "Please enter your message", "failed");          
            var message = "Do you want to broadcast message for registered all users.";     
            swal({
              title: "Are you sure?",
              text:message,
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: "btn-danger",
              confirmButtonText: "Yes",
              cancelButtonText: "No",
              closeOnConfirm: false,
              closeOnCancel: false
              },
            function(isConfirm) {
                if (isConfirm) {
                  $(".confirm").attr('disabled', 'disabled'); 
                  $.ajaxSetup({
                          headers: {
                          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                          }
                        });               
                        $.ajax({
                            url: "{{ url('admin/broadcast-message')}}",
                            method: 'post',
                            data:{broadcast_message:broadcast_message},
                            success: function(response){
                              if(response.success == 1){
                                swal({title: "Success", text: response.message, type: "success"},
                                     function(){ 
                                         location.reload();
                                     }
                                  );
                                
                              }else{
                                swal("Failed", response.message, "failed");
                                
                                }
                            }
                          });
                } else {
                swal("Cancelled", "Good choice!", "error");
                }
          });

      } else {
                swal({
                    title: "Warning!",
                    text: "Message can't be blank",
                    icon: "success",
                    button: "Ok",
                     function(isConfirm) {
                         $('.broacstmessagetext').focus();
                     }
                  });
                 
                  return false;
            }
      

    });
 });
</script>
          
@endsection
