<?php
namespace App\Http\Controllers;
use Validator;
use App\Models\User;
use App\Models\Usernotification;
use App\Models\UserVerification;
use App\Models\Userlocation;
use App\Models\ContactUs;
use App\Models\UserLoginLog;
use App\Models\UserDeviceTokenLog;
use Illuminate\Http\Request;
use App\Mail\SignupMail;
use App\Mail\Forgotpassword;
use App\Models\PieChannel;
use App\Models\PieVideo;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helper;

use App\Models\PieVideoComment;
use App\Models\PieVideoShareLog;
use App\Models\PieVideoLikeDislike;
use App\Models\PieVideoLikeLog;
use App\Models\PieVideoDislikeLog;
use App\Models\HomepageVideo;
use App\Models\PieWatchedLog;
use App\Models\PieTags;

class VideoController extends Controller
{
    public $successStatus = 200;
    public $errorStatus = 401;
    
 
/**
 * @api {post} /api/register User Registration
 * @apiName PostRegisterUser
 * @apiGroup Registration/User
 * @apiParam {String} first_name User first name.
 * @apiParam {String} last_name User last name.
 * @apiVersion 0.0.1 
 * @apiSuccess {integer} status 1
 * @apiSuccess {String} message  Success message
 * @apiSuccessExample Success-Response:
 *     HTTP/1.1 200 OK
 *     {
 *       "status": 1,
 *       "message": "Please click on the link that has been sent to your email account to verify your email and continue the registration process."
 *     }
 *
 */
    
	public function homepielisting(Request $request) 
    {   
      try 
		{     
		if($request->isMethod('get'))   
        {
			$validator = Validator::make($request->all(), [
                'page_no' => 'required',
            ]);
            if($validator->fails()) {
                return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
			
			$trendingChannel = PieChannel::where('status',1)->where('is_deleted',0)->where('id',2)->first();
			
			//$trendingVideos = PieVideo::where('status',1)->where('is_deleted',0)->orderBy('id','DESC')->take(5)->get();
			
			$trendingVideos = DB::select("select a.video_id, count('a.*') as 'total_view',a.updated_at,b.* from sc_pie_video_watch_log as a inner join sc_pie_video as b on a.video_id=b.id where b.status='1' and b.is_deleted='0' group by a.video_id ORDER BY `total_view` DESC");
			
			//print_r($trendingVideos);
			
			$user_verify=new UserVerification;
			
			
			$page_no=$request->page_no;
			
			$mainarray=array();
			if(!empty($trendingVideos))
			{
				foreach($trendingVideos as $row)
				{
					
					$thumb=$row->video_thumbnail_file_path;
					$user_id=$row->created_by;
					$updated_at=$row->updated_at;
					
					if($thumb=='')
					{
						$thumb=null;	
					}	

					$user_array=$user_verify->get_user_details($user_id);
					$updated_at=$user_verify->timeago($updated_at);
					
					$firstname=$user_array['firstname']; 
					
					$mainarray[]=array(
						'id'=>$row->id,		
						'total_view'=>$row->total_view,		
						'thumb_img'=>$thumb,		
						'video_title'=>$row->video_title,		
						'username'=>$firstname, 		
						'updated_at'=>$updated_at, 
					);  
				}
				
				
				$need_to_show=10;
				$product_count = count($mainarray); 
				$pages_count = ceil($product_count/$need_to_show); 
				
				if($page_no >$product_count){
					return ['status'=>0,'message'=>'Page exceed its limit' ];
					die;
				}
				  
				
				
				
				$end = (($need_to_show)*$page_no);
				if($end>$need_to_show){
				 $start = ($need_to_show*($page_no-1));
				}else{
					$start = 0;
				}
				 // echo 'start'.$start;
				 // echo 'end'.$end;
				$data_count= count($mainarray);
				
				$dataaa= array_slice($mainarray,$start,$need_to_show);
				
				//$result_data=array('result_array'=>$dataaa,'page_no'=>$page_no,'pie_count'=>$product_count,'pages'=>$pages_count);
				
				return ['status'=>1,'message'=>$dataaa,'page_no'=>$page_no,'pie_count'=>$product_count,'pages'=>$pages_count ];
				
			}
			else
			{
				$dataaa=array();
				$page_no=0;
				$product_count=0;
				$pages_count=0; 
				
				return ['status'=>0,'message'=>$dataaa,'page_no'=>$page_no,'pie_count'=>$product_count,'pages'=>$pages_count ];
			}		
			
			
        }
	   } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
       }
    }


