<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;
use App\Models\PieChannel;
use App\Models\PieVideoComment;
use Illuminate\Support\Facades\DB;

class Commenhelper
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }


      /**
    * Method for get channel list
    *
    * @param $file
    * @return string
    */
    public static function channelDetails()
    {
        try {
            $ChannelDetails = PieChannel::where('status',1)->where('is_deleted',0)->get();
            return $ChannelDetails;

        } catch (\Exception $e) {
             return $e;
           // dd($e);
        }
    }

    public static function getreply($id,$video_id)
    {
       return  $get_reply = PieVideoComment::with('getprofile_image')->where('video_id',$video_id)->where('parent_id',$id)->get();
    }

    /*for time ago calculate*/

    public static function time_Ago($time) 
    { 
        $times = strtotime($time);
        $diff     = time() - $times;
        $sec     = $diff;   
        $min     = round($diff / 60 );    
        $hrs     = round($diff / 3600); 
        $days     = round($diff / 86400 ); 
        $weeks     = round($diff / 604800);
        $mnths     = round($diff / 2600640 );
        $yrs     = round($diff / 31207680 ); 
          
        // Check for seconds 
        $time = '';
        if($sec <= 60) { 
            $time = "$sec seconds ago"; 
        } 
          
        // Check for minutes 
        else if($min <= 60) { 
            if($min==1) { 
                 $time = "one minute ago"; 
            } 
            else { 
                 $time = "$min minutes ago"; 
            } 
        } 
          
        // Check for hours 
        else if($hrs <= 24) { 
            if($hrs == 1) {  
                 $time = "an hour ago"; 
            } 
            else { 
                 $time = "$hrs hours ago"; 
            } 
        } 
          
        // Check for days 
        else if($days <= 7) { 
            if($days == 1) { 
                 $time = "Yesterday"; 
            } 
            else { 
                 $time = "$days days ago"; 
            } 
        } 
          
        // Check for weeks 
        else if($weeks <= 4.3) { 
            if($weeks == 1) { 
                 $time = "a week ago"; 
            } 
            else { 
                 $time = "$weeks weeks ago"; 
            } 
        } 
          
        // Check for months 
        else if($mnths <= 12) { 
            if($mnths == 1) { 
                 $time = "a month ago"; 
            } 
            else { 
                 $time = "$mnths months ago"; 
            } 
        } 
          
        // Check for years 
        else { 
            if($yrs == 1) { 
                 $time = "one year ago"; 
            } 
            else { 
                 $time = "$yrs years ago"; 
            } 
        }
        //echo $time; die();
        return $time; 
    } 
	
	public static function count_like_dislike($video_id,$comment_id)
	{ 
		
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
		
		$countComment[]=array(
			'id'=>$comment_id,
			'like'=>$count_likes,
			'dislike'=>$count_dislikes,
		);	
       // dd($countComment);  
		return $countComment;
		
	}	
	
	public static function check_user_like_dislike_comment($video_id,$comment_id,$user_id)
	{ 
		
		
		$total_likes = DB::table('comment_like_dislike')
			->where('video_id', '=', $video_id)
			->where('comment_id', '=', $comment_id) 
			->where('user_id', '=', $user_id)
			->get();
		//dd($total_likes);  	
		return count($total_likes);	
		
		
		
		
	}	
    public static function check_user_like_comment($video_id,$comment_id,$user_id)
    { 
        
        
        $user_like_count = DB::table('comment_like_dislike')
            ->where('video_id', '=', $video_id)
            ->where('comment_id', '=', $comment_id) 
            ->where('user_id', '=', $user_id)
            ->where('like','=',1)
            ->where('dislike','=',0)
            ->first();
       // dd($user_like_count);     
        return $user_like_count; 
        
        
        
        
    }   
    public static function check_user_dislike_comment($video_id,$comment_id,$user_id)
    { 
       // dd('sfdf');
        
        $user_dislike_count = DB::table('comment_like_dislike')
            ->where('video_id', '=', $video_id)
            ->where('comment_id', '=', $comment_id) 
            ->where('user_id', '=', $user_id)
            ->where('dislike','=',1)
            ->where('like','=',0)
            ->first();
        //dd($user_dislike_count);     
        return $user_dislike_count; 
        
        
        
        
    }   
	
	
	

	
	

}