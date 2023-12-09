<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Exception;
use Validator;
use App\Models\User;
use App\Models\PieTags;
use App\Models\PieVideoTags;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TagsController extends Controller
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

    public function tagsList(){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }       
        return view('Admin.tags.tagsList');
    }


    public function tagajaxlist(Request $request){  
         try {   
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $order=isset($request->jtSorting)?$request->jtSorting:'id ASC';
                $orderBy = explode(" ", $order);           
                  $userQuery = PieTags::query(); 
                   if(isset($request->status) && $request->status!=''){
                                   $userQuery->where(function ($query) use($request){
                                    $query->where('is_deleted',0);
                                });                              
                    } else {
                           $userQuery->where(function ($query){
                           $query->where('is_deleted',0);
                       });
                    }  
                if(isset($request->keyword) && $request->keyword!=''){
                  $userQuery->where(function ($query) use($request){
                        $query->orWhere( 'tag_text', 'LIKE', '%'. $request->keyword .'%');
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



    public function deletetag(Request $request){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = PieTags::where('id',$request->userid)->first();   
               if($request->statuskey == 1){
                    if($request->activestatus == 1){
                        $updateData = ['is_confirm'=>0];
                        $message ='Tags has been unverified successfully.';
                    }else{
                        $updateData = ['is_confirm'=>1];
                        $message ='Tags has been verified successfully.';
                    }
               }else if($request->statuskey == 2){
                    if($request->accountactiveStatus == 1){
                        $updateData = ['status'=>0];
                        $message ='Tags has been deactivated successfully.';
                    }else{
                        $updateData = ['status'=>1];
                        $message ='Tags has been activated successfully.';
                    }
                }else if($request->statuskey == 3){
                    $oldEmail = $userexist->email;
                    $oldPhone_number = $userexist->phone_number;
                    $enailwithDelete = $oldEmail."_deleted" ;
                    $phonewithDelete = $oldPhone_number."_0000" ;
                    $updateData = ['is_deleted'=>1];
                    $message ='Tags has been deleted successfully.';
               }
                PieTags::where('id',$userexist->id)->update($updateData);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
    }





}
