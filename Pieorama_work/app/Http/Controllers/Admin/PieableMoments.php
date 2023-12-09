<?php

namespace App\Http\Controllers\Admin;
use Auth;
use Exception;
use Validator;
use App\Models\User;
use App\Models\PiableMoments;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JD\Cloudder\Facades\Cloudder;
use VideoThumbnail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PieableMoments extends Controller
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

  

     public function pieableList(){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }

        return view('Admin.pieable.libraryList');
    }



    public function addPieable(Request $request){           
         
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }        
        $user_id = Auth::guard('admin')->user()->id; 
       //echo $user_id ; die; 
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
               
                'video_title' =>   'required|max:255',
                'video_description' =>   'max:5555',
                'meta_description' =>   'max:5555',
                
            ]);            
            if($validator->fails()) {
              return back()->withInput()->withErrors($validator->errors());
            }  
            if($request->hasfile('video_file')){
                $extension =  $request->file('video_file')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('video_file'), time().rand().'.'.$extension, 'public');
                $filename = config('constants.DO_STORAGE_URL').$path; 
            } 
            if($request->hasfile('original_video')){
                $extension =  $request->file('original_video')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('original_video'), time().rand().'.'.$extension, 'public');
                $original_video_name = config('constants.DO_STORAGE_URL').$path;  
              }
             
             if($request->hasfile('thumb_file')){
                 $extension =  $request->file('thumb_file')->extension();
                 $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('thumb_file'), time().rand().'.'.$extension, 'public');
                 $thumb_filename = config('constants.DO_STORAGE_URL').$path;              
              } 
                        
            $pievideo = new PiableMoments();
            $pievideo->title= $request->video_title;  
            $pievideo->user_id= 1; 
            $pievideo->comment_note= $request->comment_note; 
            $pievideo->piable_description= $request->video_description;  
            $pievideo->status=0;
            $pievideo->created_by=1;
            $pievideo->updated_by=1;  
            
           if($request->hasfile('video_file'))
            {
                $pievideo->file_name= $filename;
            }   
            
            if($request->hasfile('thumb_file')){ 
                 $pievideo->video_thumbnail_file_path=$thumb_filename;   
            }   
      
           if($request->hasfile('original_video')){
              $pievideo->original_video_path = $original_video_name;
            }           
            
            if($pievideo->save()){ 
                return redirect('admin/pieable-moments')->with('message', "Pie has been added successfully");
            }else{
                return redirect()->back()->with('error', 'Internal error occurred!');
            }
        } 
        return view('Admin.pieable.pieogramAdd');
    }




      public function videoajaxlist(Request $request){  
         try {   
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $order=isset($request->jtSorting)?$request->jtSorting:'id ASC';
                $orderBy = explode(" ", $order);  
                 $userQuery = PiableMoments::query();
                   if(isset($request->status) && $request->status!=''){
                                   $userQuery->where(function ($query) use($request){
                                    $query->where('status',$request->status)
                                          ->where('is_delete',0);
                                });                              
                    } else {
                           $userQuery->where(function ($query){
                           $query->where('is_delete',0);
                       });
                    } 
                   if(isset($request->keyword) && $request->keyword!=''){
                     $userQuery->where(function ($query) use($request){
                          $query->orWhere( 'title', 'LIKE', '%'. $request->keyword .'%')
                              ->orWhere('id', 'LIKE', '%' . $request->keyword . '%');
                    });  
                   } 
                  $usersCountArray = $userQuery->get();
                  $users = $userQuery->offset($offset)->limit($limit)->orderBy($orderBy[0], $orderBy[1])->get()->toArray();
                  $UserCount = $usersCountArray->count(); 
                  
                               
                $sno=$offset;
                $user_data=array();
                $path = url("uploads/"); 
                $path1 = public_path("uploads/");  
                
                foreach($users as $user){ 
                    $sno++;
                    $user['sno']=$sno; 
                    $user['used_no']= Helper::usedpieableUser($user['id']); 
                    $user['created_by']= $user['created_by']['id']; 
                   // $user['channel_name']= $user['channel_name']['channel_title']; 
                    $user['created_at'] = date('Y-m-d', strtotime($user['created_at'])); 
                    $user['file_path'] = $path.'/'.$user['file_name'];
                    
                   if($user['file_name']!='')
                    {   
                            if(file_exists($path1.$user['file_name']))        
                            {
                                $user['exists']=1; 
                            }    
                            else
                            {
                                $user['exists']=0; 
                            }
                    }    
                    else
                    {
                        $user['exists']=0;       
                    }   
                    array_push($user_data,$user);
                }
               
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




     public function PieActivationstatus(Request $request){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = PiableMoments::where('id',$request->userid)->first();   
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
                        $updateData = ['status'=>1];
                       //  $updateData = ['is_delete'=>1];
                        $message ='Video has been deactivated successfully.';
                    }else{
                        $updateData = ['status'=>0];
                        // $updateData = ['is_delete'=>1];
                        $message ='Video has been activated successfully.';
                    }
                }else if($request->statuskey == 3){
                    $deleted_at = date('Y-m-d h:i:s');
                    $updateData = ['is_delete'=>1];
                    //PieVideoTags::where('video_id',$userexist->id)->update($updateData);
                    $message ='Pieable moment has been deleted successfully.';
               }else if($request->statuskey == 4){
                    if($request->accountactiveStatus == 1){
                        $updateData = ['is_publish'=>0];
                        $message ='Video has been Unpublished successfully.';
                    }else{
                        $updateData = ['is_publish'=>1];
                        $message ='Video has been Published successfully.';
                    }
                }
                PiableMoments::where('id',$userexist->id)->update($updateData);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
    }



      public function editPie(Request $request,$id)
      {   
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }        
        $video_id=$id;        
        $session = Auth::guard('admin')->User();
        $user_id = $session->id; 
        $profile = PiableMoments::where('id',$id)->first();
        if(!$profile){
            return back()->with('message', 'Sorry! I think you are in worng path.');
        }     
            //    print_r(public_path()); die;
        if($request->isMethod('post')) {           
            $validator = Validator::make($request->all(), [
                        'video_title' =>   'required|max:255',
                        'video_description' =>   'max:5555',
                        
               
            ]);  
            if($validator->fails()) {
              return back()->withErrors($validator->errors($request[0])->first());
            }  
            
           if($request->hasfile('video_file')){
                $extension =  $request->file('video_file')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('video_file'), time().rand().'.'.$extension, 'public');
                $file_name = config('constants.DO_STORAGE_URL').$path;  
             
            } else{
                $file_name = $profile->file_name;
               
            }
            if($request->hasfile('original_video')){
                $extension =  $request->file('original_video')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('original_video'), time().rand().'.'.$extension, 'public');
                $original_video_name = config('constants.DO_STORAGE_URL').$path;
            } else{
                $original_video_name = $profile->original_video_path;               
            }
            if($request->hasfile('thumb_file'))
            {
                $extension =  $request->file('thumb_file')->extension();
                 $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('thumb_file'), time().rand().'.'.$extension, 'public');
                 $thumb_file_name = config('constants.DO_STORAGE_URL').$path; 
            } 
            else{
                $thumb_file_name = $profile->video_thumbnail_file_path;               
            }            
                        
            $updateData = ['title'=>$request->video_title,'comment_note'=>$request->comment_note,'piable_description'=>$request->video_description,'file_name'=>$file_name,'video_thumbnail_file_path'=>$thumb_file_name,'original_video_path' => $original_video_name, 'updated_by'=>$user_id]; 
            PiableMoments::where('id',$id)->update($updateData); 
                  
            return redirect('admin/pieable-moment-edit/'. $id.'')->with('message', "Pie Video has been updated successfully.");
        }  
         
          return view('Admin.pieable.videoEdit',compact('profile')); 
       }



}
