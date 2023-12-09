<?php
namespace App\Http\Controllers\Api;
use http\Env\Response;
use http\Message;
use Validator;
use App\Models\User;
use App\Models\Usernotification;
use App\Models\Userlocation;
use App\Models\ContactUs;
use App\Models\UserLoginLog;
use App\Models\UserDeviceTokenLog;
use Illuminate\Http\Request;
use App\Mail\SignupMail;
use App\Mail\signupApiMail;
use App\Mail\Forgotpassword;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
class UsersignupController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 401;
    
 
/**
 * @api {post} /api/register User Registration
 * @apiName PostRegisterUser
 * @apiGroup Registration/User
 * @apiParam {String} first_name User first name.
 * @apiParam {String} last_name User last name.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Please click on the link that has been sent to your email account to verify your email and continue the registration process."
 *     }
 *
 */
   public function register(Request $request)
    {
      try {
            if($request->isMethod('post'))
            {
                $validator=Validator::make($request->all(),[
                         'first_name'=> 'required',
                        // 'last_name' => 'required',
                         'email'    =>  'required|email|unique:users',
                         'password'  => 'bail|required|min:8',
                         'device_token'  =>'required',
                         'device_type'  =>'required',

                ]);
                if($validator->fails()) {
                     return ['Error' => ['status'=>0, 'ErrorCode' => 404,'message'=>$validator->errors($request[0])->first()]];
                }
                $user=new User;
                $user->first_name=$request->first_name;
                $user->last_name=$request->last_name;
                $user->email=$request->email;
                $user->date_of_birth=$request->date_of_birth;
                $user->device_token=$request->device_token;
                $user->device_type=$request->device_type;
                $user->signupstep=1;
                $user->status=1;
                $user->is_confirm=0;
                $user->auth_token=mt_rand();
                $user->last_time_used=now();
                $user->password=Hash::make($request->password);
                $user->user_role= 2;
                $user->otp = mt_rand(1000,9999);
               if($user->save())
                {
                    //$url =  url('/')."/activate-account/".encrypt($user->id.':'.$user->auth_token);
                    Mail::to($user->email)->send(new signupApiMail($user));
                   return ['status'=>1, 'message' => 'Please check your mail for OTP that has been sent to verify your account and continue the registration process.', 'user_id'=>$user->id];
                } else {
                   return ['Error'=> ['ErrorCode' => 404,'status'=>0, 'message' => 'oops! Somthing went wrong. Please try again.','user'=>'']];

                }
            }
        } catch (\Exception $e) {
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }
   

/**
 * @api {post} /api/social-login User Registration
 * @apiName Postsociallogin
 * @apiGroup Registration/sociallogin
 * @apiParam {String} first_name User first name.
 * @apiParam {String} last_name User last name.
 * @apiParam {String} email User  unique email. 
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *      {
 *       "status": 1,
 *       "message": "login success."
 *     }
 *
 */
     public function sociallogin(Request $request)
    {
      try {
        if($request->isMethod('post'))
        {
            $validator=Validator::make($request->all(),[
                     'first_name'=> 'required',
                    // 'last_name' => 'required',
                     'signup_source'=>'required',
                     'source_id' =>'required',
                     'device_token'  =>'required',
                     'device_type'  =>'required',

            ]);
            if($validator->fails()) {
                 return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }

            if($request->signup_source == 'facebook'){
                 $signup_source = "facebook_id";
            }else if($request->signup_source == 'google'){
                $signup_source = "google_id";
            }else if($request->signup_source == 'twitter'){
                $signup_source = "twitter_id";
            }else if($request->signup_source == 'linkedin'){
                $signup_source = "linkedin_id";
            }else if($request->signup_source == 'instagram'){
                $signup_source = "instagram_id";
            }
            if($request->email !=""){
                $user = User::where('email',$request->email)->orWhere($signup_source,$request->source_id)
                ->where('user_role',2)->first();
            } else {
                $user = User::where($signup_source,$request->source_id)->where('user_role',2)->first();
            }

            if($user){
                   if($user->is_deleted == 1){
                     return ["status" => 0, "message"=>'Your account has been deleted by admin.  Please contact support@pieorama.com we are happy to help you.'];
                    } else if ($user->status == 0){
                        return [
                            'status' =>0,
                            'message'=>'Pieorama has deactivated your account.  Please contact support@pieorama.com we are happy to help you.',
                            'user' => $user
                            ];
                    }

                    // Check if user has already signup with normal email and he gets signup with social login  and gets same email from social source as registred our db then update source id for that email id if he/she has also confirmed email status
                    if($request->email !=""){
                       $SourceIdcheck= User::where($signup_source,$request->source_id)->where('user_role',2)->where('is_deleted',0)->first();
                       if(!$SourceIdcheck){
                           $EmailConfirmcheck= User::where('email',$request->email)->where('user_role',2)->where('is_deleted',0)->first();
                           if($EmailConfirmcheck){
                              User::where('email',$request->email)->update([$signup_source=>$request->source_id]);
                           }
                       }
                    }

                     User::where('id',$user->id)->update(['device_token'=>$request->device_token,'device_type'=>$request->device_type??1,'last_time_used'=>now()]);
                        return [
                            'status' => 1,
                            'message'=>'login successfully.',
                            'user' => $user
                            ];

            } else {

                    $userRegister=new User;
                    if($request->email !=""){
                     $userRegister->email=$request->email;
                    }
                    $userRegister->first_name=$request->first_name;
                    $userRegister->last_name=$request->last_name;
                    $userRegister->$signup_source=$request->source_id;
                    $userRegister->device_token=$request->device_token;
                    $userRegister->device_type=$request->device_type??1;
                    $userRegister->is_confirm=1;
                    $userRegister->status=1;
                    $userRegister->signupstep=1;
                    $userRegister->last_time_used=now();
                    $userRegister->user_role= 2;
                    if($userRegister->save())
                    {
                        $user = User::where('id',$userRegister->id)->where('user_role',2)->where('is_deleted',0)->first();
                        User::where('id',$user->id)->update(['device_token'=>$request->device_token,'device_type'=>$request->device_type,'last_time_used'=>now()]);
                        return [
                            'status' => 1,
                            'message'=>'login successfully.',
                            'user' => $user
                            ];
                 } else {
                   return ['status'=>0, 'message' => 'oops! Something went wrong. Please try again.','user'=>''];
                       }
            }
        } else {
           return ['status'=>0, 'message' => 'Your method is wrong.','user'=>''];
           }

        } catch (\Exception $e) {
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }




      
/**
 * @api {post} /api/login user login
 * @apiName Postlogin
 * @apiGroup User/login
 * @apiParam {string} username User  email or mobile no.
 * @apiParam {string} password User  password.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "login success."
 *     }
 *
 */
 public function login(Request $request){ 
     try {  
        if($request->isMethod('post')) {           
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
                'device_token'  =>'required',
                'device_type'  =>'required'  
            ]);
            if($validator->fails()) {
               return ['Error' => ['status'=>0, 'ErrorCode' => 404, 'message'=>$validator->errors($request[0])->first()]];
            }
            $credentials = $request->only('username', 'password');
            $user = User::select('id','first_name','last_name','profile_image','email','password','phone_code','phone_number','date_of_birth','is_phone_verify','is_confirm','signupstep','device_token','device_type','attempt','status','hide_dob','last_login','created_at','is_deleted','updated_at')
                    ->where('email',$request->username)
                  //  ->orWhere('phone_number',$request->username)
                    ->where('user_role','!=',1)
                    ->first();
           // $remember=$request->input('remember')?true:false;
            if (!empty($user)) {
                if(Hash::check($request->password,$user->password)){
                        $user->id = !empty($user->id)?$user->id:'';
                        $user->first_name = !empty($user->first_name)?$user->first_name:'';
                        $user->last_name = !empty($user->last_name)?$user->last_name:'';
                        $user->phone_code = !empty($user->phone_code)?$user->phone_code:'';
                        $user->phone_number = !empty($user->phone_number)?$user->phone_number:'';
                        $user->profile_image = !empty($user->profile_image)?$user->profile_image:'';
                        $user->date_of_birth = !empty($user->date_of_birth)?$user->date_of_birth:'';
                        $user->is_confirm = !empty($user->is_confirm)?$user->is_confirm:'';
                        $user->signupstep = !empty($user->signupstep)?$user->signupstep:'';
                        $user->status = !empty($user->status)?$user->status:'';
                        $user->last_login = !empty($user->last_login)?$user->last_login:'';
                        $user->device_token = !empty($request->device_token)?$request->device_token:'';
                        $user->device_type = !empty($request->device_type)?1:1;
                        $user->hide_dob = !empty($request->hide_dob)?$request->hide_dob:'';
                        $user->created_at = !empty($user->created_at)?$user->created_at:'';
                        $user->updated_at = !empty($user->updated_at)?$user->updated_at:'';

                    if($user->is_deleted == 1){
                         return ['Error' => ["ErrorCode" => 502, "status" => 0, "message"=>'Your account has been deleted by admin.  Please contact support@pieorama.com we are happy to help you.']];
                     } else if($user->is_confirm == 0){
                         return ['Error' => ['ErrorCode'=> 504,'status'=>0,'message' =>'Your email address has not been verified. Please check your email and verify to complete account setup.']];
                     }

                    if($user->status == 1){
                        $outh_token=Helper::updateUserToken($user->id);
                        User::where('id',$user->id)->update(['attempt'=>0,'access_token'=>$outh_token,'device_token'=>$request->device_token,'device_type'=>$request->device_type,'last_time_used'=>now()]);
                       
                        //Insert login Log                   
                          $UserLoginLog = new UserLoginLog();
                          $UserLoginLog->user_id= $user->id;
                          $UserLoginLog->status= 0;
                          $UserLoginLog->save();
                        
                        //Insert device token log                   
                          $UserDeviceTokenLog = new UserDeviceTokenLog();
                          $UserDeviceTokenLog->user_id= $user->id;
                          $UserDeviceTokenLog->device_token= $request->device_token;
                          $UserDeviceTokenLog->device_os= $request->device_type;
                          $UserDeviceTokenLog->created_by= $user->id;
                          $UserDeviceTokenLog->save();
                        return [
                            'status' => 1,
                            'message'=>'login success',
                            'oauthToken' => $outh_token,
                            'user' => $user
                            ];
                    }else{
                        return ['Error' => ['ErrorCode' => 502,'status'=>0,'message' =>'Pieorama has deactivated your account. Please contact support@pieorama.com we are happy to help you.']];
                    }

                } else {
                    return ['Error' => ['ErrorCode' => 404,'status'=>0,'message' =>"Incorrect email or password used. Please try again or click Forgot password to reset your password."]];
                }

            } else {
                return ['Error' => ['ErrorCode' => 404,'status'=>0,'message'=>'Incorrect email or password used. Please try again or click Forgot password to reset your password.' ]];
            }
        }

        } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }       
    }  


