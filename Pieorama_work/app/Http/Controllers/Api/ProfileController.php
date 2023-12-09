<?php

namespace App\Http\Controllers\Api;
use Validator;
use App\Models\User;
use App\Models\PieVideo;
use App\Models\Usernotification;
use App\Models\UserSettings; 
use App\Models\UserAddress;
use App\Models\Assets;
use Illuminate\Http\Request;
use App\Mail\SignupMail;
use App\Mail\signupApiMail;
use App\Mail\Forgotpassword;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
//use Helper;
use App\Helpers\Helper;
class ProfileController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 401;




/**
 * @api {post} /api/profile User profile
 * @apiName Postgetprofile
 * @apiGroup
 *
 * @apiParam {Integer} id unique user id.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *    {
 *  "status": 1,
    "message": "success",
    "user": {
        "id": 3,
        ........
        ........
        "created_at": "2018-12-14 06:09:41",
        "updated_at": "2018-12-14 06:09:41"
    }
}
 *
 */


public function getprofile(Request $request){
  try{ 
      if($request->isMethod('post')){
        if(!empty($request->user_id)){
            $userdata = User::where('id',$request->user_id)->where('status',1)->where('is_deleted',0)->first();

            return ['status' => 1, 'message' => 'Success', 'userData' => $userdata];
        }else{
            return ['status' => 0, 'message' => 'No record found'];
        }
      }else{
        return ['status' => 0, 'message' => 'Method not allowed'];
      }

  }catch(\Exception $e){
    return ['status' => 0, 'message' => $e->getMessage()];
  }

}






























    /*public function getprofile(Request $request) 
    { 
     try {      
        if($request->isMethod('post'))  
        {
            $validator=Validator::make($request->all(),[
                'user_id'=> 'required',    
            ]);  
           
            if($validator->fails()) {
                return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
             $user =User::where('id',$request->user_id)->where('is_deleted',0)->first();
		     $PieoramaVideos = PieVideo::where('created_by',$user['id'])->where('is_deleted',0)->get();
            
 			if($PieoramaVideos->count()) {                       
             $data=explode(',',$secondary_id['assets_id']);
               $loan = Assets:: select('id as assest_id','import_url')->whereIn('id', $data)->get();
               $secondary_id['images'] = $loan;
               $user['pieogramList'] = $PieoramaVideos; 
             } else {
                $user['pieogramList'] = [];
             }


            if(!empty($user)){
                return['status'=>1,'message'=>'success','user'=>$user];
            }else{
                return['status'=>0,'message'=>'no record found','user'=>[]];
            }
        } 
      } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
      }
    }


*/

/**
 * @api {post} /api/update-profile User update profile
 * @apiName Postupdateprofile
 * @apiGroup

 * @apiParam {String} address_line Donar/Student addrss.
 * @apiParam {String} state Donar/Student state.
 * @apiParam {String} city Donar/Student city.
 * @apiParam {integer} zip_code Donar/Student zip code.
 * @apiParam {Float} latitude Donar/Student Latitude.
 * @apiParam {Float} latitude Donar/Student Longitude.
 * @apiParam {String} college_name Donar/Student College name.
 * @apiParam {String} profile_image Donar/Student profile image.
 * @apiParam {String} id_card_image Donar/Student id card 
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Profile has been updated successfully."
 *     }
 *
 */






    public function updateprofile(Request $request) 
    { 
     try {  
        if($request->isMethod('post'))  
        {  
           $validator=Validator::make($request->all(),[
                    'user_id'=> 'required',   
                    'first_name'=>'required',
                    'last_name'=>'required',
                    'date_of_birth' => 'required',
                    'email' => 'required|email',
                    'gender' => 'required',
                    //'phone_code'=>'required',
                    //'phone_number'=>'required',
                    'address_1' => 'required',
                    'city' => 'required',
                    'state' => 'required',
                    'country' => 'required',                  
            ]);  
            if($validator->fails()) {
                return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
            $user = User::where('id',$request->user_id)->where('is_deleted',0)->first();
              if($user){                
                   if($user->status == '0'){
                    return ['status'=>0, 'message' => 'Your account is not activated. Please activate your account.','user'=>[]];                     
                    }                
                  $userid = $request->user_id ;
                  $getsameuser = User::where('email', $request->email)
                                     ->where('id' , '!=', $userid)
                                     ->count();
                if ($getsameuser > 0) {
                    return ['status'=>0, 'message' => 'User already registered with this email Id. Please use another email Id.','user'=>[]];
                }        
                $date_of_birth = date("Y-m-d", strtotime($request->date_of_birth)); 
                $user = User::where('id', $userid)->first();
                $UserAddress = UserAddress::where('user_id', $userid)->first();

                if($UserAddress){
                    $update_address = UserAddress::where('user_id',$userid)->Update(['address_1'=>$request->address_1,'city'=>$request->city,'state'=>$request->state,'country'=>$request->country]); 
                } else {
                      $dataAddress['user_id'] = $userid;
                      $dataAddress['address_1'] = $request->address_1;
                      $dataAddress['city'] = $request->city;
                      $dataAddress['state'] = $request->state;
                      $dataAddress['country'] = $request->country;                   
                      UserAddress::create($dataAddress);
                }
               if($request->profile_image !=''){
                  $image_url= $request->profile_image ;
                }else{
                    $image_url = $user->profile_image ;
                }
                $update_profile = User::where('id',$userid)->Update(['first_name'=>$request->first_name,'last_name'=>$request->last_name,'date_of_birth'=>$date_of_birth,'email'=>$request->email,'profile_image'=>$image_url, 'gender'=>$request->gender, 'phone_number'=>$request->phone_number]);   

                  if($update_profile){
                    if($user->email){
                      if($user->email != $request->email){
                          $update_is_Confirm = User::where('id',$userid)->Update(['is_confirm'=>0, 'otp' => mt_rand(1000,9999)]);

                         Mail::to($request->email)->send(new signupApiMail($user));
                              return ['status'=>1, 'message' => 'Please check your mail for OTP that has been sent to verify your account and continue the registration process.', 'user_id'=>$user->id];
                        
                      }elseif($user->is_confirm == 1){
                          return ['status'=>1, 'message' => 'Profile has been updated successfully.'];
                      }else{
                          $update_otp = User::where('id',$userid)->update(['otp' => mt_rand(1000,9999)]);
                          Mail::to($request->email)->send(new signupApiMail($user));
                            return ['status'=>1, 'message' => 'Your account is not confirmed yet. Please confirm your account.We have sent you otp in your mail to confirm your account','user_id' => $user->id];
                      }
                    } 
                  }

                
            }else{  
                return ['status'=>0, 'message' => 'User does not exist.','user'=>[]];
            }  
        }


       } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
       } 
    }



