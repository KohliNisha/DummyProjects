<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PiableMoments;
use App\Models\UserVerification;
use DB;
use Auth;
use App\Helpers\Helper as Helper;

class PieController extends Controller
{
   public function index(){
   		
   	$pie_moments = PiableMoments::where('is_delete',0)
   					->where('status',0)
   					->orderBy('id','DESC')
   					->get();

   	$user_verify=new UserVerification;

   	foreach ($pie_moments as $key => $v) {
   		$date =  $v->created_at;
		$v->NewCreatedDate = date('d M Y', strtotime($date));
		$v->NewCreatedTime = date('h:i A', strtotime($date));
		$v->used= Helper::usedpieableUser($v->id);
		//$v->updated_at=$user_verify->timeago($v->updated_at);
		/*$v->duration=0;
		if($v->video_file_path!='')
		{
			$v->duration=$user_verify->video_duration($v->video_file_path);	
		}*/
   	}
    return view('Site.pie-moments.pie_moments',compact('pie_moments'));  

    } 


    
   
}