/**
 * @api {post} /api/resend-confirm-email User Registration
 * @apiName resendConfirmEmail
 * @apiGroup resendConfirmEmail()
 * @apiParam {String} email User  unique email.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Account confirmation email sent to your registered email address."
 *     }
 *
 */
    public function resendConfirmEmail(Request $request) 
    {   
      try {     
        if($request->isMethod('post'))  
        {
            $validator=Validator::make($request->all(),[
                     'email'    =>  'required|email', 
            ]);              
            if($validator->fails()) {
                 return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }  
            $userExist= User::where('email',$request->email)->where('is_confirm',1)->first();
            if($userExist){
                return ['status'=>0, 'message' => 'Your email is already verified please login with your email address.',];
            } 
            $user= User::where('email',$request->email)->first();
            $url =  url('/')."/activate-account/".encrypt($user->id.':'.$user->auth_token);
            Mail::to($user->email)->send(new SignupMail($user,$url));        
           return ['status'=>1, 'message' => 'Thank you! We have sent email on your email address please confirm the email address for sign in to continue'];       
         } 

       } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
       }
    } 




/**
 * @api {post} /api/mobile-verification Mobile verification
 * @apiName Postmobile-verification
 * @apiGroup Donars/Students
 *
 * @apiParam {integer} id User  unique id.
 * @apiParam {integer} otp User  otp.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Your number verified successfully."
 *     }
 *
 */
    public function mobileVerification(Request $request)
    {
        try {

            $otp = $request->otp;
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'otp' => 'required',
                'type' => 'required'

            ]);
            if ($validator->fails()) {
                return response()->json(["Error" => ["ErrorCode" => 404 ,"status" => 0, "message" =>$validator->errors($request[0])->first()]]);
            }

            if(!empty($otp)){
            $user = User::where(function ($query) use ($otp) {
                $query->where('otp', '=', $otp);
            })->where('id',$request->user_id)->first();

            if(!empty($user))
            {
                $user->is_phone_verify='1';
                $user->status='1';
                $user->is_confirm='1';
                $user->auth_token=mt_rand();
                if($user->save()){
                /*User::where('id', '!=',$request->user_id)
                      ->where('phone_number',$user->phone_number)->update(['phone_number'=>'', 'phone_code'=>'']);*/
                    if($request->type == 1) {
                        return ['status' => 1, 'message' => 'Your account has been verified successfully.', 'user' => $user];
                     }elseif($request->type == 2){
                        return ['status' => 1, 'message' => 'Your OTP has been verified successfully.', 'user' => $user];
                    }
                }
            }else{
                return ['Error' => ['ErrorCode' => 404, 'status'=>0,'message'=>'Please enter valid OTP.']];
            }
          }else{

            return ['Error' => ['ErrorCode' => 404, 'status'=>0,'message'=>'Please enter OTP.']];
          }
        } catch (\Exception $e) {
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }


