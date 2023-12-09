<?php

namespace App\Http\Controllers\Site;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;
use App\Models\PieChannel;
use App\Models\PieVideo;
use App\Models\Usernotification;
use App\Models\UserAddress;
use App\Models\Userlocation;
use App\Models\Countries;
use App\Mail\SignupMail;
use App\Mail\Forgotpassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UsersignupController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Socialite;
use Exception;
use App\Helpers\Helper;
class ProfileController extends Controller
{

    public function __construct()
    {

    }

    public function profile(){    
        if (!Auth::user()) {
           return redirect('home');
       }
       $userid = Auth::user()->id;
       $user =  User::where('id',$userid)->first();
       $userAddress = UserAddress::where('user_id', $userid)->first();
       $videoDetails = PieVideo::where('status',1)->where('is_deleted',0)->where('created_by',$userid)->get();
       $countries = Countries::all();
       $id_exist = Helper::badgedata($userid);      
        
       //dd($userAddress->toArray());
       return view('Site.my-profile.my-profile',['user'=>$user,'userAddress'=>$userAddress,'videoDetails'=>$videoDetails, 'countries' => $countries, 'id_exist' => $id_exist]);
   }

    public function pieoramaFriendsList(Request $request){    
        if (!Auth::user()) {
           return redirect('home');
       }
       $userid = Auth::user()->id;
       if ($request->search == 'friends') { 

           //will be fetch user's friend in this array
          $searchedusers = ''; 
          $user =  User::where('id',$userid)->first();
          $userAddress = UserAddress::where('user_id', $userid)->first();
          return view('Site.my-pieorama-friends.my-pieorama-friends',['user'=>$user,'userAddress'=>$userAddress, 'searchedusers'=>$searchedusers]);
    
       } else{          
            $limit=50;
            $offset=0; 
            $order='id DESC';
            $orderBy = explode(" ", $order);           
            $userQuery = User::query(); 
            $userQuery->where(function ($query) use($request){
              $query->where('user_role',2)  
              ->where('status',1)                      
              ->where('is_deleted',0);
            });
            if(isset($request->search) && $request->search!=''){
              $userQuery->where(function ($query) use($request){
                  $userName = $request->search ;
                  $arrayname = explode(" ", $userName);
                  $first_name = $arrayname[0];
                  if(isset($arrayname[1])){
                    $last_name = $arrayname[1];
                     $query->orWhere( 'first_name', 'LIKE', '%'. $first_name .'%')
                     ->Where( 'last_name', 'LIKE', '%'. $last_name .'%');
                   } else {
                     $query->orWhere( 'first_name', 'LIKE', '%'. $first_name .'%');
                   }   
                });  
            }
            $usersCountArray = $userQuery->get();
            $searchedusers = $userQuery->offset($offset)->limit($limit)->orderBy($orderBy[0], $orderBy[1])->get()->toArray();

         
          $user =  User::where('id',$userid)->first();
          $userAddress = UserAddress::where('user_id', $userid)->first();
          return view('Site.my-pieorama-friends.my-pieorama-friends',['user'=>$user,'userAddress'=>$userAddress, 'searchedusers'=>$searchedusers]);
       } 

         
       return view('Site.my-pieorama-friends.my-pieorama-friends',['user'=>$user,'userAddress'=>$userAddress]);
    }



