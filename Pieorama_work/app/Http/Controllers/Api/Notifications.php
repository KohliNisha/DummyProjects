<?php

namespace App\Http\Controllers\Api;
use Validator;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;

class Notifications extends Controller
{
/**
 * @api {post} /api/get-notification Change Password
 * @apiName securityQuestionList  
 * @apiGroup Signup
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1, 
 *       "message": "notifications list"
 *     }
 *
 */
    public function getNotificationList(Request $request)
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
            $Notificationlist = Notification::where('recipient_id', $request->user_id)->orderby('id','DESC')->get();
             return ['status' => 1,'message' =>'notifications list', 'notifications' =>$Notificationlist];
           
        }

        } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    } 


    /**
 * @api {post} /api/read-notification read Notification
 * @apiName readNotification  
 * @apiGroup Notificaion
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1, 
 *       "message": "notifications list"
 *     }
 *
 */
    public function readNotification(Request $request)
    {    
     try {
        if($request->isMethod('post'))  
        {
            $validator=Validator::make($request->all(),[
                     'notification_id'=> 'required', 
            ]);             
            if($validator->fails()) {
                 return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
              Notification::where('id',$request->notification_id)->update(['is_read_on_click'=>1]);
              return ['status' => 1,'message' =>'Read notifications'];           
        }

        } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    } 



  /**
 * @api {post} /api/read-all-notification read all Notification
 * @apiName readNotification  
 * @apiGroup Notificaion
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1, 
 *       "message": "notifications list"
 *     }
 *
 */
    public function readAllNotification(Request $request)
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
              Notification::where('recipient_id',$request->user_id)->update(['is_read_on_click'=>1]);
              return ['status' => 1,'message' =>'Read notifications']; 
        }

        } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    } 




}