/**
 * @api {post} /api/update-profile-photo User update profile
 * @apiName Postupdateprofilephoto
 * @apiGroup Donars/Students
 *
 * @apiParam {integer} user_id for user id.
 * @apiParam {String}  profile_photo cloudenry profile image link  
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Profile has been updated successfully."
 *     }
 *
 */
    public function updateprofilephoto(Request $request) 
    { 
     try {   
        if($request->isMethod('post'))  
        {
            $validator=Validator::make($request->all(),[
                    'user_id'=> 'required',   
                    'profile_image'=> 'required',                
            ]);  
            if($validator->fails()) {
                return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
            $user = User::where('id',$request->user_id)
            ->where('is_deleted',0)
            ->first();
            if($user){
               if($user->status == '0'){
                    return response()->json(["status" => 0, "message"=>'Your account is not activated. Please activate your account.']);     
                } 
                User::where('id',$request->user_id)->update(['profile_image'=>$request->profile_image]);
                 
                 $userprofile = User::where('id',$request->user_id)->where('is_deleted',0)->first();
                 $profilePhoto = $userprofile->profile_image;
                return ['status'=>1, 'message' => 'Profile photo updated successfully.', 'profile_image' =>$profilePhoto];
            }else{  
                return ['status'=>0, 'message' => 'User does not ewxist.','user'=>[]];
            }  
        }


       } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
       } 
    }





/**
 * @api {post} /api/update-settings User update profile
 * @apiName updateUserSettings
 * @apiGroup Profile/User setting
 *
 * @apiParam {integer} user_id for user id.
 * @apiParam {String}  due_date_notification for due date notifications
 * @apiParam {String}  loan_notification     for loan notifications
 * @apiParam {String}  personal_notification for personal notifications
 * @apiParam {String}  email_notification    for email notifications
 * @apiParam {String}  support_notification  for supprt notifications
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Settings has been updated successfully."
 *     }
 *
 */
    public function updateUserSettings(Request $request) 
    { 
     try {   
        if($request->isMethod('post'))  
        {
           $validator=Validator::make($request->all(),[
                    'user_id'=> 'required',                 
            ]);  
            if($validator->fails()) {
                return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
            $user = UserSettings::where('user_id',$request->user_id)->first();
            if($user){
                $UpdateSettings = UserSettings::findOrNew($user->id);
                $UpdateSettings->due_date_notification = $request->due_date_notification;
                $UpdateSettings->loan_notification = $request->loan_notification;
                $UpdateSettings->personal_notification = $request->personal_notification;
                $UpdateSettings->email_notification = $request->email_notification;
                $UpdateSettings->support_notification = $request->support_notification;
                $UpdateSettings->save();            
                return ['status'=>1, 'message' => 'Settings has been updated successfully.'];
            }else{                 
                $UpdateSettings = new UserSettings();
                $UpdateSettings->user_id = $request->user_id;
                $UpdateSettings->due_date_notification = $request->due_date_notification;
                $UpdateSettings->loan_notification = $request->loan_notification;
                $UpdateSettings->personal_notification = $request->personal_notification;
                $UpdateSettings->email_notification = $request->email_notification;
                $UpdateSettings->support_notification = $request->support_notification;
                $UpdateSettings->save();              
           
                return ['status'=>1, 'message' => 'Settings has been updated successfully.'];
            }  
        }


       } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
       } 
    }




/**
 * @api {post} /api/user-setting User profile
 * @apiName getUserSetting
 * @apiGroup User/getUserSetting
 *
 * @apiParam {Integer} user_id unique user id.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *    {
 *  "status": 1,
    "message": "success",
    "user": {
        "id": 3,
         ........
         ........

    }
}

 *
 */
    public function getUserSetting(Request $request) 
    { 
     try {      
        if($request->isMethod('post'))  
        {
            $validator=Validator::make($request->all(),[
                'user_id'=> 'required',    
            ]);  
            
            if($validator->fails()) {
                return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
            $user =UserSettings::where('user_id',$request->user_id)->first();
            if(!empty($user)){
                return['status'=>1,'message'=>'success','user_settings'=>$user];
            }else{
                return['status'=>1,'message'=>'success','user_settings'=>[]];
            }
        } 
      } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
      }
    }



    
}
