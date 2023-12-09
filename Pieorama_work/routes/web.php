<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::namespace("Site")->group(function() { 
    //landing page and some statics pages of fornt end side    
    Route::get('/', 'HomeController@index')->name('site.index');
    Route::match(['get', 'post'],'/home', 'HomeController@index')->name('site.index'); 
    Route::match(['get', 'post'],'/welcome', 'HomeController@index')->name('site.welcome'); 
    Route::match(['get', 'post'],'/signup', 'HomeController@signUp')->name('site.signup'); 
    Route::get('/activate-account/{email}','HomeController@mail_status')->name('site.activate-account');
    Route::get('/resend-emailVerification/{email}','HomeController@resend_emailVerification')->name('site.resend-emailVerification');
    Route::match(['get', 'post'],'/signin', 'HomeController@signIn')->name('site.signin'); 
    Route::match(['get', 'post'],'/search', 'HomeController@search')->name('site.search');  
    
    // Peogram Category list Items
    Route::match(['get', 'post'],'pieograms/{id}/{catname}', 'PieogramsController@pieogramsByCategories')->name('site.pieogramscatlist');
    Route::match(['get', 'post'],'pieogram-details/{id}/{videotitle}', 'PieogramsController@pieogramsDetails')->name('site.pieogramdetails');
	 Route::match(['get', 'post'],'watch/', 'PieogramsController@watch')->name('site.pieogramdetails'); 
	
    Route::match(['get', 'post'],'/delete-pieograms', 'PieogramsController@deletePieogram')->name('site.deletePieogram');
    Route::match(['get', 'post'],'/add-comment', 'PieogramsController@addPieogram_comment')->name('site.addcommentPieogram');
    Route::match(['get', 'post'],'/add-reply', 'PieogramsController@addPieogram_reply')->name('site.addreplyPieogram');
    Route::match(['get', 'post'],'/delete-comment', 'PieogramsController@deletecomment')->name('site.deleteComments');
     Route::match(['get', 'post'],'/shared-video', 'PieogramsController@sharevideo')->name('site.sharevideo');
     Route::match(['get', 'post'],'/like-video', 'PieogramsController@like_video')->name('site.like_video');
     Route::match(['get', 'post'],'/unlike-video', 'PieogramsController@dislike_video')->name('site.unlike_video');
     Route::match(['get', 'post'],'/unlike_comment', 'PieogramsController@unlike_comment')->name('site.unlike_comment');
     Route::match(['get', 'post'],'/more_comment', 'PieogramsController@more_comment')->name('site.more_comment');
    
	 
    Route::match(['get', 'post'],'/change-search-status', 'PieogramsController@searchStatus')->name('site.searchstatus');
    Route::match(['get', 'post'],'/change-public-available', 'PieogramsController@publicAvailableStatus')->name('site.publicavailable');
    Route::match(['get', 'post'],'/watched-pieogram', 'PieogramsController@watchedPieogram')->name('site.pieogramwatched');


    // Social Media login
    // facebook login for donar 
    Route::get('facebook', 'HomeController@redirectToFacebook')->name('site.facebook');
    Route::get('facebook/callback', 'HomeController@handleFacebookCallback')->name('site.facebook.callback');
    // google login for donar 
    Route::get('google', 'HomeController@redirectToGoogle')->name('site.google');
    Route::get('google/callback', 'HomeController@handleGoogleCallback')->name('site.google.callback');
    // linkedin login for donar 
    Route::get('linkedin', 'HomeController@redirectToLinkedin')->name('site.linkedin');
    Route::get('linkedin/callback', 'HomeController@handleLinkedinCallback')->name('site.linkedin.callback');
     // linkedin login for donar 
    Route::get('twitter', 'HomeController@redirectToTwitter')->name('site.twitter');
    Route::get('twitter/callback', 'HomeController@handleTwitterCallback')->name('site.twitter.callback');
     // linkedin login for donar 
    Route::get('instagram', 'HomeController@redirectToInstagram')->name('site.instagram');
    Route::get('instagram/callback', 'HomeController@handleInstagramCallback')->name('site.instagram.callback');



    // My Profile
    Route::match(['get', 'post'],'/my-profile', 'ProfileController@profile')->name('site.myprofile');
    Route::match(['get', 'post'],'/update-profile', 'ProfileController@UpdateProfile')->name('site.updateprofile'); 
    Route::match(['get', 'post'],'/my-friend-list/{search}', 'ProfileController@pieoramaFriendsList')->name('site.myfriendlist');
    //Route::match(['get', 'post'],'/userProfile', 'ProfileController@pieoramaFriendsList')->name('site.myfriendlist');
    Route::match(['get', 'post'],'/pieorama-user-profile/{id}', 'ProfileController@otherUserProfile')->name('site.otheruserprofile');


    Route::match(['get', 'post'],'/forgotpassword', 'HomeController@forgotPassword')->name('site.forgotpassword'); 
    Route::match(['get'],'/reset-password/{email}', 'HomeController@reset_password')->name('site.resetpassword'); 
    Route::match(['get', 'post'],'/setnewpassword', 'HomeController@setnewpassword')->name('site.setnewpassword'); 

    // Static content pages
   
    Route::get('/about-pieorama', 'HomeController@aboutUs')->name('site.aboutUs');  
    Route::get('/terms-of-use', 'HomeController@termsOfUse')->name('site.termsOfUse'); 
    Route::get('/privacy-policy', 'HomeController@privacyPolicy')->name('site.privacyPolicy'); 
    Route::get('/get-help', 'HomeController@getHelp')->name('site.getHelp'); 
    Route::match(['get', 'post'],'/contact-us', 'HomeController@contactUs')->name('site.contactus'); 
    Route::get('/pie-history', 'HomeController@pieHistory')->name('site.pieHistory');
    Route::get('/logout', 'HomeController@logout')->name('site.logout');
    Route::post('/videoplayontimer', 'HomeController@videoplayontimer')->name('site.videoplayontimer');
    Route::match(['get','post'],'/pie-moments','PieController@index')->name('site.pie-moments');
    Route::match(['get','post'],'/view','PieController@view')->name('site.view');
    Route::post('/sendData','HomeController@sendData')->name('site.sendData');
    Route::post('/loadmore','HomeController@loadmore')->name('site.loadmore');

    Route::get('/landingPage','HomeController@landingPage')->name('site.landingPage');
    Route::get('/gif-corner','HomeController@gifcorner')->name('site.gif-corner');
    Route::post('/gifdata','HomeController@gifdata')->name('site.gifdata');
    Route::get('/getDownload/{id}','HomeController@getDownload')->name('site.getDownload');
    Route::match(['get','post'],'/unsubscribe-confirmation/{email??}/{name??}','HomeController@unsubscribeconfirmation')->name('site.unsubscribeconfirmation');
    Route::get('/unsubscribed-confirmation','HomeController@unsubscribeconfirmation')->name('site.unsubscribedconfirmation');
    //Route::get('/unsubscribed','HomeController@unsubscribed')->name('site.unsubscribed');

    //Route::get('/landingPage','HomeController@landingPage')->name('site.landingPage');

});