/**
 * @api {post} /api/resend-otp-profile Resend otp
 * @apiName PostgetresendOtp
 *
 * @apiParam {integer} user_id User  unique id.
 * @apiParam {integer} phone_code mobile country code.
 * @apiParam {integer} phone_number mobile no.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Otp has been resent sucessfully on your mobile."
 *     }
 *
 */
 
public function resendOtpforUpdateProfile(Request $request)
{
 try {
    $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'phone_code' => 'required',
            'phone_number' => 'required',

        ]);
    if ($validator->fails()) {
        return response()->json(["status" => 0, "message" =>$validator->errors($request[0])->first()]);
    }

    $user = User::where('id', $request->user_id)->first();
    if(!empty($user)){

         $userExist= User::where('phone_number',$request->phone_number)
            ->where('is_phone_verify',1)
            ->where('user_role',2)
            ->where('is_deleted',0)
            ->first();
            if($userExist){
                return ['status'=>0, 'message' => 'Mobile number. already associated with another account please use another mobile number or reset your password.','user'=>''];
            }

        $otp = rand(1000,9999);
        User::where('id',$request->user_id)->update(['otp'=>$otp]);
        $message = "pieorama: Your verification code is ".$otp;
        $to = $request->phone_code.''.$request->phone_number;
        $response = Helper::sendSms($to, $message);
        //print_r($response); die;
        $userData = ['id'=>$user->id,'otp'=>$otp,'phone_code'=>$request->phone_code,'phone_number'=>$request->phone_number];
        return response()->json(["status" => 1, "message" =>'OTP has been resent successfully on your mobile.', 'user' => $userData]);
    }else{
        return response()->json(["status" => 0, "message" =>'id does not exist.']);
    }

    } catch (\Exception $e) { 
        return ['status'=> 0, 'message' => [$e->getMessage()]];
    }
}








