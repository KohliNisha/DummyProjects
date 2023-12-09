<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Exception;
use Validator;
use App\Models\User;
use App\Models\PieChannel;
use App\Models\PieVideo;
use App\Models\PieTags;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class ChannelsController extends Controller
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

    public function channelList(){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }       
        return view('Admin.channels.channelList');
    }

    public function channelajaxlist(Request $request){  
         try {   
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $order=isset($request->jtSorting)?$request->jtSorting:'id ASC';
                $orderBy = explode(" ", $order);           
                  $userQuery = PieChannel::query(); 
                   if(isset($request->status) && $request->status!=''){
                                   $userQuery->where(function ($query) use($request){
                                    $query->where('status',$request->status)
                                          ->where('is_deleted',0);
                                });                              
                    } else {
                           $userQuery->where(function ($query){
                           $query->where('is_deleted',0);
                       });
                    }  
                if(isset($request->keyword) && $request->keyword!=''){
                  $userQuery->where(function ($query) use($request){
                        $query->orWhere( 'channel_title', 'LIKE', '%'. $request->keyword .'%');
                           // ->orWhere('created_at', 'LIKE', '%' . $request->keyword . '%');
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

    public function channelAdd(Request $request){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }        
        $user_id = Auth::guard('admin')->user()->id;
        $channeltags = PieTags::whereNull('deleted_at')
                       ->groupBy('tag_text')
                        ->get();
        //dd($channeltags);
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'channel_title' =>   'required|max:255',
                'states' =>   'required|max:555',
                //'logo_file' => 'required',
            ]);            
            if($validator->fails()) {
              return back()->withInput()->withErrors($validator->errors());
            }
            //dd($request->all());
            $arr = $request->states;
            $data_array = json_encode($arr);
                    
            
            $PieChannel = new PieChannel();
            $PieChannel->created_by= $user_id ;  
            $PieChannel->channel_title= $request->channel_title; 
            $PieChannel->tags_id= $data_array; 
            $PieChannel->comment_note= $request->comment_note; 
            $PieChannel->channel_description= $request->channel_description;  
            if($request->hasfile('logo_file')){
                $image = $request->file('logo_file');
                $name = $request->file('logo_file')->getClientOriginalName();
                $image_name = $request->file('logo_file')->getRealPath();
                $path = public_path().'/uploads/';
                $image->move($path, $name);
                $file_name = $name;
                $file_size = '';
                $file_mime_type = '';  
            }else{
                $file_name = '';
                $file_size = '';
                $file_mime_type = '';
            }
            $PieChannel->status= 1 ;  
            $PieChannel->channel_logo_img= $file_name ; 
            if($PieChannel->save()){
                return redirect('admin/channels')->with('message', "Channel has added successfully");
            }else{
                return redirect()->back()->with('error', 'Internal error occurred!');
            }
        }
        return view('Admin.channels.channelAdd',compact('channeltags'));
    }

     public function editChannel(Request $request,$id)
    {   
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $profile = PieChannel::where('id',$id)->first();
        if($profile){
            $profile->ids = json_decode($profile->tags_id);
        }
       // dd($profile);
        $channeltags = PieTags::whereNull('deleted_at')
                       ->groupBy('tag_text')
                       ->get();

        if(!$profile){
            return back()->with('message', 'Sorry! I think you are in worng path.');
        }
        $session = Auth::guard('admin')->User();
        $user_id = $session->id;
        if( $request->isMethod('post') ) {           
            $validator = Validator::make($request->all(), [
                'channel_title' =>   'required|max:255',
                'states' =>   'required|max:555',
            ]);  
            if($validator->fails()) {
              return back()->withErrors($validator->errors($request[0])->first());
            }   

            if($request->hasfile('logo_file')){
                $image = $request->file('logo_file');
                $name = $request->file('logo_file')->getClientOriginalName();
                $image_name = $request->file('logo_file')->getRealPath();
                $path = public_path().'/uploads/';
                $image->move($path, $name);
                $file_name = $name;
                $file_size = '';
                $file_mime_type = '';  
            }else{
                $file_name = $profile->channel_logo_img;
                $file_size = $profile->file_size;
                $file_mime_type = $profile->file_mime_type;
            }
            $arr = $request->states;
            $tags_id = json_encode($arr);

            $updateData = ['channel_title'=>$request->channel_title,'tags_id' => $tags_id, 'comment_note'=>$request->comment_note,'channel_description'=>$request->channel_description,'channel_logo_img'=>$file_name,'updated_by'=>$user_id];
            PieChannel::where('id',$id)->update($updateData);
            return redirect('admin/channels')->with('message', "Channel has been updated successfully.");
        }        
        return view('Admin.channels.channelEdit',compact('profile','channeltags'));
    }


     public function Channelactivationstatus(Request $request){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = PieChannel::where('id',$request->userid)->first();   
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
                        $message ='Channel has been deactivated successfully.';
                    }else{
                        $updateData = ['status'=>1];
                        $message ='Channel has been activated successfully.';
                    }
                }else if($request->statuskey == 3){
                    $deleted_at = date('Y-m-d h:i:s');
                    $updateData = ['is_deleted'=>1,'deleted_at'=>$deleted_at];
                    PieVideo::where('pie_channel_id',$userexist->id)->update($updateData);
                    $message ='Channel has been deleted successfully.';
               }
                PieChannel::where('id',$userexist->id)->update($updateData);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
    }

}