Route::namespace("Admin")->group(function() { 

    //Admin login forgot-password magements
    Route::match(['get', 'post'],'/admin/forgot-password', 'AdminController@forgotpassword')->name('admin.forgotpassword');  
    Route::get('/admin/reset-password/{email}','AdminController@reset_password')->name('admin.resetpassword');
    Route::match(['get', 'post'],'/admin/set-new-password', 'AdminController@setnewpassword')->name('admin.setnewpassword');  
    Route::match(['get', 'post'],'admin/', 'AdminController@index')->name('admin.login');

    //Admin Dashboard managements
    Route::get('/admin/dashboard', 'DashboardController@dashboard')->name('admin.dashboard');
    Route::get('/admin/pages', 'DashboardController@pages')->name('admin.pages'); 
	Route::match(['get', 'post'],'admin/pages-edit/{id}', 'DashboardController@pagesEdit')->name('admin.pagesEdit');
    Route::match(['get', 'post'],'admin/create-page', 'DashboardController@createPage')->name('admin.create_page');
	  
    Route::get('/admin/logout', 'DashboardController@logout')->name('admin.logout');
    Route::match(['get', 'post'],'/admin/change-password', 'DashboardController@changepassword')->name('admin.changepassword');
    Route::match(['get', 'post'],'/admin/update-profile', 'DashboardController@userprofile')->name('admin.userprofile');
    Route::any('admin/pageslist', 'DashboardController@pageslist')->name('admin.pageslist');

    // Users Managements
    Route::match(['get', 'post'],'admin/users', 'ClientController@clientlist')->name('admin.users');
    Route::any('admin/ajaxrequestclients', 'ClientController@clientajaxlist')->name('admin.clientsajax');
    Route::match(['get', 'post'],'admin/userdetails/{id}', 'ClientController@clientdetails')->name('admin.clientdetails');
    Route::match(['get', 'post'],'admin/user-edit/{id}', 'ClientController@userEdit')->name('admin.useredit');
    Route::match(['get', 'post'],'admin/activateEmail', 'ClientController@accountactivationstatus')->name('admin.accountactivationstatus');
    Route::match(['get', 'post'],'admin/updateclient/{id}', 'ClientController@updateclient')->name('admin.updateclient');    
     Route::match(['get', 'post'],'admin/verifyEmail', 'ClientController@mobileVerificationByAdmin')->name('admin.mobileVerificationByAdmin'); 

    // Channel managements
    Route::match(['get', 'post'],'admin/channels', 'ChannelsController@channelList')->name('admin.channelList');
    Route::any('admin/ajaxrequestChannel', 'ChannelsController@channelajaxlist')->name('admin.channelajax');
    Route::match(['get', 'post'],'admin/create-channel', 'ChannelsController@channelAdd')->name('admin.channelAdd');
    Route::match(['get', 'post'],'admin/channel-edit/{id}', 'ChannelsController@editChannel')->name('admin.channeledit');
    Route::match(['get', 'post'],'admin/activateChannel', 'ChannelsController@Channelactivationstatus')->name('admin.activateChannel');

   
    Route::match(['get', 'post'],'admin/welcome_message', 'DashboardController@welcome_message')->name('admin.welcome_message');
     // Tags management 
     Route::match(['get', 'post'],'admin/tags', 'TagsController@tagsList')->name('admin.tagsList');
     Route::any('admin/ajaxrequestTags', 'TagsController@tagajaxlist')->name('admin.tagajax');
     Route::any('admin/deleteTags', 'TagsController@deletetag')->name('admin.deleteTags');

     // Videos Routes
     Route::match(['get', 'post'],'admin/pieograms', 'VideosController@videosList')->name('admin.videosList'); 
     Route::any('admin/ajaxrequestVideos', 'VideosController@videoajaxlist')->name('admin.videoajax');
     Route::match(['get', 'post'],'admin/activateVideo', 'VideosController@VideoActivationstatus')->name('admin.activateVideo');
     Route::match(['get', 'post'],'admin/activatePageStatus', 'DashboardController@activatePageStatus')->name('admin.activatePageStatus');
     Route::match(['get', 'post'],'admin/pieorama-video-details/{id}', 'VideosController@pieoramaVideodetails')->name('admin.pieoramavideodetails');
     Route::match(['get', 'post'],'admin/pieorama-edit/{id}', 'VideosController@editPieorama')->name('admin.editpieorama');
     Route::match(['get', 'post'],'admin/update-main-page-video', 'VideosController@updateWebsiteMainPagePieorama')->name('admin.updateMainPagePieorama');
     Route::match(['get', 'post'],'admin/pieorama-change-ownership/{id}', 'VideosController@pieoramaChangeOwnership')->name('admin.pieoramaChangeOwnership');
     Route::match(['get', 'post'],'admin/add-pieogram-file', 'VideosController@pieogramAdd')->name('admin.pieogramAdd');


      // pieable moments
      Route::match(['get', 'post'],'admin/pieable-moments', 'PieableMoments@pieableList')->name('admin.pieableList'); 
      Route::match(['get', 'post'],'admin/add-pieable', 'PieableMoments@addPieable')->name('admin.addpieable'); 
      Route::any('admin/ajaxrequestpieVideos', 'PieableMoments@videoajaxlist')->name('admin.videoajaxpie');
      Route::match(['get', 'post'],'admin/pieable-moment-edit/{id}', 'PieableMoments@editPie')->name('admin.editpie');
      Route::match(['get', 'post'],'admin/activatepie', 'PieableMoments@PieActivationstatus')->name('admin.activatepie');

     
    // Other routes   
    Route::match(['get', 'post'],'admin/support', 'SupportController@SupportList')->name('admin.SupportList');
       

    // Library managements
    Route::match(['get', 'post'],'admin/audio-library', 'LibraryController@audioLibraryList')->name('admin.audioLibraryList');
    Route::match(['get', 'post'],'admin/add-audio-file', 'LibraryController@audioAdd')->name('admin.audioAdd');
    Route::any('admin/libraryajaxrequest', 'LibraryController@libraryajaxlist')->name('admin.libraryajax');
    Route::match(['get', 'post'],'admin/video-library', 'LibraryController@videoLibraryList')->name('admin.videoLibraryList');
    Route::match(['get', 'post'],'admin/image-library', 'LibraryController@imageLibraryList')->name('admin.imageLibraryList');
     Route::match(['get', 'post'],'admin/deleteMediaFile', 'LibraryController@deleteMedia')->name('admin.deletemediafile');
    Route::any('admin/libraryajaxrequestVideo', 'LibraryController@libraryajaxvideolist')->name('admin.libraryajaxvideo');
    Route::any('admin/libraryajaxrequestImage', 'LibraryController@libraryajaximagelist')->name('admin.libraryajaximage');
    Route::match(['get', 'post'],'admin/add-image-file', 'LibraryController@imageAdd')->name('admin.imageAdd');
     Route::match(['get', 'post'],'admin/add-video-file', 'LibraryController@videoAdd')->name('admin.videoAdd');
     Route::match(['get', 'post'],'admin/activatelibrary', 'LibraryController@libraryActivateDeavtivateStatus')->name('admin.activatelibrary');
     Route::match(['get', 'post'],'admin/edit-media/{id}', 'LibraryController@editmedia')->name('admin.editmedia');
     Route::match(['get', 'post'],'admin/edit-media-video/{id}', 'LibraryController@editmediavideo')->name('admin.editmediavideo');
     Route::match(['get', 'post'],'admin/edit-media-image/{id}', 'LibraryController@editmediaimage')->name('admin.editmediaimage');
     Route::match(['get', 'post'],'admin/pie_flavor', 'LibraryController@pie_flavor')->name('admin.pie_flavor');
     Route::match(['get', 'post'],'admin/pie_flavor_list', 'LibraryController@pie_flavor_list')->name('admin.pie_flavor_list');
     Route::match(['get', 'post'],'admin/add-pieflavor', 'LibraryController@addpieflavor')->name('admin.add-pieflavor');
     Route::match(['get', 'post'],'admin/edit-pie_flavor/{id}', 'LibraryController@edit_pie_flavor')->name('admin.edit-pie_flavor');
     Route::match(['get', 'post'],'admin/deletepieflavor', 'LibraryController@deletepieflavor')->name('admin.deletepieflavor');
     Route::match(['get', 'post'],'admin/deleteallchromakeys', 'LibraryController@deleteallchromakeys')->name('admin.deleteallchromakeys');
     Route::match(['get', 'post'],'admin/audience_reaction', 'LibraryController@audience_reaction')->name('admin.audience_reaction');
     Route::match(['get', 'post'],'admin/getaudience_reaction', 'LibraryController@getAudienceReaction')->name('admin.getaudience_reaction');
     Route::match(['get', 'post'],'admin/add-audiencereactions', 'LibraryController@add_audiencereactions')->name('admin.add-audiencereactions');
     Route::match(['get', 'post'],'admin/edit-audience_reaction/{id}', 'LibraryController@edit_audience_reaction')->name('admin.edit-audience_reaction');
     Route::match(['get', 'post'],'admin/deleteAudienceReactions', 'LibraryController@deleteAudienceReactions')->name('admin.deleteAudienceReactions');
     Route::match(['get', 'post'],'admin/trending_tags', 'LibraryController@trending_tags')->name('admin.trending_tags');
     Route::match(['get', 'post'],'admin/add_trending_tags', 'LibraryController@add_audiencereactions')->name('admin.add_trending_tags');
     Route::match(['get', 'post'],'admin/edit-trending_tags/{id}', 'LibraryController@edit_audience_reaction')->name('admin.edit-trending_tags');

     // chroma keys

    Route::match(['get', 'post'],'admin/chroma_keys', 'LibraryController@chroma_keys')->name('admin.chroma_keys');
     Route::match(['get', 'post'],'admin/chroma_keys_list/{id??}', 'LibraryController@chroma_keys_list')->name('admin.chroma_keys_list');
     Route::match(['get', 'post'],'admin/add_chroma_keys', 'LibraryController@add_chroma_keys')->name('admin.add_chroma_keys');
     Route::match(['get', 'post'],'admin/edit_chroma_keys/{id}', 'LibraryController@edit_chroma_keys')->name('admin.edit_chroma_keys');
     Route::match(['get', 'post'],'admin/deletechromakeys', 'LibraryController@deletechromakeys')->name('admin.deletechromakeys');


     // Activate and deactivate status

     Route::match(['get', 'post'],'admin/activate_audience_reaction', 'LibraryController@activateDeactivate_audience_reaction')->name('admin.activate_audience_reaction');
     Route::match(['get', 'post'],'admin/activate_pie_flvaor', 'LibraryController@activateDeactivate_pie_flvaor')->name('admin.activate_pie_flvaor');
     Route::match(['get', 'post'],'admin/activatedchromakey', 'LibraryController@activatedchromakey')->name('admin.activatedchromakey');
     //Route::match(['get', 'post'],'admin/getaudience_reaction', 'LibraryController@getaudience_reaction')->name('admin.getaudience_reaction');

    // Notfication controller routes
    Route::match(['get', 'post'],'admin/notifications', 'NotificationController@notificationlist')->name('admin.notifications');
    Route::match(['get', 'post'],'admin/deletenotification', 'NotificationController@deletenotification')->name('admin.deletenotification');
    Route::match(['get', 'post'],'admin/broadcast-message', 'NotificationController@broadcastmessage')->name('admin.broadcastmessage');    
    

    //query managements
    Route::match(['get', 'post'],'admin/query', 'QueryController@querylist')->name('admin.query');
    Route::match(['get', 'post'],'admin/views-contactus/{id}', 'QueryController@viewcontactus')->name('admin.viewcontactus');

   
    //email templates managements
    Route::match(['get', 'post'],'admin/emails', 'EmailController@emaillist')->name('admin.emails');
    Route::match(['get', 'post'],'admin/create-template', 'EmailController@addnewmail')->name('admin.addnewmail');
    Route::match(['get', 'post'],'admin/update-template/{id}', 'EmailController@updatemail')->name('admin.updatemail');
    Route::match(['get', 'post'],'admin/delete-template/{id}', 'EmailController@deletetemplate')->name('admin.deletetemplate');
    Route::match(['get', 'post'],'admin/views-template/{id}', 'EmailController@viewtemplate')->name('admin.viewtemplate');   


    //Reports Management
    Route::match(['get', 'post'],'admin/users-report', 'ReportController@clientreport')->name('admin.clientreports');  
    Route::match(['get', 'post'],'admin/report-list', 'ReportController@reportList')->name('admin.reports');
    Route::match(['get', 'post'],'admin/channel-report', 'ReportController@channelreport')->name('admin.channelreport');



    // Reports management
    Route::match(['get', 'post'],'admin/reports', 'ReportController@reportlist')->name('admin.reports');  
    Route::match(['get', 'post'],'admin/tvscreeenvideo', 'DashboardController@tvscreeenvideo')->name('admin.tvscreeenvideo');  
    Route::match(['get', 'post'],'admin/subscribeuserlist', 'DashboardController@subscribeuserlist')->name('admin.subscribeuserlist');
    Route::match(['get', 'post'],'admin/subscribedusers', 'DashboardController@subscribedusers')->name('admin.subscribedusers');
    Route::match(['get', 'post'],'admin/managesubscription', 'DashboardController@managesubscription')->name('admin.managesubscription');
    Route::match(['get', 'post'],'admin/bulkmail', 'DashboardController@bulkmail')->name('admin.bulkmail');
    Route::match(['get', 'post'],'admin/sendmailtouser/{id}/{newsletter}', 'DashboardController@sendmailtouser')->name('admin.sendmailtouser');
    Route::match(['get', 'post'],'admin/bulkmail', 'DashboardController@bulkmail')->name('admin.bulkmail');
    Route::match(['get', 'post'],'admin/tvscreeninglist', 'DashboardController@tvscreeninglist')->name('admin.tvscreeninglist');
    Route::match(['get', 'post'],'admin/addtvscreeningfile', 'DashboardController@addtvscreeningfile')->name('admin.addtvscreeningfile');
    Route::match(['get', 'post'],'admin/tvsreeningedit/{id}', 'DashboardController@tvsreeningedit')->name('admin.tvsreeningedit');
    Route::match(['get', 'post'],'admin/deletetvscreenvideo', 'DashboardController@deletetvscreenvideo')->name('admin.deletetvscreenvideo');
    Route::match(['get', 'post'],'admin/statusTvscreening', 'DashboardController@statusTvscreening')->name('admin.statusTvscreening');
    Route::any('admin/showtvscreenlist', 'DashboardController@showtvscreenlist')->name('admin.showtvscreenlist');

 //   Route::match(['get', 'post'],'admin/repaymentreports', 'ReportController@repaymentreport')->name('admin.repaymentreports');  

   
});

