<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

 Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); 


/*Route::post('register', 'UserController@register');	
Route::post('verify_code', 'UserController@verify_code');	
Route::post('resend_code', 'UserController@resendverifycode');	     

Route::post('login', 'UserController@login');
Route::post('forgetpassword', 'UserController@forgetpassword');
Route::post('forgetpasswordverifycode', 'UserController@forgetpassword_verify_code');  
Route::post('resetpassword', 'UserController@reset_password');  

Route::get('homepielisting', 'VideoController@homepielisting');   
Route::get('searchpie', 'VideoController@searchpie');   
Route::post('pieogramsdetails', 'VideoController@pieogramsDetails');    

Route::get('mypielist', 'VideoController@mypielist'); */   
 


Route::namespace("Api")->group(function() {
	

//Register Api
	

	
	
/*	

#Code API commenting as instructed by client point given as below on 19 May 2020 by Flexsin Technology
#. Revise the API security and lock down end-points that are not yet in use (i.e. most, if not all, of the end-points)


//Signup API
Route::post('register', 'UsersignupController@register')->name('user.register');
Route::post('otp-verification', 'UsersignupController@mobileVerification')->name('user.mobile.verification');
Route::post('social-login', 'UsersignupController@sociallogin')->name('user.sociallogin');
Route::post('login', 'UsersignupController@login')->name('user.login');
//Route::post('resend-confirm-email', 'UsersignupController@resendConfirmEmail')->name('user.resend.confirm.email');
Route::post('forgot-password', 'UsersignupController@forgotPassword')->name('user.forgot.password');
Route::post('reset-password', 'UsersignupController@ResetPassword')->name('user.reset.password');
Route::post('mobile-verification', 'UsersignupController@mobileVerification')->name('user.mobile.verification');
Route::post('resend-otp', 'UsersignupController@resendOtp')->name('user.resend.otp');
Route::post('resend-otp-profile', 'UsersignupController@resendOtpforUpdateProfile')->name('user.resend.otp.profile');
Route::post('security-answer', 'UsersignupController@securityanswer')->name('user.security.answer');
Route::post('change-password', 'UsersignupController@changePassword')->name('user.change.password');
Route::post('set-new-password', 'UsersignupController@setNewPassword')->name('user.set.new.password');
Route::get('activate-account/{token}', 'UsersignupController@activateAccount')->name('user.activate.account');
//Route::post('reset-password', ['as' => 'reset.password', 'uses' => 'UsersignupController@reset']);
Route::post('check-email', 'UsersignupController@checkEmailExist')->name('user.check.email');

//Profile API
Route::post('my-profile', 'ProfileController@getprofile')->name('user.profile');
Route::post('update-profile', 'ProfileController@updateprofile')->name('user.update.profile');
Route::post('update-profile-photo', 'ProfileController@updateprofilephoto')->name('user.update.profile.photo');
Route::post('update-settings', 'ProfileController@updateUserSettings')->name('user.update.settings');
Route::post('user-settings', 'ProfileController@getUserSetting')->name('user.settings');

// Notification API
Route::post('get-notification', 'Notifications@getNotificationList')->name('user.notification');
Route::post('read-notification', 'Notifications@readNotification')->name('user.read.notification');
Route::post('read-all-notification', 'Notifications@readAllNotification')->name('user.read.all.notification');

//Other basic or master Apis
Route::any('library-item-list', 'MasterController@librarylist')->name('user.librarylist');
Route::post('library-use-item', 'MasterController@useOfLibrary')->name('user.useOflibrary');
Route::any('channel-list', 'MasterController@channelList')->name('user.channelList');
Route::any('media-upload', 'MasterController@mediaupload')->name('master.mediaupload');

Route::post('contact-us', 'MasterController@contactUs')->name('user.contact.us');
Route::post('faq', 'MasterController@faq')->name('user.faq');
Route::post('logout', 'MasterController@logout')->name('user.logout');
Route::post('page', 'MasterController@pages')->name('user.page'); 

*/




// Pieograms upload and details
Route::any('upload-pieogram', 'PieogramController@pieogramUpload')->name('user.pieogramupload');
Route::any('pie_flavor', 'PieogramController@pie_flavor')->name('user.pie_flavor');
// Showing Piegrams details
Route::any('getpieflavor', 'PieogramController@getpieflavor')->name('user.getpieflavor');
Route::any('chromakeys', 'PieogramController@chromakeys')->name('user.chromakeys');
// showing audience reactions
Route::any('audience_reactions', 'PieogramController@AudienceReactions')->name('user.audience_reactions');
//Route::any('treanding_tag', 'PieogramController@TrendingTag')->name('user.treanding_tag');
Route::any('soundalert', 'PieogramController@soundalert')->name('user.soundalert');
Route::any('pieogramsdetails', 'PieogramController@pieogramsDetails')->name('user.pieogramsdetails'); 
Route::get('tvscreening', 'PieogramController@tvscreening')->name('user.tvscreening'); 
});


