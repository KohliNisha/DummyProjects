<?php
namespace App\Http\Controllers\Admin;
use Auth;
use Exception;
use Validator;
use App\Models\User;
use App\Models\PieVideo;
use App\Models\PieChannel;
use App\Models\PieVideoTags;
use App\Models\HomepageVideo;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use VideoThumbnail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
 
class VideosController extends Controller
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

    public function videosList(){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $gif_corner = PieVideo::where('is_deleted',0)    
                                ->where('gif_corner',1)
                                ->get();
        

        return view('Admin.videos.videosList',compact('gif_corner'));
    }

      public function videoajaxlist(Request $request){  
         try {   
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $order=isset($request->jtSorting)?$request->jtSorting:'id ASC';
                $orderBy = explode(" ", $order);  
                 $userQuery = PieVideo::with('channelName','pieTags','pieCreatedBy');
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
                          $query->orWhere( 'video_title', 'LIKE', '%'. $request->keyword .'%')
                              ->orWhere('id', 'LIKE', '%' . $request->keyword . '%');
                    });  
                   } 
                  $usersCountArray = $userQuery->get();
                  $users = $userQuery->offset($offset)->limit($limit)->orderBy($orderBy[0], $orderBy[1])->get()->toArray();
                  $UserCount = $usersCountArray->count(); 
					/* echo "<pre>";						
					print_r($usersCountArray);
					echo "</pre>";		 */			
					
							   
                $sno=$offset;
                $user_data=array();
				       // $path = url("uploads/"); 
				       // $path1 = public_path("uploads/");  
				
				  
				
                foreach($users as $user){ 
                    $sno++;
                    $user['sno']=$sno; 
                    $user['created_by']= $user['pie_created_by']['first_name'] .' '.$user['pie_created_by']['last_name']; 
                    $user['created_by_user_id']= $user['pie_created_by']['id']; 
                    $user['channel_name']= $user['channel_name']['channel_title']; 
                    $user['created_at'] = date('Y-m-d', strtotime($user['created_at'])); 
                    $user['file_path'] = $user['video_file_path'];
					
					//echo $path1.$user['video_file_path'];
					if($user['video_file_path']!='')
					{	
							if(file_exists($user['video_file_path']))		
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
				/*  
				echo "<pre>";
				 print_r($user_data);
				 echo "</pre>"; 
				*/
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




     public function VideoActivationstatus(Request $request){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = PieVideo::where('id',$request->userid)->first();   
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
                        $message ='Video has been deactivated successfully.';
                    }else{
                        $updateData = ['status'=>1];
                        $message ='Video has been activated successfully.';
                    }
                }else if($request->statuskey == 3){
                    $deleted_at = date('Y-m-d h:i:s');
                    $updateData = ['is_deleted'=>1,'deleted_at'=>$deleted_at];
                    PieVideoTags::where('video_id',$userexist->id)->update($updateData);
                    $message ='Video has been deleted successfully.';
               }else if($request->statuskey == 4){
                    if($request->accountactiveStatus == 1){
                        $updateData = ['is_publish'=>0];
                        $message ='Video has been Unpublished successfully.';
                    }else{
                        $updateData = ['is_publish'=>1];
                        $message ='Video has been Published successfully.';
                    }
                }
                PieVideo::where('id',$userexist->id)->update($updateData);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
    }



    public function pieoramaVideodetails(Request $request,$id){  
	 
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $profile = PieVideo::where('id',$id)->first();
        if(!$profile){
            return back()->with('message', 'Sorry! I think you have worng path.');
        }
      //$pieoramaDetails = PieVideo::with('pieComment', 'pieLikeDislikeLog', 'pieDislikeLog', 'pieLikeLog', 'pieSearchLog', 'pieShareLog', 'pieStatusLog', 'pieTags')->where('id',$id)->first();
	 
        $pieoramaDetails = PieVideo::with('channelName','pieTags','pieCreatedBy', 'pieComment', 'pieLikeDislikeLog', 'pieDislikeLog', 'pieShareLog')->where('id',$id)->first();  
       //   dd($pieoramaDetails->pieCreatedBy->first_name);
        // echo "<pre/>";  print_r($pieoramaDetails); die;     
        return view('Admin.videos.videodetails',compact('pieoramaDetails'));
    }


     public function pieoramaChangeOwnership(Request $request,$id){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $profile = PieVideo::where('id',$id)->first();
        if(!$profile){
            return back()->with('message', 'Sorry! I think you have worng path.');
        }

         if($request->isMethod('post')){           
            $validator = Validator::make($request->all(), [
                'created_by' => 'required',
            ]);  
            if($validator->fails()) {
              return back()->withErrors($validator->errors($request[0])->first());
            }              
            $updateData = ['created_by'=>$request->created_by];
            PieVideo::where('id',$id)->update($updateData);
            return redirect('admin/pieograms')->with('message', "Ownership changed successfully.");
           }

        $pieoramaDetails = PieVideo::with('pieCreatedBy')->where('id',$id)->first();
        $UserDetailsDetails = User::select('id','first_name','last_name')->where('user_role',2)->where('status',1)->where('is_deleted',0)->get();
      //  dd($UserDetailsDetails);
        return view('Admin.videos.videochangeOwnership',compact('pieoramaDetails','UserDetailsDetails'));
    }



     public function editPieorama(Request $request,$id)
      {   
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }		
		    $video_id=$id;
        $profile = PieVideo::with('channelName','pieTags')->where('id',$id)->first();
        if(!$profile){
            return back()->with('message', 'Sorry! I think you are in worng path.');
        }
        $session = Auth::guard('admin')->User();
        $user_id = $session->id;     
		
        $ChannelS = PieChannel::where('status',1)->where('is_deleted',0)->get();
        if(!$ChannelS->count()) { 
           return back()->with('message', 'Sorry! Channel has been deleted so you can not access this page because pieogram need to have atleast one channel');
        }
        if($request->isMethod('post')) {           
            $validator = Validator::make($request->all(), [
				        'video_title' =>   'required|max:255',
                'video_description' =>   'max:5555',
                'meta_description' =>   'max:5555',
               
            ]);  
            if($validator->fails()) {
              return back()->withErrors($validator->errors($request[0])->first());
            }    
            //dd($request->all());
		   if($request->hasfile('video_file')){
                $extension =  $request->file('video_file')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('video_file'), time().rand().'.'.$extension, 'public');
                $file_name = config('constants.DO_STORAGE_URL').$path;  
		     }  else{
                $file_name = $profile->video_file_path;
               
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
			      }	else{
                $thumb_file_name = $profile->video_thumbnail_file_path;
               
            } 


            if($request->hasfile('video_large_thumbnail_file_path'))
            {
                 $extension =  $request->file('video_large_thumbnail_file_path')->extension();
                 $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('video_large_thumbnail_file_path'), time().rand().'.'.$extension, 'public');
                 $video_large_thumbnail_file_path_name = config('constants.DO_STORAGE_URL').$path;
            }  else{
                $video_large_thumbnail_file_path_name = $profile->video_large_thumbnail_file_path;

               
            }
			     
         if($request->hasfile('video_animated_file_path')){

                  $extension =  $request->file('video_animated_file_path')->extension();

                  $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('video_animated_file_path'), time().rand().'.'.$extension, 'public');

                  $video_animated_file_path = config('constants.DO_STORAGE_URL').$path; 

           }  else{
                  $video_animated_file_path = $profile->video_animated_file_path;
                 
         }

         if($request->hasfile('small_gif')){

                  $extension =  $request->file('small_gif')->extension();

                  $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('small_gif'), time().rand().'.'.$extension, 'public');

                  $small_gif = config('constants.DO_STORAGE_URL').$path; 

           }  else{
                  $small_gif = $profile->small_gif;
                 
         }

        // dd($video_animated_file_path);

			$video_tags=$request->video_tags;
			$today=date('Y-m-d H:i:s');
			$values=array();
			if($video_tags!='')
			{
				
				$video_tag_array=explode(",",$video_tags);  
				DB::table('sc_pie_tags')->where('video_id', $video_id)->delete();
				foreach($video_tag_array as $row)
				{
					$video_id;
					$user_id;
					$tag= str_replace("#","",$row); ; 	  
					
					$is_delete=0;
					$values = array(
						'video_id'=>$video_id,
						'tag_text'=>$tag, 
						'created_by'=>$user_id,
						'is_deleted'=>$is_delete,
						'created_at'=>$today,
						'updated_at'=>$today   
					);					
					//print_r($values);					
					DB::table('sc_pie_tags')->insert($values);	
				}	 
				
			}	
			 
			      $meta_title='';
			      $meta_description='';  

            if($request->profiled_pieogram) {
              $profiled_pieogram = 1;
             /*$updateDataprofile = ['profiled_pieogram'=>0]; 
               PieVideo::where('profiled_pieogram',1)->update($updateDataprofile); */
            } else {
              $profiled_pieogram = 0 ;
            } 
           
            
               if($request->gif_corner) {

                 $existgif = PieVideo::where('is_deleted',0)
                        ->where('gif_corner',1)
                        ->whereNotIn('id',[$profile->id])
                        ->get()->count();

               if($existgif < 4){
               
                $gif_corner = 1;
                
                } else {
                  
                  return redirect('admin/pieorama-edit/'. $id.'')->with('error', "Cannot Added more than 4 gif for main page strip between banner and welcome message.");
                }
            }else{
              $gif_corner = 0;
            }

            
            $updateData = ['meta_title'=>$meta_title,'meta_description'=>$meta_description,'video_title'=>$request->video_title,'comment_note'=>$request->comment_note,'video_description'=>$request->video_description,'video_file_path'=>$file_name,'video_thumbnail_file_path'=>$thumb_file_name, 'video_large_thumbnail_file_path'=>$video_large_thumbnail_file_path_name, 'small_gif' =>$small_gif,'profiled_pieogram'=>$profiled_pieogram,'gif_corner' => $gif_corner??0, 'original_video_path' => $original_video_name,'video_animated_file_path' => $video_animated_file_path,'pie_channel_id'=>2, 'updated_by'=>$user_id]; 
            PieVideo::where('id',$id)->update($updateData); 
			      
            return redirect('admin/pieorama-edit/'. $id.'')->with('message', "Pieogram has been updated successfully.");
        }            
			
  			$check_view = DB::table('sc_pie_tags')
  						->where('video_id', $video_id) 
  						->get();
  		
  			$count = $check_view->count();
  			$tagArray=array();
  			if($count > 0)
  			{
  				foreach($check_view as $row)		
  				{
  					$tagArray[]=$row->tag_text;	
  				}	
  			}		
		
		     return view('Admin.videos.videoEdit',compact('profile','ChannelS','tagArray')); 
       }
  

   /* Updated Main page Video */
    public function updateWebsiteMainPagePieorama(Request $request){ 
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $id = 1; 
        $profile = HomepageVideo::where('id',$id)->first();
        if(!$profile){
            return back()->with('message', 'Sorry! I think you are in worng path.');
        }        
        $session = Auth::guard('admin')->User();
        $user_id = $session->id;
        if( $request->isMethod('post') ) {           
            $validator = Validator::make($request->all(), [
               // 'library_file' => 'required',
            ]);  
            if($validator->fails()) {
              return back()->withErrors($validator->errors($request[0])->first());
            }            
           // dd($request->all());
             if($request->hasfile('library_file')){
                /*$image = $request->file('library_file');
                $name = $request->file('library_file')->getClientOriginalName();
                $image_name = $request->file('library_file')->getRealPath();
                $path = public_path().'/uploads/';        
                 
                 $newvideo = $image->move($path, $name);
                 $file_name = $name;*/
                $extension =  $request->file('library_file')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('library_file'), time().rand().'.'.$extension, 'public');
                $file_name = config('constants.DO_STORAGE_URL').$path;
                
          
            }else{
                $file_name = $profile->file_name;
                $file_size = $profile->file_size;
                $file_mime_type = $profile->file_mime_type;
            }
            if($request->hasfile('thumb_file')){
                 /* $image = $request->file('thumb_file');
                  $name = $request->file('thumb_file')->getClientOriginalName();
                  $image_name = $request->file('thumb_file')->getRealPath();
                  $path = public_path().'/thumbs/';                
                  $newvideo = $image->move($path, $name);*/
                $extension =  $request->file('thumb_file')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('thumb_file'), time().rand().'.'.$extension, 'public');
                $name = config('constants.DO_STORAGE_URL').$path;
                  
                
                        
             } else{
                $name = $profile->file_image;
            }
            $updateData = ['title'=>$request->title, 'file_image'=>$name, 'background_color'=>$request->background_color, 'foreground_color'=>$request->foreground_color,  'comment_note'=>$request->comment_note,'file_name'=>$file_name,'user_id'=>$user_id];
            HomepageVideo::where('id',$id)->update($updateData);
            return redirect('admin/update-main-page-video')->with('message', "Video has been updated successfully.");
        }
        return view('Admin.videos.videoMainPage',compact('profile')); 
    }


    public function pieogramAdd(Request $request){   
	     
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
            if($request->hasfile('video_large_thumbnail_file_path')){
                 $extension =  $request->file('video_large_thumbnail_file_path')->extension();
                 $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('video_large_thumbnail_file_path'), time().rand().'.'.$extension, 'public');
                 $video_large_thumbnail_file_path = config('constants.DO_STORAGE_URL').$path; 
                
             } 
			        if($request->hasfile('video_animated_file_path')){ 
                $extension =  $request->file('video_animated_file_path')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('video_animated_file_path'), time().rand().'.'.$extension, 'public');
                $video_animated_file_path = config('constants.DO_STORAGE_URL').$path; 
            }

            if($request->hasfile('small_gif')){ 
                $extension =  $request->file('small_gif')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('small_gif'), time().rand().'.'.$extension, 'public');
                $small_gif = config('constants.DO_STORAGE_URL').$path; 
            }  
			
            $pievideo = new PieVideo();
            $pievideo->video_title= $request->video_title;  
            $pievideo->comment_note= $request->comment_note; 
            $pievideo->video_description= $request->video_description;  
            $pievideo->is_publish=1;
            $pievideo->status=1;
            $pievideo->created_by=1;
            $pievideo->updated_by=1;  
			
      if($request->hasfile('video_file'))
			{
				$pievideo->video_file_path= $filename;
			}	
			
			if($request->hasfile('thumb_file')){ 
				 $pievideo->video_thumbnail_file_path=$thumb_filename;   
			}
      if($request->hasfile('video_large_thumbnail_file_path')){ 
         $pievideo->video_large_thumbnail_file_path=$video_large_thumbnail_file_path;   
      }	
      if($request->hasfile('original_video')){
        $pievideo->original_video_path = $original_video_name;
      }
      if($request->hasfile('video_animated_file_path')){
        $pievideo->video_animated_file_path = $video_animated_file_path??'';
      }
       if($request->hasfile('small_gif')){
        $pievideo->small_gif = $small_gif??'';
      }
			
           
            $pievideo->pie_channel_id=2;         
            
            if($pievideo->save()){ 
                return redirect('admin/pieograms')->with('message', "Pievideo has added successfully");
            }else{
                return redirect()->back()->with('error', 'Internal error occurred!');
            }
        } 
        return view('Admin.videos.pieogramAdd');
    }
	
 
}