	public function searchpie(Request $request) 
    {   
      try 
		{     
		if($request->isMethod('get'))   
        {
			$validator = Validator::make($request->all(), [
                'text' => 'required', 
                'page_no' => 'required',
            ]);
            if($validator->fails()) {
                return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
			
			$page_no=$request->page_no;
			$text=$request->text;
			
			$trendingChannel = PieChannel::where('status',1)->where('is_deleted',0)->where('id',2)->first();
			
			//$trendingVideos = PieVideo::where('status',1)->where('is_deleted',0)->orderBy('id','DESC')->take(5)->get();
			$sql="select a.video_id, count('a.*') as 'total_view',a.updated_at,b.* from sc_pie_video_watch_log as a inner join sc_pie_video as b on a.video_id=b.id where b.status='1' and b.is_deleted='0'  and b.video_title REGEXP '".$text."' group by a.video_id ORDER BY `total_view` DESC";
			$trendingVideos = DB::select($sql);     
			
			//print_r($trendingVideos);
			
			$user_verify=new UserVerification;
			
			
			
			
			$mainarray=array();
			if(!empty($trendingVideos))
			{
				foreach($trendingVideos as $row)
				{
					
					$thumb=$row->video_thumbnail_file_path;
					$user_id=$row->created_by;
					$updated_at=$row->updated_at;
					
					if($thumb=='')
					{
						$thumb=null;	
					}	

					$user_array=$user_verify->get_user_details($user_id);
					$updated_at=$user_verify->timeago($updated_at);
					
					$firstname=$user_array['firstname']; 
					
					$mainarray[]=array(
						'id'=>$row->id,		
						'total_view'=>$row->total_view,		
						'thumb_img'=>$thumb,		
						'video_title'=>$row->video_title,		
						'username'=>$firstname, 		
						'updated_at'=>$updated_at, 
					);  
				}
				
				
				$need_to_show=10;
				$product_count = count($mainarray); 
				$pages_count = ceil($product_count/$need_to_show); 
				
				if($page_no >$product_count){
					return ['status'=>0,'message'=>'Page exceed its limit' ];
					die;
				}
				  
				
				
				
				$end = (($need_to_show)*$page_no);
				if($end>$need_to_show){
				 $start = ($need_to_show*($page_no-1));
				}else{
					$start = 0;
				}
				 // echo 'start'.$start;
				 // echo 'end'.$end;
				$data_count= count($mainarray);
				
				$dataaa= array_slice($mainarray,$start,$need_to_show);
				
				//$result_data=array('result_array'=>$dataaa,'page_no'=>$page_no,'pie_count'=>$product_count,'pages'=>$pages_count);
				
				return ['status'=>1,'message'=>$dataaa,'page_no'=>$page_no,'pie_count'=>$product_count,'pages'=>$pages_count ];
				
			}
			else
			{
				$dataaa=array();
				$page_no=0;
				$product_count=0;
				$pages_count=0; 
				
				return ['status'=>0,'message'=>$dataaa,'page_no'=>$page_no,'pie_count'=>$product_count,'pages'=>$pages_count ];
			}		
			
			
        }
	   } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
       }
    }