/**
 * @api {post} /api/resend-otp Resend otp
 * @apiName PostgetresendOtp
 *
 * @apiParam {integer} user_id User  unique id.
 * @apiParam {integer} phone_code mobile country code.
 * @apiParam {integer} phone_number mobile no.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Otp has been resent sucessfully on your mobile."
 *     }
 *
 */
 
public function resendOtp(Request $request)
{
 try {
    $validator = Validator::make($request->all(), [
            //'user_id' => 'required',
            'email' => 'required',
            'type'  => 'required'
           // 'phone_number' => 'required',

        ]);
    if ($validator->fails()) {
        return response()->json(["status" => 0, "message" =>$validator->errors($request[0])->first()]);
    }

    $user = User::where('email',$request->email)->first();
    //dd($user);
    if(!empty($user)){
        if($request->type == 1) {                                                   // type1 for registeration account
            $userExist = User::where('email', $request->email)                      // type2 for Password reset
                ->where('is_phone_verify', 1)
                ->where('is_confirm', 1)
                ->where('user_role', 2)
                ->where('is_deleted', 0)
                ->first();
            if ($userExist) {
                return ['status' => 0, 'message' => 'This account has already been verified'];
            }
        }
        $otp = rand(1000,9999);
        if($request->type == 1) {
        $updateUser = User::where('email',$request->email)->update(['otp'=>$otp]);
         $user = User::where('email',$request->email)->first();
         Mail::to($user->email)->send(new signupApiMail($user));
        }elseif($request->type == 2){
            $token = str_shuffle(md5(time()));
            $updateUser = User::where('email',$request->email)->update(['otp'=>$otp,'password_reset_token' => $token]);
            $user = User::where('email',$request->email)->first();
            Mail::to($request->email)->send(new ForgotPassword($user));
        }
        /*$message = "Pieorama: Your verification code is ".$otp;
        $to = $request->email;*/

        //$response = Helper::sendSms($to, $message);
        //print_r($response); die;
        //$userData = ['id'=>$user->id];
        return response()->json(["status" => 1, "message" =>'OTP has been resent successfully. Please check your Mail.']);
    }else{
        return response()->json(["status" => 0, "message" =>'User Id does not exist.']);
    }

    } catch (\Exception $e) {
        return ['status'=> 0, 'message' => [$e->getMessage()]];
    }
}
   