    /**
     * Create User under the pericular user role id
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function UpdateProfile(Request $request) {

        try {
           $userid = Auth::user()->id;
          // print_r($request->all()); die;
            
            if ($request->ajax()) {
                $validator = Validator::make($request->except("_token"), [
                            'first_name' => 'required',
                            'last_name' => 'required',
                           // 'city' => 'required',
                            'country' => 'required',
                ],[
                       'first_name.required' => 'The first name field is required.', 
                       'last_name.required' => 'The last name field is required.', 
                        
                ]);
                if ($validator->fails()) {
                    return response()->json([
                                'status' => false,
                                'message' => $validator->errors()
                    ]);
                }
                      
                $data = $request->except('_token'); 
                $user = User::where('id', $userid)->first();
                if($user->date_of_birth != ''){
                  $date_of_birth = $user->date_of_birth;
                }else{
                   $date_of_birth = date("Y-m-d", strtotime($request->date_of_birth));
                }
                
                
                $UserAddress = UserAddress::where('user_id', $userid)->first();

                if($UserAddress){
                    $update_address = UserAddress::where('user_id',$userid)->Update(['city'=>$request->city,'state'=>$request->state,'country'=>$request->country]); 
                } else {
                      $dataAddress['user_id'] = $userid;
                      $dataAddress['city'] = $request->city;
                      $dataAddress['state'] = $request->state;
                      $dataAddress['country'] = $request->country;                   
                      UserAddress::create($dataAddress);
                }

               if($request->hasfile('profile_image')){


                /*
                // upload admin server image code 
                $image_name = $request->file('profile_image')->getRealPath(); 
                $extension = $request->file('profile_image')->getClientOriginalExtension();
                if (function_exists('curl_file_create')) { 
                  $cFile = curl_file_create($image_name);
                } else { 
                  $cFile = '@' . realpath($image_name);
                }
                $post = array('file_path' => 'uploads', 'extension' => $extension,'media_file'=> $cFile);

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, config('constants.MEDIA_UPLOAD_API_FOR_ADMIN'));
                curl_setopt($ch, CURLOPT_POST,1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $result=curl_exec ($ch);
                curl_close ($ch);
                $server_output_arr=(array) json_decode($result);                
                if ($server_output_arr['status'] ==1 && $server_output_arr['filename'] !="") {
                  $image_url =   $server_output_arr['filename'] ; 
                } else  {
                  $image_url = $user->profile_image;
                }*/
                $size = getimagesize($request->file('profile_image'));
                $width = $size[0];
                $height = $size[1];
                if($width > 512 && $height > 512){
                  $image_error = 'Image size must be smaller than 512 * 512.';
                }else{

                  $extension =  $request->file('profile_image')->extension();
                  $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('profile_image'), time().'.'.$extension, 'public');
                  $image_url = config('constants.DO_STORAGE_URL').$path;
                }
               

               }else  {
                  $image_url = $user->profile_image;
                }
              
                 $update_profile = User::where('id',$userid)->Update(['first_name'=>$request->first_name,'last_name'=>$request->last_name,'date_of_birth'=>$date_of_birth,'profile_image'=>$image_url, 'gender'=>$request->gender]);            

                  /*if($update_profile){
                    if($user->email){
                      if($user->email != $request->email){
                          $update_is_Confirm = User::where('id',$userid)->Update(['is_confirm'=>0]);
                        $url =  url('/')."/activate-account/".encrypt($user->id.':'.$user->auth_token);
                         Mail::to($request->email)->send(new SignupMail($user,$url));
                        
                      }
                    } 
                  }*/

                return response()->json([
                            'status' => true,
                            'message' => 'Profile has been updated successfully.'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                        'status' => false,
                        'image_error' => $image_error,
                        'message' => [
                            "err" => $e->getMessage()
                        ]
            ]);
        }
    }

   // Pieorama user profile
    public function otherUserProfile(Request $request, $user_id){    
        if (!Auth::user()) {
           return redirect('home');
       }              
       $userid = base64_decode(base64_decode($user_id));
       $user =  User::where('id',$userid)->first();
       $userAddress = UserAddress::where('user_id', $userid)->first();
       $videoDetails = PieVideo::where('status',1)->where('is_deleted',0)->where('created_by',$userid)->get();
       //dd($userAddress->toArray());
       return view('Site.other-user-profile.other-user-profile',['user'=>$user,'userAddress'=>$userAddress,'videoDetails'=>$videoDetails]);
   }




  public function changepassword(Request $request){    
    if (!Auth::user()) {
       return redirect('home');
   }
    if($request->isMethod('post'))  
    {
        $userid = Auth::user()->id;
        $request->validate([
                'current_password' => 'required',
                'new_password'    =>  'required|min:3|max:20',
                're_enter_password' => 'required|min:3|max:20|same:new_password',
            ]); 
        $userExist = User::where('id',$userid)->first();
        if(!empty($userExist)){
            if(Hash::check($request->current_password,$userExist->password)) {
                $password = Hash::make($request->new_password);
                User::where('id',$userExist->id)->update(['password'=>$password]);
                return redirect()->back()->with('message', 'Password has been changed successfully.'); 
            }else{
                return back()->withErrors(['current_password' => ['Current password does not match.']]);
            }
        }
    }
   $pageTitle= 'Change Password';
   return view('Site.profile.change-password')->with ('pageTitle',$pageTitle);
  //return view('Site.profile.change-password',[]);
  }




  

}