	public function pieogramsDetails(Request $request) 
    {   
      try 
		{     
		if($request->isMethod('get'))   
        {
			$validator = Validator::make($request->all(), [
                'id' => 'required', 
               
            ]);
            if($validator->fails()) {
                return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
			
			
			$video_id=$request->id;
			$videoDetails = PieVideo::where('status',1)->where('is_deleted',0)->where('id',$video_id)->first();
			
			if(!empty($videoDetails)) {
			
			
			$videoComment = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
			$videoComments = PieVideoComment::where('video_id',$video_id)->get(); //total  Comment
            $total_comment = $videoComments->count();
			
			$videoTags = PieTags::where('is_deleted',0)->where('video_id',$video_id)->orderBy('id','ASC')->get();
            $TotalvideoViewsCount = PieWatchedLog::where('video_id',$video_id)->where('is_delete',0)->count(); 
            $totalsharecount = PieVideoShareLog::where('video_id',$video_id)->count();
            $total_count_like =   PieVideoLikeDislike::where('video_id',$video_id)->where('like_status',1)->count();
            $total_count_dislike = PieVideoLikeDislike::where('video_id',$video_id)->where('dislike_status',1)->count();
			
			$user_id=$videoDetails['created_by'];
			$user = DB::table('users')->where('id', $user_id)->first();
			
			$video_title=$videoDetails->video_title;
			$video_description=$videoDetails->video_description;
			$video_file_path=$videoDetails->video_file_path;
			$video_description=$videoDetails->video_description;
			
			if($video_file_path!='')
			{
				$video_file_path=url('uploads/').'/'.$video_file_path; 	
			}	
			else
			{
				$video_file_path=null;
			}
			$created_by=$videoDetails->created_by;
			$created_at=$videoDetails->created_at->diffForHumans();
			
			$video_file_path;
			$tagArray=array();
			if(!empty($videoTags))
			{
				foreach($videoTags as $row)
				{
					$tagArray[]=array(
						'id'=>$row->id,
						'tag_name'=>$row->tag_text,
					);	
				}	
			}	
			
			
			$user_verify=new UserVerification;
			$userArray=$user_verify->get_user_details($created_by);
			
			$username=$userArray['firstname'].' '.$userArray['lastname'];
			 
			$video_array=array(
				'video_id'=>$video_id,
				'video_title'=>$video_title,
				'video_details'=>$video_description, 
				'video_path'=>$video_file_path,
				'posted_on'=>$created_at,
				'total_comment'=>$total_comment,
				'total_like'=>$total_count_like,
				'total_dislike'=>$total_count_dislike,
				'total_view'=>$TotalvideoViewsCount,
				'tags'=>$tagArray,
				'username'=>$username,
			); 
			
			
				//print_r($video_array); 
				return ['status'=> 1, 'message' => $video_array];
			
			}
			else
			{
				$video_array=array();
				return ['status'=> 0, 'message' => $video_array];
			}
			
				  
			
			
        }
	   } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
       }
    }
	
	
	public function mypielist(Request $request) 
    {   
      try 
		{     
		if($request->isMethod('get'))   
        {
			$validator = Validator::make($request->all(), [
                'user_id' => 'required', 
                'page_no' => 'required',
            ]);
            if($validator->fails()) {
                return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
			
			$page_no=$request->page_no;
			$user_id=$request->user_id; 
			
			$user_verify=new UserVerification;
			$user_exists=$user_verify->check_user_exists($user_id);
			
			
			if($user_exists==0)
			{
				return ['status'=>0, 'message' => 'User no exists', 'user_id'=>$user_id]; 	
				die;
			}	
			
			
			$trendingChannel = PieChannel::where('status',1)->where('is_deleted',0)->where('id',2)->first();
			
			//$trendingVideos = PieVideo::where('status',1)->where('is_deleted',0)->orderBy('id','DESC')->take(5)->get();
			$sql="select a.video_id, count('a.*') as 'total_view',a.updated_at,b.* from sc_pie_video_watch_log as a inner join sc_pie_video as b on a.video_id=b.id where b.status='1' and b.is_deleted='0' and b.created_by='".$user_id."' group by a.video_id ORDER BY `total_view` DESC";
			
			
			
			$trendingVideos = DB::select($sql);     
			
			//print_r($trendingVideos);
			
			$user_verify=new UserVerification;
			
			
			
			
			$mainarray=array();
			if(!empty($trendingVideos))
			{
				foreach($trendingVideos as $row)
				{
					
					$thumb=$row->video_thumbnail_file_path;
					$user_id=$row->created_by;
					$updated_at=$row->updated_at;
					
					if($thumb=='')
					{
						$thumb=null;	
					}	

					$user_array=$user_verify->get_user_details($user_id);
					$updated_at=$user_verify->timeago($updated_at);
					
					$firstname=$user_array['firstname']; 
					
					$mainarray[]=array(
						'id'=>$row->id,		
						'total_view'=>$row->total_view,		
						'thumb_img'=>$thumb,		
						'video_title'=>$row->video_title,		
						'username'=>$firstname, 		
						'updated_at'=>$updated_at, 
					);  
				}
				
				
				$need_to_show=10;
				$product_count = count($mainarray); 
				$pages_count = ceil($product_count/$need_to_show); 
				
				if($page_no >$product_count){
					return ['status'=>0,'message'=>'Page exceed its limit' ];
					die;
				}
				  
				
				
				
				$end = (($need_to_show)*$page_no);
				if($end>$need_to_show){
				 $start = ($need_to_show*($page_no-1));
				}else{
					$start = 0;
				}
				 // echo 'start'.$start;
				 // echo 'end'.$end;
				$data_count= count($mainarray);
				
				$dataaa= array_slice($mainarray,$start,$need_to_show);
				
				//$result_data=array('result_array'=>$dataaa,'page_no'=>$page_no,'pie_count'=>$product_count,'pages'=>$pages_count);
				
				return ['status'=>1,'message'=>$dataaa,'page_no'=>$page_no,'pie_count'=>$product_count,'pages'=>$pages_count ];
				
			}
			else
			{
				$dataaa=array();
				$page_no=0;
				$product_count=0;
				$pages_count=0; 
				
				return ['status'=>0,'message'=>$dataaa,'page_no'=>$page_no,'pie_count'=>$product_count,'pages'=>$pages_count ];
			}		
			
			
        }
	   } catch (\Exception $e) { 
            return ['status'=> 0, 'message' => [$e->getMessage()]];
       }
    }
	
	
	
	

}
