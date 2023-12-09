<!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
              Copyright © <?php echo date('Y');?> Pieorama Group LLC. All rights reserved.</span>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
    <!-- container-scroller -->

  <!-- plugins:js -->
  <link rel="stylesheet" href="{{ asset('vendors/css/lity.css')}}">
  
  <script src="{{ asset('vendors/js/vendor.bundle.addons.js')}}"></script>
  <script src="{{ asset('vendors/js/lity.js')}}"></script>
	
  <!-- inject:js -->
  <script src="{{ asset('js/off-canvas.js')}}"></script>
  <script src="{{ asset('js/misc.js')}}"></script>
  <script src="{{ asset('js/sweetalert.min.js')}}"></script>
  
  <!-- Custom js for this page-->
  <script src="{{ asset('js/dashboard.js')}}"></script>
  <script src="{{ asset('js/file-upload.js')}}"></script>
  <script src="{{ asset('js/file-upload.js')}}"></script>
  <!-- End custom js for this page-->


  <!-- j Table js added -->
  <script src="//cdn.ckeditor.com/4.11.1/full/ckeditor.js"></script>
  <script>
      CKEDITOR.replace( 'editor1',{
        uiColor: '#d99bff'
      });
      CKEDITOR.config.removePlugins = 'image,flash,print,newpage,imagebutton,button,iframe,find,forms,preview';

      CKEDITOR.config.font_names = 'Arial/Arial, Helvetica, sans-serif;' +
    'Comic Sans MS/Comic Sans MS, cursive;' +
    'Courier New/Courier New, Courier, monospace;' +
    'Georgia/Georgia, serif;' +
    'Lucida Sans Unicode/Lucida Sans Unicode, Lucida Grande, sans-serif;' +
    'Tahoma/Tahoma, Geneva, sans-serif;' +
    'Times New Roman/Times New Roman, Times, serif;' +
    'Trebuchet MS/Trebuchet MS, Helvetica, sans-serif;' +
    'Verdana/Verdana, Geneva, sans-serif;' + 
    'Dekers/dekers_true;' + 
    'serif;sans serif;monospace;cursive;fantasy;Lobster;'  + 
    'bitterregular;' + 
    'averageregular;';
  </script>

  <script type="text/javascript">
    $(document).ready(function () { 
           $('.fadeout').fadeOut(5000);
           $('.table').DataTable();
       });

    $(document).ready(function(){  
      $('body').on('click', '.activatedEmail', function() {
        var elem=$(this);
        var activestatus=elem.data('id1');
        var userid=elem.data('id');
        var statuskey = 1;
        if(activestatus == 1){
          var message = "Do you want to mark as unverify email address?";
        }else{
          var message = "Do you want to verify this email address?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });              
                  $.ajax({
                      url: "{{ url('admin/activateEmail') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,activestatus:activestatus},
                      success: function(response){
                        if(response.status == 1){
                          //swal("Success", response.message, "success");
                          window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });



  $('body').on('click', '.publishUnpublishPieogram', function() {
        var elem=$(this);
        var accountactiveStatus=elem.data('id1');
        var userid=elem.data('id');
        var statuskey = 4;
        if(accountactiveStatus == 1){
          var message = "Do you want to make Unpublish this Pieorama?";
        }else{
          var message = "Do you want to make Publish this Pieorama?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });               
                  $.ajax({
                      url: "{{ url('admin/activateVideo') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,accountactiveStatus:accountactiveStatus},
                      success: function(response){
                        if(response.status == 1){
                          //swal("Success", response.message, "success");
                         window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });     



  $('body').on('click', '.activatedAccountVideo', function() {
        var elem=$(this);
        var accountactiveStatus=elem.data('id1');
        var userid=elem.data('id');
        var statuskey = 2;
        if(accountactiveStatus == 1){
          var message = "Do you want to make Inactive this Pieorama?";
        }else{
          var message = "Do you want to make active this Pieorama?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });               
                  $.ajax({
                      url: "{{ url('admin/activateVideo') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,accountactiveStatus:accountactiveStatus},
                      success: function(response){
                        if(response.status == 1){
                          //swal("Success", response.message, "success");
                         window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });

  $('body').on('click', '.activatedAccountPie', function() {
        var elem=$(this);
        var accountactiveStatus=elem.data('id1');
        var userid=elem.data('id');
        var statuskey = 2;
        if(accountactiveStatus == 1){
          var message = "Do you want to make Inactive this pieable moment?";
        }else{
          var message = "Do you want to make active this pieable moment?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });               
                  $.ajax({
                      url: "{{ url('admin/activatepie') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,accountactiveStatus:accountactiveStatus},
                      success: function(response){
                        if(response.status == 1){
                          //swal("Success", response.message, "success");
                          window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });








  $('body').on('click', '.activatedAccountChannel', function() {
        var elem=$(this);
        var accountactiveStatus=elem.data('id1');
        var userid=elem.data('id');
        var statuskey = 2;
        if(accountactiveStatus == 1){
          var message = "Do you want to make Inactive this channel?";
        }else{
          var message = "Do you want to make active this channel?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });               
                  $.ajax({
                      url: "{{ url('admin/activateChannel') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,accountactiveStatus:accountactiveStatus},
                      success: function(response){
                        if(response.status == 1){
                          //swal("Success", response.message, "success");
                         window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });


  $('body').on('click', '.activatedAccount', function() {
        var elem=$(this);
        var accountactiveStatus=elem.data('id1');
        var userid=elem.data('id');
        var statuskey = 2;
        if(accountactiveStatus == 1){
          var message = "Do you want to make Inactive this account?";
        }else{
          var message = "Do you want to make active this account?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });               
                  $.ajax({
                      url: "{{ url('admin/activateEmail') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,accountactiveStatus:accountactiveStatus},
                      success: function(response){
                        if(response.status == 1){
                          //swal("Success", response.message, "success");
                          window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });


  $('body').on('click', '.tagDelete', function() {
      var elem=$(this);
      var userid=elem.data('id');
      var statuskey = 3;
      swal({
        title: "Are you sure?",
        text:"Do you want to delete this tag?",
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: "{{ url('admin/deleteTags') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey},
                      success: function(response){
                        if(response.status == 1){
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
  });

  $('body').on('click', '.videoDelete', function() {
      var elem=$(this);
      var userid=elem.data('id');
      var statuskey = 3;
      swal({
        title: "Are you sure?",
        text:"Do you want to delete this pieoram video?",
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: "{{ url('admin/activateVideo') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey},
                      success: function(response){
                        if(response.status == 1){
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
  });



   $('body').on('click', '.pieDelete', function() {
      var elem=$(this);
      var userid=elem.data('id');
      var statuskey = 3;
      swal({
        title: "Are you sure?",
        text:"Do you want to delete this pieable moment?",
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: "{{ url('admin/activatepie') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey},
                      success: function(response){
                        if(response.status == 1){
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
  });


  $('body').on('click', '.channelDelete', function() {
      var elem=$(this);
      var userid=elem.data('id');
      var statuskey = 3;
      swal({
        title: "Are you sure?",
        text:"Do you want to delete this channel? Please Make sure you will lose also all pieoram video or related data which are related to this channel because those will also deleted from the system.",
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: "{{ url('admin/activateChannel') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey},
                      success: function(response){
                        if(response.status == 1){
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
  });

  $('body').on('click', '.accountDelete', function() {
      var elem=$(this);
      var userid=elem.data('id');
      var statuskey = 3;
      swal({
        title: "Are you sure?",
        text:"Do you want to delete this account?",
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: "{{ url('admin/activateEmail') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey},
                      success: function(response){
                        if(response.status == 1){
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
  });



  $('body').on('click', '.libraryMediaDelete', function() {
      var elem=$(this);
      var userid=elem.data('id');
      var statuskey = 3;
      swal({
        title: "Are you sure?",
        text:"Do you want to delete this media file?",
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: "{{ url('admin/deleteMediaFile') }}",
                      method: 'post',
                      data:{userid:userid},
                      success: function(response){
                        if(response.status == 1){
                            swal({title: "Success", text: "Media file has been deleted successfully.", type: "success"},
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
  });



  $('body').on('click', '.deleteNotification', function() {
      var notificationid = $('.deleteNotification').data('id');
      swal({
        title: "Are you sure?",
        text:"Do you want to delete this notification?",
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: "{{ url('admin/deletenotification') }}",
                      method: 'post',
                      data:{notificationid:notificationid},
                      success: function(response){
                        if(response.status == 1){
                          //swal("Success", response.message, "success");
                          window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });


  $('body').on('click', '.activatedlibrary', function() {
        var elem=$(this);
        var accountactiveStatus=elem.data('id1');
      //  alert(accountactiveStatus);
        var userid=elem.data('id');
        var statuskey = 1;
        if(accountactiveStatus == 0){
          var message = "Do you want to disable this media file?";
        }else{
          var message = "Do you want to enable this media file?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });               
                  $.ajax({
                      url: "{{ url('admin/activatelibrary') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,accountactiveStatus:accountactiveStatus},
                      success: function(response){
                        if(response.status == 1){
                          swal({title: "Success", text: response.message, type: "success"},
                               function(){ 
                                   location.reload();
                               }
                            );
                          //swal("Success", response.message, "success");
                         // window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });

  $('body').on('click', '.activatedpie_flavor', function() {
        var elem=$(this);
        var accountactiveStatus=elem.data('id1');
      //  alert(accountactiveStatus);
        var userid=elem.data('id');
        var statuskey = 1;
        if(accountactiveStatus == 0){
          var message = "Do you want to disable this Pie flavor?";
        }else{
          var message = "Do you want to enable this Pie flavor?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });               
                  $.ajax({
                      url: "{{ url('admin/activate_pie_flvaor') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,accountactiveStatus:accountactiveStatus},
                      success: function(response){
                        if(response.status == 1){
                          swal({title: "Success", text: response.message, type: "success"},
                               function(){ 
                                   location.reload();
                               }
                            );
                          //swal("Success", response.message, "success");
                         // window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });

$('body').on('click', '.pie_flavor_Delete', function() {
      var elem=$(this);
      var userid=elem.data('id');
      var statuskey = 3;
      swal({
        title: "Are you sure?",
        text:"Do you want to delete this Pie flavor file?",
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: "{{ url('admin/deletepieflavor') }}",
                      method: 'post',
                      data:{userid:userid},
                      success: function(response){
                        if(response.status == 1){
                            swal({title: "Success", text: "Pie flavor has been deleted successfully.", type: "success"},
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
  });


$('body').on('click', '.audienceReaction_Delete', function() {
      var elem=$(this);
      var userid=elem.data('id');
      var statuskey = 3;
      swal({
        title: "Are you sure?",
        text:"Do you want to delete?",
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: "{{ url('admin/deleteAudienceReactions') }}",
                      method: 'post',
                      data:{userid:userid},
                      success: function(response){
                        if(response.status == 1){
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
  });


  $('body').on('click', '.activatedaudience_reactions', function() {
        var elem=$(this);
        var accountactiveStatus=elem.data('id1');
      //  alert(accountactiveStatus);
        var userid=elem.data('id');
        var statuskey = 1;
        if(accountactiveStatus == 0){
          var message = "Do you want to disable?";
        }else{
          var message = "Do you want to enable?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });               
                  $.ajax({
                      url: "{{ url('admin/activate_audience_reaction') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,accountactiveStatus:accountactiveStatus},
                      success: function(response){
                        if(response.status == 1){
                          swal({title: "Success", text: response.message, type: "success"},
                               function(){ 
                                   location.reload();
                               }
                            );
                          //swal("Success", response.message, "success");
                         // window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });


    $('body').on('click', '.pagestatus', function() {
        var elem=$(this);
        var accountactiveStatus=elem.data('id1');
       
        var userid=elem.data('id');
        var statuskey = 4;
        if(accountactiveStatus == 0){
          var message = "Do you want to make activate this page?";
        }else{
          var message = "Do you want to make deactivate this page?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });               
                  $.ajax({
                      url: "{{ url('admin/activatePageStatus') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,accountactiveStatus:accountactiveStatus},
                      success: function(response){
                       
                        if(response.status == 1){
                          swal("Success", response.message, "success");
                         window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });  

  $('body').on('click', '.activatedchromakey', function() {
        var elem=$(this);
        var accountactiveStatus=elem.data('id1');
      //  alert(accountactiveStatus);
        var userid=elem.data('id');
        var statuskey = 1;
        if(accountactiveStatus == 0){
          var message = "Do you want to disable?";
        }else{
          var message = "Do you want to enable?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });               
                  $.ajax({
                      url: "{{ url('admin/activatedchromakey') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,accountactiveStatus:accountactiveStatus},
                      success: function(response){
                        if(response.status == 1){
                          swal({title: "Success", text: response.message, type: "success"},
                               function(){ 
                                   location.reload();
                               }
                            );
                          //swal("Success", response.message, "success");
                         // window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });

  $('body').on('click', '.chroma_key_Delete', function() {
      var elem=$(this);
      var userid=elem.data('id');
      var statuskey = 3;
      swal({
        title: "Are you sure?",
        text:"Do you want to delete this chroma key?",
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: "{{ url('admin/deletechromakeys') }}",
                      method: 'post',
                      data:{userid:userid},
                      success: function(response){
                        if(response.status == 1){
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
  });
 $('body').on('click', '.allchroma_key_Delete', function() {

      var elem=$(this);
      var userid=elem.data('id');

      swal({
        title: "Are you sure?",
        text:"Do you want to delete chroma keys?",
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: "{{ url('admin/deleteallchromakeys') }}",
                      method: 'post',
                      data:{chromakeyid:userid},
                      success: function(response){
                        if(response.status == 1){
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
  });

  $('body').on('click', '.unsubscribe', function() {
        var elem=$(this);
        var newsletter=elem.data('id1');
        var userid=elem.data('id');
        var statuskey = 2;
        if(newsletter == 1){
          var message = "Do you want to unsubscribe this user?";
        }else{
          var message = "Do you want to subscribe this user?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });               
                  $.ajax({
                      url: "{{ url('admin/managesubscription') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,newsletter:newsletter},
                      success: function(response){
                        if(response.status == 1){
                          //swal("Success", response.message, "success");
                         window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });

   $('body').on('click', '.tvscreenvideoDelete', function() {
      var elem=$(this);
      var userid=elem.data('id');
      
      swal({
        title: "Are you sure?",
        text:"Do you want to delete this video?",
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });
                  $.ajax({
                      url: "{{ url('admin/deletetvscreenvideo') }}",
                      method: 'post',
                      data:{userid:userid},
                      success: function(response){
                        if(response.status == 1){
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
  });

$('body').on('click', '.activatedtvscreen', function() {
        var elem=$(this);
        var accountactiveStatus=elem.data('id1');
      //  alert(accountactiveStatus);
        var userid=elem.data('id');
        var statuskey = 1;
        if(accountactiveStatus == 0){
          var message = "Do you want to disable?";
        }else{
          var message = "Do you want to enable?";
        }
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
            $.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                  });               
                  $.ajax({
                      url: "{{ url('admin/statusTvscreening') }}",
                      method: 'post',
                      data:{userid:userid,statuskey:statuskey,accountactiveStatus:accountactiveStatus},
                      success: function(response){
                        if(response.status == 1){
                          swal({title: "Success", text: response.message, type: "success"},
                               function(){ 
                                   location.reload();
                               }
                            );
                          //swal("Success", response.message, "success");
                         // window.location.reload();
                        }else{
                          swal("Failed", response.message, "failed");
                          }
                      }
                    });
          } else {
          swal("Cancelled", "Good choice!", "error");
          }
    });
  });

});
</script>


