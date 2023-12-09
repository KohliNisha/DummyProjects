<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Validator;
use App\Models\User;
use App\Models\UserSettings;
use App\Helpers\Helper;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminToUser;
use Illuminate\Support\Facades\Storage;


class QueryController extends Controller
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
    public function index(Request $request) {
      if (!Auth::guard('admin')->check()) {
           return redirect()->route("admin.login");
       }
      
       //return view('Admin.query.querylist',compact('contactus'));
   }
    public function querylist(Request $request){ 
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        } 
       // User::where('name','LIKE','%'.$q.'%')->orWhere('email','LIKE','%'.$q.'%')->get();

        $queryContact = ContactUs::query();
        //Add sorting
        $queryContact->orderBy('id','DESC');
        $keyword=[];
        if( $request->isMethod('post') ) {
        //Add Conditions
         if(!is_null($request['keyword'])) {
             $queryContact->where('first_name','LIKE','%'.$request['keyword'].'%');
             $keyword = $request['keyword'];
         }
         //dd($queryContact);
        }
         
        // if(!is_null($request['state_id'])) {
        // $queryContact->whereHas('profile',function($q) use ($request){
        // return $q->where('state_id','=',$request['state_id']);
        // });
        // }

        // if(!is_null($request['city_id'])) {
        // $queryContact->whereHas('profile',function($q) use ($request){
        // return $q->where('city_id','=',$request['city_id']);
        // });
        // }
        //Fetch list of results
        $contactus = $queryContact->get();
        // return ['Result' => 'OK',
        //     'TotalRecordCount' => $contactus->count(),
        //     'Records' => $contactus->toArray()];
            
       return view('Admin.query.querylist',compact(['contactus','keyword']));
    }


    public function getqqqqqq()
    {
        $contactus = ContactUs::get();
        dd($contactus);
        return response()->json(['Result' => 'OK',
            'TotalRecordCount' => $contactus->count(),
            'Records' => $contactus->toArray()]);


    }

    public function viewcontactus(Request $request,$id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
            }
            if( $request->isMethod('post') ) {
                $validator = Validator::make($request->all(), [
                    'message' => 'required',
                    'id' => 'required',                  
                ]);
                if($validator->fails()) {
                    //return back()->withErrors($validator->errors());
                    return back()->withInput()->withErrors($validator->errors());
                }
                $adminSession = Auth::guard('admin')->User();
                $contact = new ContactUs();
                $existcontact = ContactUs::where('id',$request->id)->first();
                $broadcast_message =$request->broadcast_message; 
                $usersToken = User::select('id','device_token')->where('is_deleted', 0)->where('status', 1)->where('email', $existcontact->email)->whereNotNull('device_token')->get();
                 $usersTokenCount = User::select('id','device_token')->where('is_deleted', 0)->where('status', 1)->where('email', $existcontact->email)->whereNotNull('device_token')->count();
                    /*if($usersToken){
                      foreach ($usersToken as $value) {
                          // $device_token[] = $value->device_token;
                             if($usersTokenCount > 0){ 
                               $UserSettings = UserSettings::where('user_id', $value->id)->first();    
                                $notification_data['sender_id']=$value->id;
                                $notification_data['recipient_id']=$value->id;
                                $notification_data['message_id']=8;
                                $notification_data['type']=1; 
                                $notification_data['message_data']='The Plendify Team has replied to your query. Please check your email.';
                                $notification_data['send_push']=true;
                                Helper::createNotification($notification_data);
                                   
                            } 
                        }
                    }*/


                //$contact->first_name= $adminSession->first_name;
                // $contact->last_name= $adminSession->last_name;
                //$contact->email= $adminSession->email;
                //$contact->message= $request->message;
                //$contact->subject= $request->subject;
                //if($contact->save()){
                    $updateData = ['status'=>1];
                    ContactUs::where('id',$request->id)->update($updateData);
                    Mail::to($existcontact->email)->send(new AdminToUser($existcontact,$request->message));
                    return redirect('admin/query')->with('message', 'You have replied successfully on query!');
                // }else{
                //     return redirect()->back()->with('error', 'Internal error occurred!');
                // }
            }
        $contactus = ContactUs::where('id',$id)->first();
        return view('Admin.query.viewcontactus',compact('contactus'));
    }
}
