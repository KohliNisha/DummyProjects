<?php $result = Auth::guard('admin')->User(); ?>
<div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
         
          <li class="nav-item nav-profile">
            <a href="{!! url('/admin/update-profile'); !!}" class="nav-link">
              <div class="nav-profile-image">

                <?php if(!empty($result->profile_image)){?>
                  <img src="{{$result->profile_image}}" alt="image">
                <?php }else{?>
                  <img src="{{ asset('images/nouserimage.png') }}">
                <?php } ?>

                <span class="login-status online"></span> <!--change to offline or busy as needed-->              
              </div>
              
              <div class="nav-profile-text d-flex flex-column">   
              
                <span class="font-weight-bold mb-2">{{$result->first_name.' '.$result->last_name}}</span>
                <!-- <span class="text-secondary text-small">Project Manager</span> -->
              </div>
              <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{!! url('/admin/dashboard'); !!}">
              <span class="menu-title">Dashboard</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>
          </li> 
			
			<li class="nav-item">
            <a class="nav-link" href="{!! url('/admin/pages'); !!}">
              <span class="menu-title">Static pages</span>
              <i class="mdi mdi-home menu-icon"></i>
            </a>  
          </li> 
		  

          <li class="nav-item userlink">
            <a class="nav-link" href="{!! url('/admin/users'); !!}">
              <span class="menu-title">Users</span>
              <i class="mdi mdi-account-multiple-plus menu-icon"></i>
            </a>
          </li>
			
          <li class="nav-item Channelslink">
            <a class="nav-link" href="{!! url('/admin/channels'); !!}">
              <span class="menu-title">Channels</span>
              <i class="mdi mdi-key-change menu-icon"></i>
            </a>
          </li>
			
         <li class="nav-item Videoslink">
            <a class="nav-link" href="{!! url('/admin/pieograms'); !!}">
              <span class="menu-title">Pieograms</span>
              <i class="mdi mdi-video menu-icon"></i>
            </a>
          </li>


          <li class="nav-item Pieablelink">
            <a class="nav-link" href="{!! url('/admin/pieable-moments'); !!}">
              <span class="menu-title">Pieable moments</span>
              <i class="mdi mdi-video menu-icon"></i>
            </a>
          </li>


          <li class="nav-item librarylink">
            <a class="nav-link collapsed" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
              <span class="menu-title">Public</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-library-books menu-icon"></i>
            </a>
            <div class="collapse" id="icons" style="">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link audiolink" href="{!! url('/admin/audio-library'); !!}">Audio</a></li>
                <li class="nav-item"> <a class="nav-link videolink" href="{!! url('/admin/video-library'); !!}">Video</a></li>
                <li class="nav-item"> <a class="nav-link imagelink" href="{!! url('/admin/image-library'); !!}">Image</a></li>
               
                <li class="nav-item"> <a class="nav-link audience_reactionlink" href="{!! url('/admin/audience_reaction'); !!}">Audience Reaction</a></li>
               
                <!-- <li class="nav-item"> <a class="nav-link chroma_keyslink" href="{!! url('/admin/chroma_keys'); !!}">Chroma Keys</a></li> -->
              </ul>
            </div>
          </li>
          <li class="nav-item pieflavorlink">
            <a class="nav-link" href="{!! url('/admin/pie_flavor'); !!}">
              <span class="menu-title">Pies</span>
              <i class="mdi mdi-video menu-icon"></i>
            </a>
          </li>
           <li class="nav-item maintagslink">
            <a class="nav-link collapsed" data-toggle="collapse" href="#tagsicons" aria-expanded="false" aria-controls="icons">
              <span class="menu-title">Tags</span>
              <i class="menu-arrow"></i>
             <i class="mdi mdi-tag-multiple menu-icon"></i>
            </a>
            <div class="collapse" id="tagsicons" style="">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item">
              <a class="nav-link Tagslink" href="{!! url('/admin/tags'); !!}">Tags
               <!--  <span class="menu-title">Tags</span> -->
               <!--  <i class="mdi mdi-tag-multiple menu-icon"></i> -->
              </a>
            </li>
            <li class="nav-item"> 
              <a class="nav-link trending_taglink" href="{!! url('/admin/trending_tags'); !!}">Trending Tags</a></li>
              </ul>
            </div>
          </li>
         
          
          
          
          <li class="nav-item Supportlink">
            <a class="nav-link" href="{!! url('/admin/query'); !!}">
              <span class="menu-title">Support</span>
              <i class="mdi mdi-laptop menu-icon"></i>
            </a>
          </li>


          <li class="nav-item Reportslink">
            <a class="nav-link collapsed" data-toggle="collapse" href="#iconsreport" aria-expanded="false" aria-controls="icons">
              <span class="menu-title">Reports</span>
              <i class="menu-arrow"></i>
              <i class="mdi mdi-file-pdf menu-icon"></i>
            </a>
            <div class="collapse" id="iconsreport" style="">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link audiolink" href="{!! url('/admin/channel-report'); !!}">Channels Reports</a></li>
              
                <li class="nav-item"> <a class="nav-link videolink" href="{!! url('/admin/report-list'); !!}">Pieograms Reports</a></li>
                <li class="nav-item"> <a class="nav-link imagelink" href="{!! url('/admin/users-report'); !!}">Users Reports</a></li>
              </ul>
            </div>
          </li>


          <li class="nav-item Notificationslink">
            <a class="nav-link" href="{!! url('/admin/notifications'); !!}">
              <span class="menu-title">Notifications</span>
              <i class="mdi mdi-bell-ring menu-icon"></i>
            </a>
          </li>



          <li class="nav-item Systememaillink">
            <a class="nav-link" href="{!! url('/admin/emails'); !!}">
              <span class="menu-title">System Email Templates</span>
              <i class="mdi mdi-email menu-icon"></i>
            </a>
          </li>
          <li class="nav-item subscribeuserlist">
            <a class="nav-link" href="{!! url('/admin/subscribeuserlist'); !!}">
              <span class="menu-title">Subscribed User</span>
              <i class="mdi mdi-account-multiple-plus menu-icon"></i>
            </a>
          </li>
           <li class="nav-item Tvsreening">
            <a class="nav-link" href="{!! url('/admin/tvscreeninglist'); !!}">
              <span class="menu-title"> While You Wait video</span>
              <i class="mdi mdi-account-multiple-plus menu-icon"></i>
            </a>
          </li>
         <!--  <li class="nav-item subscribeuserlist">
            <a class="nav-link" href="{!! url('/admin/bulkmail'); !!}">
              <span class="menu-title">Mail management</span>
              <i class="mdi mdi-email menu-icon"></i>
            </a>
          </li> -->
          

        <!--  <li class="nav-item">
            <a class="nav-link" href="{!! url('/admin/loans'); !!}">
              <span class="menu-title">Loan Management</span>
              <i class="mdi mdi-briefcase-download  menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{!! url('/admin/notifications'); !!}">
              <span class="menu-title">Notifications Management</span>
              <i class="mdi mdi-notification-clear-all  menu-icon"></i>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{!! url('/admin/query'); !!}">
              <span class="menu-title">Query Management</span>
              <i class="mdi mdi-comment-question-outline menu-icon"></i>
            </a>
          </li>      

         
          <li class="nav-item">
            <a class="nav-link" href="{!! url('/admin/repayments'); !!}">
              <span class="menu-title">Repayment Management</span>
              <i class="mdi mdi-table-large menu-icon"></i>
            </a>
          </li>


            <li class="nav-item">
            <a class="nav-link" href="{!! url('/admin/clientreports'); !!}">
              <span class="menu-title">Manage Report</span>
              <i class="mdi mdi-file menu-icon"></i>
            </a>
          </li> -->

   
        </ul>
      </nav>
