<?php
namespace App\Http\Controllers\Site;
/*namespace Jorenvh\Share\Test;
use Jorenvh\Share\ShareFacade;*/
use Illuminate\Http\Request;
use Validator;
use Auth;
use Session;
use App\Models\User;
use App\Models\PieChannel;
use App\Models\PieVideo;
use App\Models\PieVideoComment;
use App\Models\UserVerification;
use App\Models\PieVideoShareLog;
use App\Models\PieVideoLikeDislike;
use App\Models\PieVideoLikeLog;
use App\Models\PieVideoDislikeLog;
use App\Models\HomepageVideo;
use App\Models\PieWatchedLog;
use App\Models\PieTags;
use App\Mail\SignupMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Exception;
//use Helper;
use App\Helpers\Helper as Helper;

class PieogramsController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pieogramsByCategories(Request $request,$id, $catName)
    { 
    	
		try {
    	  //Channel details
          $ChannelDetails = PieChannel::where('status',1)->where('is_deleted',0)->where('id',$id)->first();
          if($ChannelDetails){
          	 if($ChannelDetails->channel_title == $catName){
          	    $ChannelVideos = PieVideo::where('status',1)->where('is_deleted',0)->where('pie_channel_id',$ChannelDetails->id)->orderBy('id','DESC')->take(50)->get();
               
			   
			    $user_data=array(); 
				foreach($ChannelVideos as $row)
				{
					$video_id=$row['id'];	
					$user_id=$row['created_by'];	
					$user = DB::table('users')->where('id', $user_id)->first();
					
					$firstname=$user->first_name;
					$lastname=$user->last_name;
					
					$TotalvideoViewsCount = PieWatchedLog::where('video_id',$video_id)->where('is_delete',0)->count(); 
					
					//$user_name=$firstname.' '.$lastname;
					$trending_user[]=array(
						'user_firstname'=>$firstname,	
						'user_lastname'=>$lastname,
						'view'=>$TotalvideoViewsCount
					); 
				}	
				/* echo "<pre>";
					print_r($trending_user);
			    echo "</pre>";
			   die; */ 
			   
			    
			   return view('Site.channel.channel',compact('ChannelDetails','ChannelVideos','trending_user')); 
          	 } else {
			       $message = "It seems the category was changed in url with the our actual category name.";
             return redirect('/home')->with('error', $message);
          	 }
          }else {
          	 $message = "It seems deleted or deavtivated the category which one you have requested.";
             return redirect('/home')->with('error', $message);
          }

        } catch (\Exception $e) {
            return response()->json([
                        'status' => false,
                        'message' => [
                            "err" => $e->getMessage()
                        ]
            ]);
        }
    }



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function pieogramsDetails(Request $request,$id, $catName)
    { 
    	try {
    	 
		$user_ip=$request->ip();
		$video_id=base64_decode(base64_decode($id)); 
		
		$user_verify=new UserVerification; 
		$AllVideos = PieVideo::where('status',1)->where('is_deleted',0)->whereNotIn('id',[$video_id])->orderBy('id','DESC')->take(5)->get();
		foreach($AllVideos as $row) 
		{
			$video_id=$row['id'];	
			$user_id=$row['created_by'];	
			
			$updated_at=$row['updated_at'];	
			
			$updated_at=$user_verify->timeago($updated_at);
			
			$user = DB::table('users')->where('id', $user_id)->first();
			
			$firstname=$user->first_name;
			$lastname=$user->last_name;
			
			$TotalvideoViewsCount = PieWatchedLog::where('video_id',$video_id)->where('is_delete',0)->count(); 
			$videoTags = PieTags::where('is_deleted',0)->where('video_id',$video_id)->orderBy('id','ASC')->get();  
			//$user_name=$firstname.' '.$lastname;
			
			$totalsharecount = PieVideoShareLog::where('video_id',$video_id)->count();
			$total_count_like =   PieVideoLikeDislike::where('video_id',$video_id)->where('like_status',1)->count();
			$total_count_dislike = PieVideoLikeDislike::where('video_id',$video_id)->where('dislike_status',1)->count();
			
			$videoComment = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
			


			
			$videoComments = PieVideoComment::where('video_id',$video_id)->get(); //total  Comment
			$total_comment = $videoComments->count();
			
			
			//print_r($videoTags);
			//die;
			
			$tagArray=array();
			if(!empty($videoTags))
			{
				foreach($videoTags as $row)
				{
					$tagArray[]=array(
						'tag_name'=>$row->tag_text,
					);	
				}	
			}	
			
			if (Auth::user()) {   // Check is user logged in
				$user_id=Auth::user()->id;
			} else {
				$user_id=0;
			}
			
			$count_user_like_dislike_count=0;
			if($user_id!=0)
			{
				$user_like_dislike_count = DB::table('sc_pie_video_like_dislike')
							->where('user_id', $user_id)
							->where('video_id', $video_id)  
							->get();	
				
				
				$count_user_like_dislike_count=$user_like_dislike_count->count();
			
			}	
			
			$count_user_like_dislike_count;
			$video_file_path=$row['video_file_path'];	
			$duration=0;
			if($video_file_path!='')
			{
				$duration=$user_verify->video_duration($video_file_path);	
			}	
			
			$all_userss[]=array(
				'user_firstname'=>$firstname,	
				'user_lastname'=>$lastname,
				'view'=>$TotalvideoViewsCount,
				'tags'=>$tagArray, 
				'totalsharecount'=>$totalsharecount, 
				'total_count_like'=>$total_count_like, 
				'total_count_dislike'=>$total_count_dislike,
				'total_comment'=>$total_comment,
				'updated_at'=>$updated_at, 
				'duration'=>$duration, 
				
			); 
			
			
		} 
		 
		 
		 
        
		
		
		
		
		
		$today=date('Y-m-d H:i:s');
		$today_check=date('Y-m-d');
		
		$check_view = DB::table('sc_pie_video_watch_log')
						->where('ip_address', $user_ip)
						->where('video_id', $video_id) 
						->whereDate('created_at', $today_check)
						 ->get();
		
		$count = $check_view->count();
		if($count==0)
		{
			$is_delete=0;
			$values = array(
				'video_id'=>$video_id,
				'user_id'=>$user_id,
				'is_delete'=>$is_delete,
				'created_at'=>$today,
				'updated_at'=>$today,
				'ip_address'=>$user_ip,
			);
			
			//print_r($values);
			
			DB::table('sc_pie_video_watch_log')->insert($values);	
		}	
		
		
		
		
		
        $video_id =  base64_decode(base64_decode($id)); 
          $videoDetails = PieVideo::where('status',1)->where('is_deleted',0)->where('id',base64_decode(base64_decode($id)))->first();
          if($videoDetails){   
                if (!Auth::user()) {
                   $videoDetails->is_owner = false;
                   $videoDetails->encoded_pieogramid = false;
                } else {
                   if($videoDetails->created_by == Auth::user()->id) {
                      $videoDetails->is_owner = true;
                      $videoDetails->encoded_pieogramid = $id;
                   } else {
                      $videoDetails->is_owner = false;
                      $videoDetails->encoded_pieogramid = false;
                   }
                }
          	    $ChannelDetails = PieChannel::where('status',1)->where('is_deleted',0)->where('id',$videoDetails->pie_channel_id)->first();

                $videoComment = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
                
                $videoComments = PieVideoComment::where('video_id',$video_id)->get(); //total  Comment
                $total_comment = $videoComments->count();
               
                $videoTags = PieTags::where('is_deleted',0)->where('video_id',$video_id)->orderBy('id','ASC')->get();
                $TotalvideoViewsCount = PieWatchedLog::where('video_id',$video_id)->where('is_delete',0)->count(); 
                $totalsharecount = PieVideoShareLog::where('video_id',$video_id)->count();
                 $total_count_like =   PieVideoLikeDislike::where('video_id',$video_id)->where('like_status',1)->count();
              $total_count_dislike = PieVideoLikeDislike::where('video_id',$video_id)->where('dislike_status',1)->count();
              $like_status = 2;
              $dislike_status = 2;
              if(isset(Auth::user()->id))
              {
                $user_id = Auth::user()->id;  
                $userlike_dislikestatus = PieVideoLikeDislike::where('user_id',$user_id)->where('video_id',$video_id)->first();
                if(!empty($userlike_dislikestatus))
                {
                  $like_status = $userlike_dislikestatus->like_status;
                  $dislike_status = $userlike_dislikestatus->dislike_status;
                }
                else
                {
                  $like_status = 2;
                  $dislike_status = 2;
                }
                
              }
				
				/* echo "<pre>";
					print_r($videoDetails);
				echo "</pre>"; */ 
				
				$user_id=$videoDetails['created_by'];
				$user = DB::table('users')->where('id', $user_id)->first();
					
				$firstname=$user->first_name;
				$lastname=$user->last_name;
				$profile_image=$user->profile_image;
				
				if($profile_image=='')
				{	
					$profile_image='https://via.placeholder.com/150'; 
				}
				//$user_name=$firstname.' '.$lastname;
				$video_user=array( 
					'user_firstname'=>$firstname,	
					'user_lastname'=>$lastname,
					'profile_image'=>$profile_image,
				); 
				
				/* echo "<pre>";
					print_r($video_user);
				echo "</pre>"; */
				/* echo "<pre>";
					print_r($videoDetails);
				echo "</pre>"; */
				
				
				
				
               if($ChannelDetails){
			          return view('Site.pieogram-details.pieogram-details',compact('ChannelDetails','videoDetails','videoComment','total_comment','videoTags','TotalvideoViewsCount','totalsharecount','total_count_like','total_count_dislike','like_status','dislike_status','userlike_dislikestatus','video_user','AllVideos','all_userss','count_user_like_dislike_count'));  
          	    } else {
          	       $message = "Related channel to this video has been suspended. So please review another pieogram details.";
            	   return redirect('/home')->with('error', $message);
          	    }

          }else {
          	 $message = "It seems the pieogram has deleted or deavtivated by the Pieorama.";
             return redirect('/home')->with('error', $message);
          }
        } catch (\Exception $e) {
            return response()->json([
                        'status' => false,
                        'message' => [
                            "err" => $e->getMessage()
                        ]
            ]);
        }
    }
	
	
	public function watch(request $request) 
    { 
    	
		if(empty($_GET['p']))
		{
			return redirect('/home');	
		}	
		
		$id=$_GET['p']; 
		 
		
		try {
    	 
		$user_ip=$request->ip();
		//$video_id=base64_decode($_GET['p']); 
		//$video_idd=base64_decode($_GET['p']); 
		
		$video_id=base64_decode(urldecode($_GET['p']));
		$video_id=base64_decode($video_id); 
		$video_idd=$video_id; 
		$user_verify=new UserVerification;
		 $value = $request->session()->get('video_id');	
		 //dd($value);	
		$getvideodata = PieVideo::leftjoin('sc_pie_tags','sc_pie_tags.video_id','=','sc_pie_video.id')->where('sc_pie_video.id',$video_id)
					->where('sc_pie_video.is_deleted',0)
					//->whereNotNull('sc_pie_video.video_file_path')
					->whereNotNull('sc_pie_video.small_gif')
					->where('sc_pie_video.status',1)
					->select('sc_pie_video.id','sc_pie_tags.tag_text')
					->get();
		//dd($getvideodata);
					
	 	foreach ($getvideodata as $key => $v) {
	 		$tag = $v->tag_text;
	 		if($tag == ''){
	 			$getnextVideo = '';
				$videoTags1 = '';
				$all_userss1 = '';
	 		}else{
	     	
	     		$getanotherVideo1 = PieVideo::leftjoin('sc_pie_tags','sc_pie_tags.video_id','=','sc_pie_video.id')
	     	 						->where('sc_pie_video.id','!=',$v->id)
	     	 						->where( 'sc_pie_tags.tag_text', 'LIKE', '%'. $tag .'%')
	     	 						->where('sc_pie_video.is_deleted',0)
	     	 						//->whereNotNull('sc_pie_video.video_file_path')
									->whereNotNull('sc_pie_video.small_gif')
	     	 						->where('sc_pie_tags.is_deleted',0)
	     	 					    ->where('sc_pie_video.status',1)->select('sc_pie_video.*','sc_pie_tags.tag_text')
	     	 					    //->orderBy('sc_pie_video.id','desc')
	     	 					    ->groupBy('sc_pie_tags.video_id')
	     	 					    ->first();

	     	 	
				if(!isset($getanotherVideo1)) {
						$getnextVideo = '';
						$videoTags1 = '';
						$all_userss1 = '';
					}else{	
					if(isset($value) && in_array($getanotherVideo1->id, $value)){
							$getnextVideo = '';
							$videoTags1 = '';
							$all_userss1 = '';

					}else{

				$user_id1=$getanotherVideo1->created_by;	
				
				$updated_at1=$getanotherVideo1->updated_at;	
				
				$updated_at1=$user_verify->timeago($updated_at1);
				
				$user1 = DB::table('users')->where('id', $user_id1)->first();
				
				$firstname1=$user1->first_name??'';
				$lastname1=$user1->last_name??'';
				
				$TotalvideoViewsCount1 = PieWatchedLog::where('video_id',$getanotherVideo1->id)->where('is_delete',0)->count(); 
				$videoTags1 = PieTags::where('is_deleted',0)->where('video_id',$getanotherVideo1->id)->orderBy('id','ASC')->get();  
				//$user_name=$firstname.' '.$lastname; 
				
				$totalsharecount1 = PieVideoShareLog::where('video_id',$getanotherVideo1->id)->count();
				$total_count_like1 =   PieVideoLikeDislike::where('video_id',$getanotherVideo1->id)->where('like_status',1)->count();
				$total_count_dislike1 = PieVideoLikeDislike::where('video_id',$getanotherVideo1->id)->where('dislike_status',1)->count();
				
				$videoComment1 = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$getanotherVideo1->id)->orderBy('id','DESC')->get();
					
				$videoComments1 = PieVideoComment::where('video_id',$getanotherVideo1->id)->get(); //total  Comment
				$total_comment1 = $videoComments1->count();
				
			
			
			
				$tagArray1=array();
				if(!empty($videoTags1))
				{
					foreach($videoTags1 as $row)
					{
						$tagArray1[]=array(
							'tag_name1'=>$row['tag_text'],
						);	
					}	
				}	
			
				if (Auth::user()) {   // Check is user logged in
					$user_id1=Auth::user()->id;
				} else {
					$user_id1=0;
				}
				

				
				$count_user_like_dislike_count1=0;
				if($user_id1!=0)
				{
					$user_like_dislike_count1 = DB::table('sc_pie_video_like_dislike')
								->where('user_id', $user_id1)
								->where('video_id', $getanotherVideo1->id)  
								->get();	
					
					
					$count_user_like_dislike_count1=$user_like_dislike_count1->count();
				
				}	
				
				$count_user_like_dislike_count1;
				$video_file_path1=$getanotherVideo1->video_file_path;	
				
			
				$all_userss1=array(
					'user_firstname'=>$firstname1,	
					'user_lastname'=>$lastname1,
					'view'=>$TotalvideoViewsCount1,
					'tags'=>$tagArray1, 
					'totalsharecount'=>$totalsharecount1, 
					'total_count_like'=>$total_count_like1, 
					'total_count_dislike'=>$total_count_dislike1,
					'total_comment'=>$total_comment1,
					'updated_at'=>$updated_at1, 
					
					
				); 
				
				//dd($all_userss1);
			 
			$today1=date('Y-m-d H:i:s');
			$today_check1=date('Y-m-d');
		
			$check_view = DB::table('sc_pie_video_watch_log')
						->where('ip_address', $user_ip)
						->where('video_id', $getanotherVideo1->id) 
						->whereDate('created_at', $today_check1)
						 ->get();
		
			$count1 = $check_view->count();
				if($count1==0)
				{
					$is_delete1=0;
					$values1 = array(
						'video_id'=>$getanotherVideo1->id,
						'user_id'=>$user_id1,
						'is_delete'=>$is_delete1,
						'created_at'=>$today1,
						'updated_at'=>$today1,
						'ip_address'=>$user_ip,
					);
					
					
					
					DB::table('sc_pie_video_watch_log')->insert($values1);	
				}
		     	
	 	 			
	 	 					
		 	 				$getnextVideo = $getanotherVideo1;
		 	 		          break;
		 	 			
		 	 		}
		 	 	}
		 	 }
		 	 		
		   
	    }
		
		
		//dd($value);
		$user_verify=new UserVerification; 
		if(isset($value)){
			$AllVideos = PieVideo::where('status',1)
									->where('is_deleted',0)
									//->whereNotNull('video_file_path')
									->whereNotNull('small_gif')
									->whereNotIn('id',[$video_id, $value])
									->orderBy('id','DESC')
									->take(4)
									->get();
		}else{
			$AllVideos = PieVideo::where('status',1)
									->where('is_deleted',0)
									//->whereNotNull('video_file_path')
									->whereNotNull('small_gif')
									->whereNotIn('id',[$video_id])
									->orderBy('id','DESC')
									->take(4)
									->get();
		}
		
		//dd($AllVideos);
		
	/*	$user_verify=new UserVerification; 
		$AllVideos = PieVideo::where('status',1)->where('is_deleted',0)->whereNotIn('id',[$video_id])->orderBy('id','DESC')->take(5)->get();*/
		//dd($AllVideos);
		foreach($AllVideos as $row) 
		{
			$video_id=$row['id'];	
			$user_id=$row['created_by'];	
			
			$updated_at=$row['updated_at'];	
			
			$updated_at=$user_verify->timeago($updated_at);
			
			$user = DB::table('users')->where('id', $user_id)->first();
			
			$firstname=$user->first_name??'';
			$lastname=$user->last_name??'';
			
			$TotalvideoViewsCount = PieWatchedLog::where('video_id',$video_id)->where('is_delete',0)->count(); 
			$videoTags = PieTags::where('is_deleted',0)->where('video_id',$video_id)->orderBy('id','ASC')->get();  
			//$user_name=$firstname.' '.$lastname; 
			
			$totalsharecount = PieVideoShareLog::where('video_id',$video_id)->count();
			$total_count_like =   PieVideoLikeDislike::where('video_id',$video_id)->where('like_status',1)->count();
			$total_count_dislike = PieVideoLikeDislike::where('video_id',$video_id)->where('dislike_status',1)->count();
			
			$videoComment = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
				
			$videoComments = PieVideoComment::where('video_id',$video_id)->get(); //total  Comment
			$total_comment = $videoComments->count();
			$videoComment_s = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
			
			
			//print_r($videoTags);
			//die;
			
			$tagArray=array();
			if(!empty($videoTags))
			{
				foreach($videoTags as $row)
				{
					$tagArray[]=array(
						'tag_name'=>$row->tag_text,
					);	
				}	
			}	
			
			if (Auth::user()) {   // Check is user logged in
				$user_id=Auth::user()->id;
			} else {
				$user_id=0;
			}
			

			
			$count_user_like_dislike_count=0;
			if($user_id!=0)
			{
				$user_like_dislike_count = DB::table('sc_pie_video_like_dislike')
							->where('user_id', $user_id)
							->where('video_id', $video_id)  
							->get();	
				
				
				$count_user_like_dislike_count=$user_like_dislike_count->count();
			
			}	
			
			$count_user_like_dislike_count;
			$video_file_path=$row['video_file_path'];	
				
			
			$all_userss[]=array(
				'user_firstname'=>$firstname,	
				'user_lastname'=>$lastname,
				'view'=>$TotalvideoViewsCount,
				'tags'=>$tagArray, 
				'totalsharecount'=>$totalsharecount, 
				'total_count_like'=>$total_count_like, 
				'total_count_dislike'=>$total_count_dislike,
				'total_comment'=>$total_comment,
				'updated_at'=>$updated_at, 
				
				
			); 
			
			
		} 
		 
		
		 
        
		
		
		
		
		
		$today=date('Y-m-d H:i:s');
		$today_check=date('Y-m-d');
		
		$check_view = DB::table('sc_pie_video_watch_log')
						->where('ip_address', $user_ip)
						->where('video_id', $video_id) 
						->whereDate('created_at', $today_check)
						 ->get();
		
		$count = $check_view->count();
		if($count==0)
		{
			$is_delete=0;
			$values = array(
				'video_id'=>$video_id,
				'user_id'=>$user_id,
				'is_delete'=>$is_delete,
				'created_at'=>$today,
				'updated_at'=>$today,
				'ip_address'=>$user_ip,
			);
			
			//print_r($values);
			
			DB::table('sc_pie_video_watch_log')->insert($values);	
		}	
		
		
		
		//$decoded_id = base64_decode(urldecode($_GET['p']));
		
          $videoDetails = PieVideo::where('status',1)->where('is_deleted',0)->where('id',$video_idd)->first();
         
		  $video_id=$video_idd; 
		
          if($videoDetails){    
                if (!Auth::user()) {
                   $videoDetails->is_owner = false;
                   $videoDetails->encoded_pieogramid = false;
                } else {
                   if($videoDetails->created_by == Auth::user()->id) {
                      $videoDetails->is_owner = true;
                      $videoDetails->encoded_pieogramid = $id;
                   } else {
                      $videoDetails->is_owner = false;
                      $videoDetails->encoded_pieogramid = false;
                   }
                }

          	    //$ChannelDetails = PieChannel::where('status',1)->where('is_deleted',0)->where('id',$videoDetails->pie_channel_id)->first();
          	    $ChannelDetails = '';
				//dd($ChannelDetails);
				
				$videoComment_s = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
				 
				
                $videoComment = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->offset(0)->limit(3)->get(); 
                
                  
				
				$total_count_comm=count($videoComment_s);
				
				
				
				
                $videoComments = PieVideoComment::where('video_id',$video_id)->get(); //total  Comment
                $total_comment = $videoComments->count();
               
                $videoTags = PieTags::where('is_deleted',0)->where('video_id',$video_id)->orderBy('id','ASC')->get();

                $TotalvideoViewsCount = PieWatchedLog::where('video_id',$video_id)->where('is_delete',0)->count(); 
                $totalsharecount = PieVideoShareLog::where('video_id',$video_id)->count();
                 $total_count_like =   PieVideoLikeDislike::where('video_id',$video_id)->where('like_status',1)->count();
              $total_count_dislike = PieVideoLikeDislike::where('video_id',$video_id)->where('dislike_status',1)->count();
              $like_status = 2;
              $dislike_status = 2;
              if(isset(Auth::user()->id))
              {
                $user_id = Auth::user()->id;  
                $userlike_dislikestatus = PieVideoLikeDislike::where('user_id',$user_id)->where('video_id',$video_id)->first();
                if(!empty($userlike_dislikestatus))
                {
                  $like_status = $userlike_dislikestatus->like_status;
                  $dislike_status = $userlike_dislikestatus->dislike_status;
                }
                else
                {
                  $like_status = 2;
                  $dislike_status = 2;
                }
                
              }else{
              	$userlike_dislikestatus = '';
              }
				
			$tagArray=array();
			if(!empty($videoTags))
			{
				foreach($videoTags as $row)
				{
					$tagArray[]=array(
						'tag_name'=>$row->tag_text,
					);	
				}	
			}

				/* echo "<pre>";
					print_r($videoDetails);
				echo "</pre>"; */ 
				
				$user_id=$videoDetails['created_by'];
				$user = DB::table('users')->where('id', $user_id)->first();
					
				$firstname=$user->first_name??'';
				$lastname=$user->last_name??'';
				$profile_image=$user->profile_image??'';
				
				if($profile_image=='')
				{	
					$profile_image=asset('images/300.png'); 
				}
				//$user_name=$firstname.' '.$lastname;
				$video_user=array( 
					'user_firstname'=>$firstname,	
					'user_lastname'=>$lastname,
					'profile_image'=>$profile_image,
					'video_tags'  => $tagArray,
				); 
				
				/*
				echo "<pre>";
					print_r($video_user);
				echo "</pre>"; 
				*/
				/* echo "<pre>";
					print_r($videoDetails);
				echo "</pre>"; */
				
				$users_id = Auth::user()->id??0;
				 $id_exist = Helper::badgedata($users_id);      
        
				/*dd($AllVideos);*/
				
				
               if($videoDetails){ 
			         return view('Site.pieogram-details.pieogram-details',compact('ChannelDetails','videoDetails','videoComment','total_comment','videoTags','TotalvideoViewsCount','totalsharecount','total_count_like','total_count_dislike','like_status','dislike_status','userlike_dislikestatus','video_user','AllVideos','all_userss','count_user_like_dislike_count','total_count_comm','video_id','getnextVideo'??'','videoComment'??'', 'videoTags1'??'','all_userss1'??'','id_exist')); 
          	    } else {
          	       $message = "Related channel to this video has been suspended. So please review another pieogram details.";
            	   return redirect('/home')->with('error', $message);
          	    }

          }else {
          	 $message = "It seems the pieogram has deleted or deavtivated by the Pieorama.";
             return redirect('/home')->with('error', $message);
          }
        } catch (\Exception $e) {
            return response()->json([
                        'status' => false,
                        'message' => [
                            "err" => $e->getMessage()
                        ]
            ]);
        }
    }
	

	public function more_comment(request $request)
	{

		$user_ip=$request->ip();

		$total_record_show=$request->tot_rec;
		$current_page=$request->current_page; 
		$video_id=$request->video_id;
		//dd($current_page);
		//dd($video_id);

		
		$video_idd=$video_id;   
		
		$videoDetails = PieVideo::where('status',1)->where('is_deleted',0)->where('id',$video_idd)->first();
		
		$videoComment_s = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
		 
		$offset = ($current_page + 1);  
		//dd($offset);  
		$videoComment = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->offset($offset )->limit($total_record_show)->get(); 
		//dd($videoComment);
		   
		
		$total_count_comm=count($videoComment_s);
			//dd($total_count_comm);	
		return view('Site.pieogram-details.ajax_comment',compact('videoComment','total_comment','total_count_comm','video_id','videoDetails'));  
          	    

          
         

	}	



    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function deletePieogram(Request $request)
    { 
      try {
           $id = $request->encoded_pieogramid;
           if (!Auth::user()) {
              return redirect('home');
             }
          $Pieogram_Id = base64_decode(base64_decode($id));
          $videoDetails = PieVideo::where('is_deleted',0)->where('id',$Pieogram_Id)->where('created_by', Auth::user()->id)->first();
          if($videoDetails){  
              if (Auth::user()) {
                 if($videoDetails->created_by == Auth::user()->id) { 
                    $update_delete_status = PieVideo::where('id',$Pieogram_Id)->Update(['is_deleted'=>1]); 
                     return response()->json(["status" => true, "message" =>'successfully deleted.']);
                  } 
                } 
            return response()->json(["status" => false, "errors_res" =>'It seems the pieogram has deleted already.']);    
          }else {
             return response()->json(["status" => false, "errors_res" =>'It seems the pieogram has deleted already.']);           
          }
        } catch (\Exception $e) {
            return response()->json([
                        'status' => false,
                        'message' => [
                            "err" => $e->getMessage()
                        ]
            ]);
        }
    }

    public function addPieogram_comment(Request $request)
    {
      $comment   = $request->input('comment');      
      $video_id   = $request->input('video_id');      
      $video_path   = $request->input('video_path');    

      $insert = new PieVideoComment();
      $insert->video_id = $video_id;
      $insert->video_file_path = $video_path;
      $insert->comment_text = $comment;
      $insert->comment_by = auth()->user()->id; 
      $insert->created_by = auth()->user()->id;
      $insert->commentd_by_username = auth()->user()->first_name.' '.auth()->user()->last_name ;
      $insert->parent_id = 0;
      $insert->save();   
      //$videoComment = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
      $videoComments = PieVideoComment::where('video_id',$video_id)->get(); //total  Comment
      $total_comment = $videoComments->count();     
      
	$videoComment_s = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
	$videoComment = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->offset(0)->limit(3)->get();
   
   if(!empty($total_count_comm)){
   	$total_count_comm=count($videoComment_s);
   }else{
   	$total_count_comm=0;
   }
					


	$html = view('Site.pieogram-details.ajax_comment')->with(compact('videoComment','total_comment','video_id','total_count_comm'))->render();
    $response = response()->json(['success' => true, 'html' => $html,'total_comment'=>$total_comment]);
    return $response; 


    }
	
	
	
	public function unlike_comment(Request $request)
	{
		
		$video_id   = $request->input('video_id');      
		$type   = $request->input('type');      
		$comment_id   = $request->input('comment_id');    	
		$user_id=auth()->user()->id; 
		
		
		if($type == 1){

			$array=array(
				'video_id'=>$video_id,	
				'comment_id'=>$comment_id,	
				'user_id'=>$user_id,	
				'like'=>1,	
				'dislike'=>0,	
			);

			$is_exist =  DB::table('comment_like_dislike')->where('video_id',$video_id)
					    ->where('comment_id',$comment_id)
					   // ->where('like',1)
					   // ->where('dislike',0)
					    ->where('user_id',$user_id)
					    ->first();
		    if($is_exist){
		    	if($is_exist->like == 1 && $is_exist->dislike == 0){
		    		DB::table('comment_like_dislike')->where('video_id',$video_id)
					    ->where('comment_id',$comment_id)
					    ->where('like',1)
					    ->where('dislike',0)
					    ->where('user_id',$user_id)
					    ->delete();
					}elseif($is_exist->like == 0 && $is_exist->dislike == 1){
							DB::table('comment_like_dislike')->where('video_id',$video_id)
						    ->where('comment_id',$comment_id)
						    ->where('like',0)
						    ->where('dislike',1)
						    ->where('user_id',$user_id)
						    ->update(['like' => 1, 'dislike' => 0]);
					}
		    	
		    }else{
		    	
		    	DB::table('comment_like_dislike')->insert($array);
					   
		    }
		}else{

			$array=array(
				'video_id'=>$video_id,	
				'comment_id'=>$comment_id,	 
				'user_id'=>$user_id,	
				'like'=>0,	
				'dislike'=>1, 	 
			);

			$is_exist =  DB::table('comment_like_dislike')->where('video_id',$video_id)
					    ->where('comment_id',$comment_id)
					   // ->where('dislike',1)
					   // ->where('like',0)
					    ->where('user_id',$user_id)
					    ->first();
		    if($is_exist){

		    	if($is_exist->like == 0 && $is_exist->dislike == 1){
		    		DB::table('comment_like_dislike')->where('video_id',$video_id)
					    ->where('comment_id',$comment_id)
					    ->where('like',0)
					    ->where('dislike',1)
					    ->where('user_id',$user_id)
					    ->delete();
					}elseif($is_exist->like == 1 && $is_exist->dislike == 0){
							DB::table('comment_like_dislike')->where('video_id',$video_id)
						    ->where('comment_id',$comment_id)
						    ->where('like',1)
						    ->where('dislike',0)
						    ->where('user_id',$user_id)
						    ->update(['like' => 0, 'dislike' => 1]);
					}
		    }else{
		    	//dd('no_dislike');
		    	DB::table('comment_like_dislike')->insert($array);
					   
		    }	

		}



		
		
		$total_likes = DB::table('comment_like_dislike') 
			->where('video_id', '=', $video_id)
			->where('comment_id', '=', $comment_id)
			->where('like', '=', 1)
			->get();   
			
		$total_dislikes = DB::table('comment_like_dislike')
					->where('video_id', '=', $video_id)
					->where('comment_id', '=', $comment_id)
					->where('dislike', '=', 1)
					->get();	   		
					
					
		$count_likes=count($total_likes);
		$count_dislikes=count($total_dislikes);
		$like_status =0;
		$dislike_status =0;
		$like_data = DB::table('comment_like_dislike')
            ->where('video_id', '=', $video_id)
            ->where('comment_id', '=', $comment_id) 
            ->where('user_id', '=', $user_id)
            ->where('like','=',1)
            ->where('dislike','=',0)
            ->first();
            
       
        if(isset($like_data)){
        	$like_status = 1;
        }
         $dislike_data = DB::table('comment_like_dislike')
            ->where('video_id', '=', $video_id)
            ->where('comment_id', '=', $comment_id) 
            ->where('user_id', '=', $user_id)
            ->where('dislike','=',1)
            ->where('like','=',0)
            ->first();
       if(isset($dislike_data)){
        	$dislike_status = 1;
        }
		$array=array('likes'=>$count_likes,'dislikes'=>$count_dislikes,'like_status' => $like_status, 'dislike_status' =>$dislike_status,'comment_id' => $comment_id);  
		
		echo json_encode($array);  
		 
	}	
	
	
    public function addPieogram_reply(Request $request)
    {
      $comment   = $request->input('comment');        
      $video_id   = $request->input('video_id');      
      $comment_id   = $request->input('comment_id');        
      $insert = new PieVideoComment();
      $insert->video_id = $video_id;      
      $insert->comment_text = $comment;
      $insert->comment_by = auth()->user()->id;
      $insert->created_by = auth()->user()->id;
      $insert->commentd_by_username = auth()->user()->first_name.' '.auth()->user()->last_name ;
      $insert->parent_id = $comment_id;
      $insert->save(); 

      $videoComment = PieVideoComment::where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
                
      $videoComments = PieVideoComment::where('video_id',$video_id)->get(); //total  Comment
      $total_comment = $videoComments->count();    
       $html = view('Site.pieogram-details.ajax_comment')->with(compact('videoComment','total_comment','video_id'))->render();     
    $response = response()->json(['success' => true, 'html' => $html,'total_comment'=>$total_comment]);
    return $response;
    }


    

  public function searchStatus(Request $request){   
    try{

    if (!Auth::user()) {
       return redirect('home');
     }
    if($request->isMethod('post'))  
    {
      $userid = Auth::user()->id;
      $validator = Validator::make($request->except("_token"), [
                        'pieogram_id' => 'required',
                        'status' => 'required'                        
            ]);    
        if ($validator->fails()) {
                    return response()->json([
                                'status' => false,
                                'message' => $validator->errors()
                    ]);
                }
        $userExist = User::where('id',$userid)->first();
        if(!empty($userExist)){
            $Pieogram_Id = $request->pieogram_id;
            $update_status = PieVideo::where('id',$Pieogram_Id)->Update(['searchable'=>$request->status]); 
            return response()->json([  'status' => true, 'message' => 'Searchable status has been changed successfully.' ]);
          }

     } else {
        return response()->json([ 'status' => false, 'message' => 'Method is not post type.' ]);
     }
    
   } catch (\Exception $e) {
         return response()->json([ 'status' => false, 'message' => [
                          "error" => $e->getMessage() ] ]);
    }
  }



  public function publicAvailableStatus(Request $request){   
    try{

    if (!Auth::user()) {
       return redirect('home');
     }
    if($request->isMethod('post'))  
    {
      $userid = Auth::user()->id;
      $validator = Validator::make($request->except("_token"), [
                        'pieogram_id' => 'required',
                        'status' => 'required'                        
            ]);    
        if ($validator->fails()) {
                    return response()->json([
                                'status' => false,
                                'message' => $validator->errors()
                    ]);
                }
        $userExist = User::where('id',$userid)->first();
        if(!empty($userExist)){
            $Pieogram_Id = $request->pieogram_id;
            $update_status = PieVideo::where('id',$Pieogram_Id)->Update(['public_available'=>$request->status, 'is_publish'=>$request->status]); 
            return response()->json([  'status' => true, 'message' => 'Public Available 
 status has been changed successfully.' ]);
          }

     } else {
           return response()->json([ 'status' => false, 'message' => 'Method is not post type.' ]);
     }
    
   } catch (\Exception $e) {
         return response()->json([ 'status' => false, 'message' => [
                          "error" => $e->getMessage() ] ]);
    }
  }


  public function watchedPieogram(Request $request){   
    try{
      /**/
      if($request->isMethod('post'))  
      {
        if (Auth::user()) {
            $userid = Auth::user()->id;
         } 
        $validator = Validator::make($request->except("_token"), [
                          'pieogram_id' => 'required',
         ]);    
          if ($validator->fails()) { 
           return response()->json(['status' => false, 'message' => $validator->errors()]);
          }
            $PiwWatched = new PieWatchedLog();
            $PiwWatched->video_id = $request->pieogram_id;
            if(!empty($userid)){
              $PiwWatched->user_id = $userid; 
            } else {
              $PiwWatched->user_id = 0;
            }
            $PiwWatched->is_delete = 0; 
            $PiwWatched->save();
             return response()->json(['status' => true, 'message' => 'Watched successfully.' ]);
            
       } else {
             return response()->json([ 'status' => false, 'message' => 'Method is not post type.' ]);
       }
    
     } catch (\Exception $e) {
           return response()->json([ 'status' => false, 'message' => [
                            "error" => $e->getMessage() ] ]);
      }
    }


    public function deletecomment(Request $request)
    {
        $id =   $request->input('id');
        $video_id =   $request->input('video_id'); 
        //echo $video_id; die();
        PieVideoComment::where('id', $id)->orwhere('parent_id',$id)->delete(); 
        $videoComment = PieVideoComment::where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
                
          $videoComments = PieVideoComment::where('video_id',$video_id)->get(); //total  Comment
          $total_comment = $videoComments->count();    
           $html = view('Site.pieogram-details.ajax_comment')->with(compact('videoComment','total_comment','video_id'))->render();     
        $response = response()->json(['success' => true, 'html' => $html,'total_comment'=>$total_comment]);
        return $response; 
    }

    public function sharevideo(Request $request)
    {

        $video_id =   $request->input('video_id');
        $platform =   $request->input('type');        
        $insert =  new PieVideoShareLog();
        $insert->video_id = $video_id; 
        if(empty(auth()->user()->id)){
        	$insert->shared_by = auth()->user()->id;
        }else{
        	$insert->shared_by = 0;
        }     
        
        $insert->shared_platform = $platform;        
        $insert->save();  
        $sharecount = PieVideoShareLog::where('video_id',$video_id)->get();
        $total_shared = $sharecount->count();
        $response = response()->json(['success' => true,'total_shared'=>$total_shared]);
        return $response; 
    }

    public function like_video(Request $request)
    {
      $video_id =   $request->input('video_id');      
      $user_id  =   auth()->user()->id;
      $check    =  PieVideoLikeDislike::where('user_id',$user_id)->where('video_id',$video_id)->first();
      
      if(!empty($check))
      {
         $status = $check->like_status;
         if($status == 1)
         {
            $type = 0;
            $dislike = $check->dislike_status;
         }
         elseif($status == 0)
         {
            $type = 1;
            $dislike = 0;
         }
         
         $update_status = PieVideoLikeDislike::where('user_id',$user_id)->where('video_id',$video_id)->Update(['like_status'=>$type,'dislike_status'=>$dislike]);
      }
      else
      {
         $insert = new PieVideoLikeDislike();
         $insert->video_id = $video_id;
         $insert->user_id = $user_id;
         $insert->like_status = 1;         
         $insert->save();
      }
      
        $likelog = new PieVideoLikeLog();
        $likelog->video_id = $video_id;
        $likelog->liked_by = $user_id;      
        $likelog->save();    

      $total_count_like =   PieVideoLikeDislike::where('video_id',$video_id)->where('like_status',1)->count();
      $total_count_dislike = PieVideoLikeDislike::where('video_id',$video_id)->where('dislike_status',1)->count();
      $data    =  PieVideoLikeDislike::where('user_id',$user_id)->where('video_id',$video_id)->first();
      $response = response()->json(['success' => true,'total_count_like'=>$total_count_like,'total_count_dislike'=>$total_count_dislike,'data'=>$data]);
        return $response; 
    }
  
  public function dislike_video(Request $request)
  {
      $video_id =   $request->input('video_id');      
      $user_id  =   auth()->user()->id;
      $check    =  PieVideoLikeDislike::where('user_id',$user_id)->where('video_id',$video_id)->first();
      
      if(!empty($check))
      {
         $status = $check->dislike_status;
         if($status == 1)
         {
            $type = 0;
            $like = $check->like_status;
         }
         elseif($status == 0)
         {
            $type = 1;
            $like = 0;
         }
         
         $update_status = PieVideoLikeDislike::where('user_id',$user_id)->where('video_id',$video_id)->Update(['dislike_status'=>$type,'like_status'=>$like]);
      }
      else
      {
         $insert = new PieVideoLikeDislike();
         $insert->video_id = $video_id;
         $insert->user_id = $user_id;
         $insert->dislike_status = 1;
         //$insert->dislike_status = $type;
         $insert->save();
      }     
        $dislikelog = new PieVideoDislikeLog();
        $dislikelog->video_id = $video_id;
        $dislikelog->disliked_by = $user_id;      
        $dislikelog->save();     

      $total_count_like =   PieVideoLikeDislike::where('video_id',$video_id)->where('like_status',1)->count();
      $total_count_dislike = PieVideoLikeDislike::where('video_id',$video_id)->where('dislike_status',1)->count();
      $data    =  PieVideoLikeDislike::where('user_id',$user_id)->where('video_id',$video_id)->first();
      $response = response()->json(['success' => true,'total_count_like'=>$total_count_like,'total_count_dislike'=>$total_count_dislike,'data'=>$data]);
        return $response;
  }


}
