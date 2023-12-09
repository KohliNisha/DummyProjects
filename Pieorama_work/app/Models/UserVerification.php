<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


use App\Models\PieVideoComment;
use App\Models\PieVideoShareLog;
use App\Models\PieVideoLikeDislike;
use App\Models\PieVideoLikeLog;
use App\Models\PieVideoDislikeLog;
use App\Models\HomepageVideo;
use App\Models\PieWatchedLog;
use App\Models\PieTags;

class UserVerification extends Model
{
    public function generate_code()
	{
		return substr(str_shuffle("0123456789"), 0, 5);	
	}	
	
	
	public function check_user_exists($user_id)
	{
		$users = DB::table('users')
			->where('id', '=', $user_id)->get();
		
		if(!empty($users[0]))
		{
			return 1;
		}
		else
		{
			return 0;  
		}
	}	
	
	
	public function check_user_email_exists($email)
	{
		$users = DB::table('users')
			->where('email', '=', $email)->get();
		
		if(!empty($users[0]))
		{
			return 1;
		}
		else
		{
			return 0;  
		}
	}	
	
	public function get_user_details($user_id)
	{
		$users = DB::table('users')
			->where('id', '=', $user_id)->get();
		
		$user=array(
			'firstname'=>$users[0]->first_name,
			'lastname'=>$users[0]->last_name,
		);
		
		return $user; 
	}
	
	public function sendmail($to,$message,$subject)
	{
		
		
		// To send HTML mail, the Content-type header must be set
		$headers[] = 'MIME-Version: 1.0';
		$headers[] = 'Content-type: text/html; charset=iso-8859-1';

		// Additional headers
		$headers[] = 'To: <'.$to.'>';
		$headers[] = 'From: Pieorama <noreply@pieorama.com>';
		

		// Mail it  
		mail($to, $subject, $message, implode("\r\n", $headers)); 	
		
		/*
		$subject=$subject; 
			
		$url = 'https://api.sendgrid.com/';
		
		$user = 'amitsandal';
		$pass = 'amitsandal123';    
		
		
		$json_string = array(   
			'category' =>'no-reply'    
		);  
		 
		$fromaddress='Pieorama'; 
		$from='noreply@pieorama.com';
		$request = $url . 'api/mail.send.json';
		$html = "<html>".$message."</html>";
		$html = urlencode($html);            
		$session = curl_init($request);   
			    
		curl_setopt($session, CURLOPT_POSTFIELDS, "api_user=".$user."&api_key=".$pass."&x-smtpapi=".json_encode($json_string)."&X-PM-TrackOpens=true&to[]=".$to."&subject=".$subject."&html=".$html."&fromname=".$fromaddress."&from=$from");curl_setopt($session, CURLOPT_HEADER, false);
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		$response = json_decode(curl_exec($session));
		curl_close($session);      
		*/
		
		 
		
		
		
		
	}	
	

	public function timeago($date) 
	{
	   $timestamp = strtotime($date);	
	   
	   $strTime = array("second", "minute", "hour", "day", "month", "year");
	   $length = array("60","60","24","30","12","10");

	   $currentTime = time();
	   if($currentTime >= $timestamp) {
			$diff     = time()- $timestamp;
			for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
			$diff = $diff / $length[$i];
			}

			$diff = round($diff);
			
			if($diff==1)
			{
				return $diff . " " . $strTime[$i] . " ago ";
			}
			else
			{
				return $diff . " " . $strTime[$i]."s ago ";
			} 
			
			
	   }
	}
	
	public function video_duration($filename)
	{
		
		$filename=str_replace(' ','%20',$filename);
		
		//$url = "http://smartzitsolutions.com/pieorama/public/info.php?filename=".$filename; 
		$url = "http://dev.pieorama.flexsin.org/info.php?filename=".$filename; 
		//$url = "http://127.0.0.1:8000/public/info.php?filename=".$filename; 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec ($ch);
		$err = curl_error($ch);  //if you need
		curl_close ($ch);
		 return  $response; 

		
	}	
	
	
}
