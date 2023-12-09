<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Notification;
use Exception;
use Validator;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Storage;
class NotificationController extends Controller
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
    // public function index() {
    //     if (!Auth::guard('admin')->check()) {
    //          return redirect()->route("admin.login");
    //      }
    //      return view('Admin.notification.notificationlist');
    //  }
    public function notificationlist(){  

        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
       $notifications = Notification::with('userdetals')->get();
       return view('Admin.notification.notificationlist',compact('notifications'));
    }

    public function deletenotification(Request $request)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $notification = Notification::where('id',$request->notificationid)->first();   
               $message ='Notification has been deleted successfully.';
               Notification::where('id',$notification->id)->delete();
               return ['status'=>1,'message'=>$message]; 
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
    }


    public function broadcastmessage(Request $request){            
            if (!Auth::guard('admin')->check()) {
                return redirect()->route("admin.login"); 
                }
                       
              if( $request->isMethod('post') ) {
                try {  
                $broadcast_message =$request->broadcast_message; 
                $usersToken = User::select('id','device_token')->where('is_deleted', 0)->where('status', 1)->whereNotNull('device_token')->get();
                $usersTokenCount = User::select('id','device_token')->where('is_deleted', 0)->where('status', 1)->whereNotNull('device_token')->count();
                    if($usersToken){
                      foreach ($usersToken as $value) {
                          // $device_token[] = $value->device_token;
                             if($usersTokenCount > 0){  
                                $notification_data['sender_id']=$value->id;
                                $notification_data['recipient_id']=$value->id;
                                $notification_data['message_id']=7;
                                $notification_data['type']=1; 
                                $notification_data['message_data']=$broadcast_message; 
                                $notification_data['send_push']=true;
                                Helper::createNotification($notification_data);
                              //  die("test");         
                            } 

                        }
                    }
                                 
                return ['success'=> 1, 'message' => "Broadcast message sent successfully!"];
            } catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }  
         

        }
       $notifications = Notification::with('userdetals')->get();
       return view('Admin.notification.broadcastmessage',compact('notifications'));
    }



}
