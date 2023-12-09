<?php

namespace App\Http\Controllers\Api;
use Validator;
use App\Models\User;
use App\Models\Faq;
use App\Models\Cms;
use App\Models\ContactUs;
use App\Models\Library;
use App\Models\LibraryUsed;
use App\Models\PieChannel;
use App\Models\UserLoginLog;
use App\Models\UserDeviceTokenLog;
use Illuminate\Http\Request;
use App\Mail\ContactUsSendToAdmin;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;

class MasterController extends Controller
{





  /**
   * @api {post}/library-item-list 
   * @apiName library item list  
   * @apiGroup Master
   * @apiVersion 0.0.1 
   * @apiSuccess {integer} file_type 1=>Image, 2=>Audio, 3=>Video
   * @apiSuccess {String} message  Success message
   * @apiSuccessExample Success-Response:
   *     HTTP/1.1 200 OK
   *     {
   *       "status": 1, 
   *       "message": "library list"
   *     }
   *
   */ 
   public function librarylist(Request $request){  
         try { 
              if($request->isMethod('post'))  
              {  
                  $validator=Validator::make($request->all(),[
                           'file_type' => 'required|integer',
                           'offset' => 'required|integer',
                           'limit' => 'required|integer',
                  ]);             
                  if($validator->fails()) {
                       return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
                  }
                $limit = $request->limit;               
                $offset=$request->offset; 
                $order='id DESC';
                $orderBy = explode(" ", $order);           
                $userQuery = Library::with('usedlibrary');              
                $userQuery->where(function ($query) use ($request){
                          $query->where('file_type',$request->file_type)
                                ->where('is_delete',0);
                });
                if(isset($request->keyword) && $request->keyword!=''){
                  $userQuery->where(function ($query) use($request){
                        $query->orWhere( 'title', 'LIKE', '%'. $request->keyword .'%');
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
                    $user['used_by_user_count'] = count($user['usedlibrary']); 
                    $user['created_at'] = date('Y-m-d', strtotime($user['created_at'])); 
                    $user['file_size'] = Helper::formatSizeUnits($user['file_size']); 
                    array_push($user_data,$user);
                }              
                $data["success"] = 1;
                $data["TotalRecordCount"] = $UserCount;
                $data["Records"] = Helper::html_filterd_data($user_data);                
                echo json_encode($data);
                die;
              } else {
                return ['success'=> 0, 'message' => 'Please select post method'];
              } 
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }
    }

  /*
   * @api {post}/channel-list
   * @apiName channel item list  
   * @apiGroup Master
   * @apiVersion 0.0.1 
   * @apiSuccess {String} message  Success message
   * @apiSuccessExample Success-Response:
   *     HTTP/1.1 200 OK
   *     {
   *       "status": 1, 
   *       "message": "channel list"
   *     }
   *
   */
   public function channelList(Request $request){  
         try {        
                if($request->isMethod('post'))  
                {  
                  $validator=Validator::make($request->all(),[
                           'offset' => 'required|integer',
                           'limit' => 'required|integer'
                  ]);             
                  if($validator->fails()) {
                       return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
                  }              
                $limit = $request->limit;
                $offset=$request->offset; 
                $order='id DESC';
                $orderBy = explode(" ", $order);           
                $userQuery = PieChannel::query();               
                $userQuery->where(function ($query) use ($request){
                          $query->where('status',1)
                                ->where('is_deleted',0);
                });
                if(isset($request->keyword) && $request->keyword!=''){
                  $userQuery->where(function ($query) use($request){
                        $query->orWhere( 'channel_title', 'LIKE', '%'. $request->keyword .'%');
                    });  
                }
                $usersCountArray = $userQuery->get();
                $users = $userQuery->offset($offset)->limit($limit)->orderBy($orderBy[0], $orderBy[1])->get()->toArray();
                $UserCount = $usersCountArray->count(); 
                $sno=$offset;
                $user_data=array();
                foreach($users as $user){
                    $user['created_at'] = date('Y-m-d', strtotime($user['created_at'])); 
                    array_push($user_data,$user);
                }              
                $data["success"] = 1;
                $data["TotalRecordCount"] = $UserCount;
                $data["Records"] = Helper::html_filterd_data($user_data);                
                echo json_encode($data);
                die;   
              } else {
                return ['success'=> 0, 'message' => 'Please select post method'];
              }  
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }
    }

  // $ChannelDetails = PieChannel::where('status',1)->where('is_deleted',0)->get();

  /**
   * @api {post} /api/library-use-item 
   * @apiName useOfLibrary
   * @apiGroup api/useOfLibrary
   * @apiParam {integer} user_id User id.
   * @apiParam {library_id} library_id library id.
   * @apiVersion 0.0.1 
   * @apiSuccess {integer} status 1
   * @apiSuccess {String} message  Success message
   * @apiSuccessExample Success-Response:
   *     HTTP/1.1 200 OK
   *     {
   *       "status": 1,
   *       "message": "Successfully"
   *     }
   */
    public function useOfLibrary(Request $request) 
    {   
      try {      
        if($request->isMethod('post'))  
          {  
            $validator=Validator::make($request->all(),[
                     'user_id'=> 'required',
                     'library_id' => 'required',
            ]);             
            if($validator->fails()) {
                 return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
            $LibraryUsed=new LibraryUsed;
            $LibraryUsed->user_id=$request->user_id;
            $LibraryUsed->media_id=$request->library_id;
            $LibraryUsed->library_id=$request->library_id;
            if($LibraryUsed->save())
            {                
             return ['status'=>1, 'message' => 'Thank you for choosing the our library item.'];
            } else {
             return ['status'=>0, 'message' => 'Somthing went worng. Please try again.'];
            }
          }

        } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }



/**
 * @api {post} /api/faq Change Password
 * @apiName faq  
 * @apiGroup Signup
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1, 
 *       "message": "faq list"
 *     }
 *
 */
    public function faq(Request $request)
    {
     try {
        if($request->isMethod('post'))  
        {
            $QuesExist = faq::where('status', '1')->where('is_deleted', '0')->get();
            if(!empty($QuesExist)){
                        $QuesExist->id = !empty($QuesExist->id)?$QuesExist->id:'';
                        $QuesExist->question = !empty($QuesExist->question)?$QuesExist->question:'';                                        
                    return ['status' => 1,'message' =>'Faq list', 'questions' =>$QuesExist];
                
            }else{
                return ['status' => 0,'message' =>'Question does not exist.'];
            }
        }

        } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    } 



/**
 * @api {post} /api/pages for privacy policy and terms and conditions
 * @apiName pages
 * @apiGroup pages
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1, 
 *       "message": "data"
 *     }
 *
 */
    public function pages(Request $request)
    {
     try {
        if($request->isMethod('post'))  
        {
            $contents = cms::where('status', '1')->
                              where('is_deleted', '0')->
                              where('slug',$request->slug)->
                              get();
            if(!empty($contents)){
                        $contents->id = !empty($contents->id)?$contents->id:'';
                        $contents->title = !empty($contents->title)?$contents->title:'';
                        $contents->content = !empty($contents->content)?$contents->content:'';                                        
                    return ['status' => 1,'message' =>'data', 'data' =>$contents];
                
            }else{
                return ['status' => 0,'message' =>'No data'];
            }
        }

        } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }





/**
 * @api {post} /api/media-upload upload media files
 * @apiName Postmediaupload
 * @apiGroup api/media-upload
 * @apiParam {String} first_name User first name.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "media upload successfully"
 *     }
 *
 */
    public function mediaupload(Request $request) 
    {   
      try {      
        if($request->isMethod('post'))  
        {

            $validator=Validator::make($request->all(),[
                     'file_path'=> 'required',
                     'extension'=> 'required', 
                     'media_file'=> 'required',                               
                                   
            ]);             
            if($validator->fails()) {
                 return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
              if($request->hasFile('media_file')){
                  $file_path = $request->file_path;
                  $videofile = $request->file('media_file');                     
                  $videofile_name = rand().$videofile->getClientOriginalName().".".$request->extension; 
                  $video_path = public_path()."/$file_path/";                     
                  $uploadvideo = $videofile->move($video_path, $videofile_name);
                }
              return ['status'=>1, 'filename'=>$videofile_name, 'message' => 'Media uploaded successfully.'];            
        } 

        } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }







/**
 * @api {post} /api/contact-us Help and support
 * @apiName PostcontactUs
 * @apiGroup api/contactUs
 * @apiParam {String} first_name User first name.
 * @apiParam {String} last_name User last name.
 * @apiParam {String} email User  unique email.
 * @apiParam {String} phone_code User  phone code.
 * @apiParam {String} phone_number User  phone number.
 * @apiParam {String} related_to Query related to.
 * @apiParam {String} message user message.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Contact information sent successfully"
 *     }
 *
 */
    public function contactUs(Request $request) 
    {   
      try {      
        if($request->isMethod('post'))  
        {

            $validator=Validator::make($request->all(),[
                     'first_name'=> 'required',
                     'last_name' => 'required',
                     'email'    =>  'required|email',                     
                     'phone_code'  =>'required',
                     'phone_number'  =>'required',
                     'related_to'  =>'required',                    
                     'message'  => 'required',             
                                   
            ]);             
            if($validator->fails()) {
                 return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
            $contactus=new ContactUs;
            $contactus->first_name=$request->first_name;
            $contactus->last_name=$request->last_name;
            $contactus->email=$request->email;
            $contactus->phone_code=$request->phone_code;
            $contactus->phone_number=$request->phone_number;            
            $contactus->related_to=$request->related_to;
            $contactus->message=$request->message;
            if($contactus->save())
            {                
              Mail::to("support@pieorama.com")->send(new ContactUsSendToAdmin($contactus));
              //  $url =  url('/')."api/  activate-account/".encrypt($user->id.':'.$user->auth_token);
              //  Mail::to($user->email)->send(new SignupMail($user,$url));
              return ['status'=>1, 'message' => 'Thank you! Your message was sent successfully.'];
            } else {
              return ['status'=>0, 'message' => 'Somthing went worng. Please try again.'];

            }
        } 

        } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }
    





    


/**
 * @api {post} /api/logout for logout user
 * @apiName logout  
 * @apiGroup logout
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1, 
 *       "message": "You have logout successfully"
 *     }
 *
 */
    public function logout(Request $request)
    {
     try {
        if($request->isMethod('post'))  
        {
            $oauthtoken = $request->header('OAUTH-TOKEN'); 
            $user= User::where('id',$request->user_id)
            ->where('user_role',2)
            ->where('is_deleted',0)
            ->first();
            if($user){
                if($user->device_token == $request->device_token){
                  User::where('id',$user->id)->update(['device_token'=>'', 'device_type'=>'0']);
                }
                if($user->access_token == $oauthtoken){
                     User::where('id',$user->id)->update(['access_token'=>'']);
                }

                 //Insert logout Log                   
                  $UserLoginLog = new UserLoginLog();
                  $UserLoginLog->user_id= $user->id;
                  $UserLoginLog->status= 1;
                  $UserLoginLog->save();
                  // Update device token delete status
                  UserDeviceTokenLog::where('device_token',$request->device_token)->orWhere('user_id',$user->id)->update(['is_deleted'=>1,'deleted_at'=>now()]);

                return ['status' => 1,'message' =>'You have logout successfully'];

           } else {
                    return ['status' => 0,'message' =>'User does not exist.'];
                }

        }
  
        } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    } 





}