/** 
 * @api {post} /api/forgot-password forgot password
 * @apiName PostforgotPassword
 * @apiGroup Donars/Students
 *
 * @apiParam {string} email User  unique email or phone number.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Otp has been sent sucessfully on your registered email and mobile."
 *     }
 *
 */
 
    public function forgotPassword(Request $request)
    {
      try {
        $validator = Validator::make($request->all(), [
                'email' => 'required'
            ]);
        if ($validator->fails()) {
            return response()->json(["Error" => ["ErrorCode" => 404, "status" => 0, "message" =>$validator->errors($request[0])->first()]]);
        }
        //$user = User::where('email', $request->email)->first();
        $user = User::where('email', $request->email)
                    ->orWhere('phone_number', $request->email)
                    ->first();
        if(!empty($user)){
            if($user->status == '0'){
                return response()->json(["status" => 0, "message"=>'Your account is not activated.  Please contact support@pieorama.com we are happy to help you.']);     
            }

         
            $token = str_shuffle(md5(time()));
            $user->password_reset_token = $token;
            $user->otp = rand(1000,9999);
            $user->save();
              $user = $user->toArray();
            Mail::to($request->email)->send(new ForgotPassword($user));
            $userData = array('id'=>$user['id'],'otp'=>$user['otp'],'phone_number'=>$user['phone_number']);
            return response()->json(["status" => 1, "message" =>'OTP has been sent successfully on your registered email.']);

        }else{
            return response()->json(["status" => 0, "message" =>'Email address does not exist.']);
        }

     } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
     }
        
    }













