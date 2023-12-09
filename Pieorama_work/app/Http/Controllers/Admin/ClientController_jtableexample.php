<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Exception;
use Validator;
use App\Models\User;
use App\Models\UserAddress;
use App\Helpers\Helper;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function clientlist(){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }       
        return view('Admin.clients.clientlist',compact('users'));
    }




   public function clientajaxlist(Request $request){  
         try {         
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $order=isset($request->jtSorting)?$request->jtSorting:'id DESC';
                $orderBy = explode(" ", $order);           
                  $userQuery = User::query(); 
                   if(isset($request->status) && $request->status!=''){
                                   $userQuery->where(function ($query) use($request){
                                    $query->where('user_role',2)  
                                          ->where('status',$request->status)                      
                                          ->where('is_deleted',0);
                                });
                              
                    } else {
                           $userQuery->where(function ($query){
                           $query->where('user_role',2)                         
                             ->where('is_deleted',0);
                       });
                    }  
                if(isset($request->keyword) && $request->keyword!=''){
                  $userQuery->where(function ($query) use($request){
                        $query->orWhere( 'first_name', 'LIKE', '%'. $request->keyword .'%')
                            ->orWhere( 'last_name', 'LIKE', '%'. $request->keyword .'%')
                            ->orWhere( 'email', 'LIKE', '%'. $request->keyword .'%')
                            ->orWhere( 'phone_number', 'LIKE', '%'. $request->keyword .'%')
                            ->orWhere('created_at', 'LIKE', '%' . $request->keyword . '%');
                    });  
                }
                $usersCountArray = $userQuery->get();
                $users = $userQuery->offset($offset)->limit($limit)->orderBy($orderBy[0], $orderBy[1])->get()->toArray();
                $UserCount = $usersCountArray->count(); 
                $sno=$offset;
                $user_data=array();
                foreach($users as $user){
                    $sno++;
                    $user['sno']=$sno; 
                    $user['created_at'] = date('Y-m-d', strtotime($user['created_at'])); 
                    array_push($user_data,$user);
                }
                // end code of serial number
                $data["Result"] = "OK";
                $data["Records"] = Helper::html_filterd_data($user_data);
                $data["TotalRecordCount"] = $UserCount;
                echo json_encode($data);
                die;   
            }catch (\Exception $e) { 
                dd($e);
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }
     }


    public function clientdetails(Request $request,$id){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $user = User::where('id',$id)->first();       
        return view('Admin.clients.clientdetails',compact('user'));
    }

    public function accountactivationstatus(Request $request){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = User::where('id',$request->userid)->first();   
               if($request->statuskey == 1){
                    if($request->activestatus == 1){
                        $updateData = ['is_confirm'=>0];
                        $message ='Email has been unverified successfully.';
                    }else{
                        $updateData = ['is_confirm'=>1];
                        $message ='Email has been verified successfully.';
                    }
               }else if($request->statuskey == 2){
                    if($request->accountactiveStatus == 1){
                        $updateData = ['status'=>0];
                        $message ='Account has been deactivated successfully.';
                    }else{
                        $updateData = ['status'=>1];
                        $message ='Account has been activated successfully.';
                    }
                }else if($request->statuskey == 3){
                    $oldEmail = $userexist->email;
                    $oldPhone_number = $userexist->phone_number;
                    $enailwithDelete = $oldEmail."_deleted" ;
                    $phonewithDelete = $oldPhone_number."_0000" ;
                    $updateData = ['is_deleted'=>1,'phone_number'=>$phonewithDelete,'email'=>$enailwithDelete];
                    $message ='Account has been deleted successfully.';
               }
                User::where('id',$userexist->id)->update($updateData);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
    }


    public function updateclient(Request $request,$id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = User::where('id',$request->userid)->first();   
               if($request->statuskey == 1){
                    if($request->activestatus == 1){
                        $updateData = ['is_confirm'=>0];
                        $message ='Email has been unverified successfully.';
                    }else{
                        $updateData = ['is_confirm'=>1];
                        $message ='Email has been verified successfully.';
                    }
               }else if($request->statuskey == 2){
                    if($request->accountactiveStatus == 1){
                        $updateData = ['status'=>0];
                        $message ='Account has been deactivated successfully.';
                    }else{
                        $updateData = ['status'=>1];
                        $message ='Account has been activated successfully.';
                    }
                }else if($request->statuskey == 3){
                    $updateData = ['is_deleted'=>1];
                    $message ='Account has been deleted successfully.';
               }
                User::where('id',$userexist->id)->update($updateData);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
        $user = User::where('id',$id)->first();
        dd($user);
        return view('Admin.clients.updateprofile',compact('user'));

    }



    public function userEdit(Request $request,$id)
    {   
        $id = base64_decode($id);
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $profile = User::where('id',$id)->first();
        $address = UserAddress::where('user_id',$id)->first();
        if(!$profile){
            return back()->with('message', 'Sorry! I think you are in worng path.');
        }
        $session = Auth::guard('admin')->User();
        $user_id = $session->id;
        if( $request->isMethod('post') ) {           
            $validator = Validator::make($request->all(), [
                'first_name' =>   'required|max:255',
                'email' =>   'required|email',
                'date_of_birth' =>   'required',
            ]);  
            if($validator->fails()) {
              return back()->withErrors($validator->errors($request[0])->first());
            }       
            if($request->hasfile('profile_image')){
                /*$image = $request->file('profile_image');
                $name = $request->file('profile_image')->getClientOriginalName();
                $image_name = $request->file('profile_image')->getRealPath();
                $path = public_path().'/uploads/';
                $image->move($path, $name);
                $profile_image = $name;*/
                $extension =  $request->file('profile_image')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('profile_image'), time().rand().'.'.$extension, 'public');
                $profile_image = config('constants.DO_STORAGE_URL').$path;
            }else{
                $profile_image = $profile->profile_image;     
            }
            $date_of_birth = date("Y-m-d", strtotime($request->date_of_birth));
            
            $updateData = ['first_name'=>$request->first_name,'last_name'=>$request->last_name,'profile_image'=>$profile_image,'email'=>$request->email,'date_of_birth'=>$date_of_birth,  'phone_code'=>$request->phone_code, 'phone_number'=>$request->phone_number, 'gender'=>$request->gender];
            User::where('id',$id)->update($updateData);
                       
            $updateAddressData = ['user_id'=>$id,'address_1'=>$request->address_1,'address_2'=>$request->address_2,'city'=>$request->city,'state'=>$request->state,'country'=>$request->country,'pin_code'=>$request->pin_code];
            if($address){
                 UserAddress::where('user_id',$id)->update($updateAddressData);
            } else {
                  UserAddress::insert($updateAddressData); 
            }
            return back()->with('message', 'Profile has been updated successfully!');
        }        
        return view('Admin.clients.useredit',compact('profile','address'));
    }




/**
 * @api {post} /api/mobile-verification-by-admin Mobile verification
 * @apiName Postmobile-verification
 * @apiGroup 
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
    public function mobileVerificationByAdmin(Request $request)
    {
        try {
            
            $otp = $request->otp;
            $user = User::where(function ($query) use ($otp) {
                $query->where('otp', '=', $otp);
            })->where('id',$request->user_id)->first();
            if(!empty($user))
            {
                $user->is_phone_verify='1';
                $user->status='1';
                $user->auth_token=mt_rand();
                if($user->save()){

                User::where('id', '!=',$request->user_id)
                      ->where('phone_number',$user->phone_number)->update(['phone_number'=>'', 'phone_code'=>'']);

                    return ['status'=> 1, 'message' =>'Your mobile number has been verified successfully.'];
                }
            }else{
                return ['status'=>0,'message'=>'Please enter valid OTP.'];
            }
        } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }

}
