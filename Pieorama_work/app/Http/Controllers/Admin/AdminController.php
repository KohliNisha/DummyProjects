<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Validator;
use Auth;
use App\Models\User;
use App\Mail\ForgetPasswordOfAdmin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\Helper as Helper;
class AdminController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // if (Auth::guard('admin')->check()) {
        //     return redirect()->route("admin.dashboard");
        // }
    }

    protected $redirectTo = 'admin/dashboard';
    protected function guard() {
        return Auth::guard("admin");
    }

   /* protect function guard(){
        return Auth::admin('admin')
    }
*/
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route("admin.dashboard");
        }
        if( $request->isMethod('post') ) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',                
            ]);
            if($validator->fails()) {
              $message = $validator->errors($request[0])->first();
              return redirect('/admin')->with('status', $message);
            }
           

             Auth::guard('admin')->logout();
             $request->session()->invalidate();
             $request->session()->flush();

            $credentials = $request->only('email', 'password');
            $credentials['user_role']=2;
            $user = User::where('email',$request->email)
                    ->where('user_role',1) 
                    ->first();    
                     
            $remember=$request->input('remember')?true:false;
            if (!empty($user)) {                
                if(Hash::check($request->password,$user->password)) {  
                                      
                    if($user->status == 1){
                        Auth::guard('admin')->login($user);
                        //Auth::login($user, true);
                        $request->session()->put('admin_session', $user);

                        return redirect('admin/dashboard');
                    }else{
                      $message = "Your account is not activated, Please activate your account.";
                      return redirect('/admin')->with('status', $message);
                         
                    }   
                }else{
                    $message = "Email or password is incorrect.";
                    return redirect('/admin')->with('status', $message);
                }
            } else {
                    $message = "Email or password is incorrect.";
                    return redirect('/admin')->with('status', $message);
            } 
        }
        return view('Admin.signup.login',[]);
    }

    public function login()
    {
        return view('Admin.signup.login',[]);
    }


    public function forgotpassword(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route("admin.dashboard");
        }
       // echo "check email"; die;
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',               
            ]);
            if($validator->fails()) {
                return back()->withErrors($validator->errors($request[0])->first());
            }
            $userExist = User::where('email',$request->email)->where('user_role',1)->first();
            if(!empty($userExist)){ 
                $url =  url('/')."/admin/reset-password/".encrypt($userExist->id.':'.$userExist->auth_token);
              //  print_r($url); die;
                Mail::to($userExist['email'])->send(new ForgetPasswordOfAdmin($userExist,$url));
                $message = "Reset password link has been sent to your registerd email addrsss!";
                return back()->with('message', $message);
            }else{
                $message = "Email address does not exist!";
                return back()->withErrors($message);
            }
        } 
        return view('Admin.signup.forgotpassword',[]);
    }





    public function reset_password(Request $email)
    {
         if(isset($email->email)){
           $data = decrypt($email->email);
         } else {
            $message = "Link is not valid.";
            return redirect('/admin')->with('status', $message);  
         }

         $array=explode(':', $data); 
       //echo "<pre/>"; print_r($array); die;   
         if($array[0] == "" || $array[1] == ""){
            $message = "Link is not valid.";
            return redirect('/admin')->with('status', $message); 
         }

         $user_check = User::where('id',$array[0])->first();
        if($user_check){
            if($user_check->auth_token != $array[1]){
              $message='Your link has been expired';              
              return view('Admin.signup.linkexpired', compact('message'));              
             }else {
               $urlcode = $email->email; 
               return view('Admin.signup.changepassword', compact('message','urlcode'));          
     
     /*       $email_verify = User::where('id',$array[0])
              ->Update(['is_confirm'=>1,'status'=>1]);
              $message='Your account has been verified successfully';
              Mail::to($user_check->email)->send(new WelcomeEmail($user_check,$message));*/
        
           
           }
        } else {
              $message = "Link is not valid.";
             return redirect('/admin')->with('status', $message);
        }

         return view('Site.website.activate-account.mail_status', compact('message',
            'user_check'));
    }




    public function setnewpassword(Request $request)
    {

        if($request->isMethod('post')){
               
                $validator = Validator::make($request->all(), [
                    'password' => 'required',   
                    'cpassword' => 'required',
                    'urlcode' => 'required',            
                ]);  

                $data = decrypt($request->urlcode);
                $array=explode(':', $data); 
               //echo "<pre/>"; print_r($array); die;   
                 if($array[0] == "" || $array[1] == ""){
                    $message = "Link is not valid.";
                    return redirect('/admin')->with('status', $message); 
                 }
                $user_check = User::where('id',$array[0])->first();
                if($user_check){
                   // echo "check"; die;
                    if($user_check->auth_token != $array[1]){
                      $message='Your link has been expired';              
                      return back()->with('message', $message);                     
                     }else {
                      $password = Hash::make($request->password);
                      $rand = rand();
                      $update_password = User::where('id',$array[0])->Update(['password'=>$password,'auth_token'=>$rand]);
                      $message = "Password set successfully. Please login now.";
                      return redirect('/admin')->with('success_status', $message);
                   
                   }
                } else {
                      $message = "Link is not valid.";
                     return redirect('/admin')->with('status', $message);
                }
        }

         return back()->with('message', $message);
    }





}
