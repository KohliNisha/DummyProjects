<style type="text/css">
  .dropdown-item:hover{ background-color: #b169b1;
    color: white;
  }
  .jtable thead tr{ height: 55px; }
 div.jtable-main-container > table.jtable > tbody td {
    color: rgba(51, 51, 51, 0.75);
    font-weight: 400;
    padding: 3px;
    font-size: 14px;
}
</style>
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center" style="height: 77px;">
        <a class="navbar-brand brand-logo" href="{!! url('/admin/dashboard'); !!}">
			<img src="{{ asset('images/logo_small.png') }}" alt="logo"></a>
        <a class="navbar-brand brand-logo-mini" href="{!! url('/admin/dashboard'); !!}">
		<img src="{{ asset('images/logo_small.png') }}" alt="logo"></a>
      </div><div class="navbar-menu-wrapper d-flex align-items-stretch">
        <!-- <div class="search-field d-none d-md-block">
          <form class="d-flex align-items-center h-100" action="#">
            <div class="input-group">
              <div class="input-group-prepend bg-transparent">
                  <i class="input-group-text border-0 mdi mdi-magnify"></i>                
              </div>
              <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects">
            </div>
          </form>
        </div> -->

        <?php $result = Auth::guard('admin')->User(); ?>

        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <div class="nav-profile-img">
              <?php if(!empty($result->profile_image)){?>
                <img src="{{$result->profile_image}}" alt="image">
              <?php }else{?>
                <img src="{{ asset('images/nouserimage.png') }}">
              <?php } ?>
                <span class="availability-status online"></span>             
              </div>
              <div class="nav-profile-text">
              
                <p class="mb-1 text-black">{{$result->first_name.' '.$result->last_name}}</p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
             <a class="dropdown-item" href="{!! url('/admin/update-profile'); !!}">
                <i class="mdi mdi-settings mr-2 text-success"></i>
                Update Profile
              </a>

              <div class="dropdown-divider"></div> 
              <a class="dropdown-item" href="{!! url('/admin/update-main-page-video'); !!}"><i class="mdi mdi-video mr-2"></i>Update Main Page Video</a>

              <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{!! url('/admin/welcome_message'); !!}">
                <i class="mdi mdi-key-variant mr-2 text-success"></i>
                Welcome message
              </a>
               <!-- <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{!! url('/admin/tvscreeenvideo'); !!}">
                <i class="mdi mdi-key-variant mr-2 text-success"></i>
                Update TV screen Video
              </a> -->
              <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{!! url('/admin/change-password'); !!}">
                <i class="mdi mdi-key-variant mr-2 text-success"></i>
                Change Password
                </a>
             

            <!--   <div class="dropdown-divider"></div> 
              <a class="dropdown-item" href="{!! url('/admin/update-intrest-rate'); !!}">
                <i class="mdi mdi-percent mr-2"></i>
                Update Interest rate
              </a>
              

              <div class="dropdown-divider"></div> 
              <a class="dropdown-item" href="{!! url('/admin/user-terms-template'); !!}">
                <i class="mdi mdi-file-document mr-2"></i>  Loan Agreement template
              </a> -->

              


              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{!! url('/admin/logout'); !!}">
                <i class="mdi mdi-logout mr-2 text-warning"></i>
                Sign out
              </a>
            </div>
          </li>


          <!-- <li class="nav-item d-none d-lg-block full-screen-link">
            <a class="nav-link">
              <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
            </a>
          </li> -->
          <!-- <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
              <i class="mdi mdi-email-outline"></i>
              <span class="count-symbol bg-warning"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
              <h6 class="p-3 mb-0">Messages</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="{{ asset('images/faces/face4.jpg') }}" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
                  <p class="text-gray mb-0">
                    1 Minutes ago
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="{{ asset('images/faces/face2.jpg') }}" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
                  <p class="text-gray mb-0">
                    15 Minutes ago
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <img src="{{ asset('images/faces/face3.jpg') }}" alt="image" class="profile-pic">
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
                  <p class="text-gray mb-0">
                    18 Minutes ago
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <h6 class="p-3 mb-0 text-center">4 new messages</h6>
            </div>
          </li> -->
          <!-- <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="mdi mdi-bell-outline"></i>
              <span class="count-symbol bg-danger"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <h6 class="p-3 mb-0">Notifications</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="mdi mdi-calendar"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                  <p class="text-gray ellipsis mb-0">
                    Just a reminder that you have an event today
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="mdi mdi-settings"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                  <p class="text-gray ellipsis mb-0">
                    Update dashboard
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="mdi mdi-link-variant"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                  <p class="text-gray ellipsis mb-0">
                    New admin wow!
                  </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <h6 class="p-3 mb-0 text-center">See all notifications</h6>
            </div>
          </li> -->
          <!-- <li class="nav-item nav-logout d-none d-lg-block">
            <a class="nav-link" href="#">
              <i class="mdi mdi-power"></i>
            </a>
          </li> -->
          <!-- <li class="nav-item nav-settings d-none d-lg-block">
            <a class="nav-link" href="#">
              <i class="mdi mdi-format-line-spacing"></i>
            </a>
          </li> -->
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    @include('layouts.Admin.sidebar')
    
    