/**
 * @api {post} /api/changePassword Change Password
 * @apiName PostchangePasswordUser
 * @apiGroup Donars/Students
 *
 * @apiParam {String} email User  unique email.
 * @apiParam {String} old_password User  old password.
 * @apiParam {String} new_password User  new password.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Password has been changed successfully."
 *     }
 *
 */

    public function changePassword(Request $request)
    {
     try {

        if($request->isMethod('post'))  
        {
            $validator=Validator::make($request->all(),[
                     'user_id'=> 'required',
                     'old_password' => 'required',
                     'new_password'    =>  'required|min:8',
            ]); 
            if($validator->fails()) {
                 return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
            $userExist = User::where('id', $request->user_id)->first();
            if(!empty($userExist)){
                if(Hash::check($request->old_password,$userExist->password)) {
                    $password = Hash::make($request->new_password);
                    User::where('id',$userExist->id)->update(['password'=>$password]);
                    return [
                        'status' => 1,
                        'message' =>'Password has been changed successfully.',
                        ];
                }else{
                    return ['status' => 0,'message' =>'Old password does not match.'];
                }
            }else{
                return ['status' => 0,'message' =>'User id does not exist.'];
            }
        }
       } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    } 
  



/**
 * @api {post} /api/setNewPassword Change Password
 * @apiName PostsetNewPassword
 * @apiGroup Donars/Students
 *
 * @apiParam {String} email User  unique email.
 * @apiParam {String} new_password User  new password.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Password has been changed successfully."
 *     }
 *
 */

    public function setNewPassword(Request $request)
    {
     try {
        if($request->isMethod('post'))  
        {
            $validator=Validator::make($request->all(),[
                     'user_id'=> 'required',
                     'new_password'    =>  'required|min:8',
            ]); 
            if($validator->fails()) {
                 return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
            $userExist = User::where('id', $request->user_id)->first();
            if(!empty($userExist)){     
                    $password = Hash::make($request->new_password);
                    User::where('id',$userExist->id)->update(['password'=>$password]);
                    return [
                        'status' => 1,
                        'message' =>'Password has been updated successfully.',
                        ];              
            }else{
                return ['status' => 0,'message' =>'User id does not exist.'];
            }
        }
       } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    } 








    public function activateAccount(Request $request, $token)
    {
        try {
            $token = decrypt($token);
            $user_id_token = explode(':', $token);
            $user = User::where('id',$user_id_token[0])
                        ->where('auth_token',$user_id_token[1])
                        ->first();
            if(!empty($user))
            {
                $user->is_confirm='1';
                $user->status='1';
                $user->auth_token='';
                if($user->save()){
                    return ['status'=> 1, 'message' => 'Your account activated successfully.'];
                }
                return ['status'=> 0, 'message' => 'Not a valid link.'];
            }
            return ['status'=> 0, 'message' => 'Not a valid link.'];
        } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }




/**
 * @api {post} /api/reset Reset password
 * @apiName Postreset
 * @apiGroup Donars/Students
 *
 * @apiParam {string} password User  user password.
 * @apiParam {integer} id User  user id.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Passwor has been reset successfully."
 *     }
 *
 */
   /* public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
                       'password'  => 'bail|required|min:8',
                       'id'  => 'required',
            ]);
        if ($validator->fails()) { 
            return response()->json(["status" => 0, "message" => $validator->errors($request[0])->first()]);
        }
        $user = User::where('id', $request->id)->first();
        if (!$user) {
            return response()->json(["status" => 0, "message" => 'Invalid id supplied']);
        }
        $user->password_reset_token = '';
        $user->otp = '';
        $user->password = Hash::make($request->password);
        $user->save();
        $blankdata =[];
        return response()->json(["status" => 1, "message" =>'Password has been reset successfully.','user' =>$blankdata]);
    }*/


public function ResetPassword(Request $request){

        try{
            if($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'email' => 'required',
                    'password' => 'required|min:8',
                    'confirm_password' => 'required'
                ]);
                if ($validator->fails()) {
                    return ['Error' => ['ErrorCode' => 404, 'message' => $validator->errors($request[0])->first()]];
                }
                if($request->password == $request->confirm_password){
                    $updatePassword = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
                }else{
                    return ['Error' => ['ErrorCode' => 404, 'message' => 'The password confirmation does not match.']];
                }

                if ($updatePassword) {
                    return response()->json(['status' => 1, 'message' => 'Password has been reset successfully']);
                } else {
                    return response()->json(['status' => 0, 'message' => 'oops! Something went Wrong.']);
                }
            }else{
                return response()->json(['Error' => ['ErrorCode' => 404,'status' => 0, 'message' => 'Method not allowed.']]);
            }
        }catch(\Exception $e){
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }




/**
 * @api {post} /api/checkEmailExist Change Password
 * @apiName PostcheckEmailExist
 * @apiGroup Donars/Students
 *
 * @apiParam {String} email User  unique email.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "successfullly login."
 *     }
 *
 */
/*public function checkEmailExist(Request $request)
{
    $validator = Validator::make($request->all(), [
            'email' => 'required'
        ]);
    if ($validator->fails()) {
        return response()->json(["status" => 0, "message" =>$validator->errors($request[0])->first()]);
    }
    $user = User::where('email', $request->email)->first();
    if(!empty($user)){
        if($user->signup_source !='App'){
            if($user->college_name !='' && $user->id_card_image !=''){
                $user->is_completed = 1;
            }else{
                $user->is_completed = 0;
            }
            $resultData = ['id'=>$user->id,'email'=>$user->email,'first_name'=>!empty($user->first_name)?$user->first_name:'','last_name'=>!empty($user->last_name)?$user->last_name:'','status'=>$user->status,'phone_code'=>!empty($user->phone_code)?$user->phone_code:'','phone_number'=>!empty($user->phone_number)?$user->phone_number:'','source_id'=>!empty($user->source_id)?$user->source_id:'','signup_source'=>!empty($user->signup_source)?$user->signup_source:'','profile_image'=>!empty($user->profile_image)?$user->profile_image:'','college_name'=>!empty($user->college_name)?$user->college_name:'','id_card_image'=>!empty($user->id_card_image)?$user->id_card_image:'','mobile_verified'=>$user->mobile_verified,'otp'=>0,'is_completed'=>$user->is_completed];
            return response()->json(["status" => 1, "message" =>'Successfullly login.', 'user' => $resultData]);
        }else{
            return response()->json(["status" => 0, "message" =>'This email id already registered.']);     
        }
    }else{
        return response()->json(["status" => 0, "message" =>'id does not exist.']);
    }
}*/

}
