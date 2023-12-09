<?php
namespace App\Http\Controllers\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Validator;
use Auth;
use Session;
use App\Models\User;
use App\Models\ContactUs;
use App\Models\Usernotification;
use App\Models\UserVerification;
use App\Models\Userlocation;  
use App\Models\PlTransaction;
use App\Models\PieChannel;
use App\Models\PieVideo;
use App\Models\Pages;
use App\Models\PieVideoComment;
use App\Models\HomepageVideo;
use App\Models\PieVideoShareLog;
use App\Models\PieVideoLikeDislike;
use App\Models\PieVideoLikeLog;
use App\Models\PieTags;
use App\Models\Bulkmail;
use App\Models\Welcome;
use App\Models\Unsubscribe_users;
use App\Models\PieWatchedLog;
use App\Models\homepageWatchLog;
use App\Mail\SignupMail;
use App\Mail\forgotpassworduser;
use App\Mail\WelcomeEmail;
use App\Mail\Forgotpassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\ContactUsSendToAdmin;
use App\Mail\ContactUsSendToUser;
use App\Http\Controllers\Api\UsersignupController;
use Illuminate\Support\Facades\DB;
use Socialite;
use Exception;
use Cookie;
use Illuminate\Support\Facades\Storage;

//use Helper;
use App\Helpers\Helper as Helper;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
     
    }

    protected $redirectTo = 'dashboard';
    protected function guard() {
        return Auth::guard("admin");
    }



     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    $pages = Pages::where('id',8)->where('status',0)->first();
    //dd($landingpage);
    if(isset($pages)){
    	
    	return view('Site.landing_page.landing_page',compact('pages')); 	
    }
    $request->session()->forget('video_id');
    $user_ip=$request->ip();
   	$checkIp = homepageWatchLog::where('is_delete',0)->where('user_Ip',$user_ip)->first();
   	//dd($checkIp);
   	if(isset($checkIp)){
   	   $cookie_value = 1;
   	}else{
   		$cookie_value = 0;
   		$insertdata = new homepageWatchLog();
   		$insertdata->user_Ip = $user_ip;
   		$insertdata->is_delete = 0;
   		$insertdata->save();

   	}
	   
      try {
        $MainVideo = HomepageVideo::where('id',1)->first();
        $welcome_message1 = Welcome::where('user_id', 1)->where('status',1)->first();
        $welcome_message = $welcome_message1->welcome_message??'';
        $background_color = $welcome_message1->background_color??'#9295CA';
        $foreground_color = $welcome_message1->foreground_color??'#000000';
        
        if(isset($MainVideo->file_name)){
           $MainPagevd = $MainVideo->file_name;
           $MainPageThumb = $MainVideo->file_image;
           $MainPagebackgroundColor = $MainVideo->background_color;
        } else {
          $MainPagevd = asset('default_video.mp4');
          $MainPageThumb = asset('website/images/sddefault.jpg');
           $MainPagebackgroundColor = "black";
        } 
        $moregif = PieVideo::where('status',1)
	    			->where('is_deleted',0)
	    			->get();

	      $Allgif = PieVideo::where('status',1)
	    			->where('is_deleted',0)
	    			->where('gif_corner',1)
	    			->orderBy('profiled_pieogram','DESC')
	    			->orderBy('id','DESC')
	    			->take(4)
	    			->get();
	    	foreach($Allgif as $key=>$row)
			{
				$title = $row['video_title'];
			  //  $dd = strlen( $title);
			    //echo '<pre>'; print_r($dd);
			    if( strlen( $title) > 44) {
				    $title= explode( "\n", wordwrap( $title, 44));
				    $title= $title[0] . '...';
				}else{
					$title = $row['video_title'];
				}
				$row['title'] = $title;
				$video_idddd=base64_encode($row['id']);

				$row['video_idddd']=urlencode(base64_encode($video_idddd));
				$row['video_idddd']=str_replace('%3D%3D', '', $row['video_idddd']);
			}


        return view('Site.index.index',compact('MainPagevd','MainPageThumb','MainPagebackgroundColor','welcome_message','background_color','foreground_color','cookie_value','Allgif','moregif'));

        } catch (\Exception $e) {
            return response()->json([
                        'status' => false,
                        'message' => [
                            "err" => $e->getMessage()
                        ]
            ]);
        }     
    }
     public function sendData(Request $request){
    	//dd($request->all());
    	/*$countvideos = PieVideo::where('status',1)
    			->where('is_deleted',0)
    			->where('profiled_pieogram',1)
    			->get()->count();*/


      /* if($request->type == 1 && $countvideos > 0) {
   		 $AllVideos = PieVideo::where('status',1)
    			->where('is_deleted',0)
    			->where('profiled_pieogram',1)
    			->orderBy('id','DESC')
    			//->skip($request->start)
    			//->take(20)
				->get();
       
       }else*/

     //  {
   		 $AllVideos = PieVideo::where('status',1)
    			->where('is_deleted',0)
    			->whereNotNull('small_gif')
    			//->whereNotNull('video_file_path')
    			->where('is_deleted',0)
    			->orderBy('profiled_pieogram','DESC')
    			->orderBy('id','DESC')
    			->skip($request->start)
    			->take($request->end - $request->start)
    			
    			->get();
      // }
     	//dd($AllVideos);
		$user_data=array();

		$user_verify=new UserVerification;
		 
		
		foreach($AllVideos as $key=>$row)
		{
			$title = $row['video_title'];
		  //  $dd = strlen( $title);
		    //echo '<pre>'; print_r($dd);
		    if( strlen( $title) > 44) {
			    $title= explode( "\n", wordwrap( $title, 44));
			    $title= $title[0] . '...';
			}else{
				$title = $row['video_title'];
			} 
			//$AllVideos[$key]['video_title']=$title;
			$row['title'] = $title;
			$video_id=$row['id'];	
			$user_id=$row['created_by'];	
			$updated_at=$row['updated_at'];	
			$video_file_path=$row['video_file_path'];	
			$video_idddd=base64_encode($row['id']);

			$row['video_idddd']=urlencode(base64_encode($video_idddd));
			$row['video_idddd'] = str_replace('%3D%3D', '', $row['video_idddd']);
			$updated_at=$user_verify->timeago($updated_at);
			
			$user = DB::table('users')->where('id', $user_id)->first();
			
			$firstname=$user->first_name??'';
			$lastname=$user->last_name??'';
			$video_idddd=base64_encode($row['id']);

			$row['video_idddd']=urlencode(base64_encode($video_idddd));

			
			$TotalvideoViewsCount = PieWatchedLog::where('video_id',$video_id)->where('is_delete',0)->count(); 
			$videoTags = PieTags::where('is_deleted',0)->where('video_id',$video_id)->orderBy('id','ASC')->get();  
			//$user_name=$firstname.' '.$lastname;
			
			$totalsharecount = PieVideoShareLog::where('video_id',$video_id)->count();
            $total_count_like =   PieVideoLikeDislike::where('video_id',$video_id)->where('like_status',1)->count();
            $total_count_dislike = PieVideoLikeDislike::where('video_id',$video_id)->where('dislike_status',1)->count();
			
			$videoComment = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
                
			$videoComments = PieVideoComment::where('video_id',$video_id)->get(); //total  Comment
			$total_comment = $videoComments->count();
			
			
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
			
				
			
			$all_user[]=array(
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
			
			$date =  $row['created_at'];
		    $row['NewCreatedDate'] = date('d M Y', strtotime($date));
		    $row['NewCreatedTime'] = date('h:i A', strtotime($date));
			$row['title'] = $title ;
			
		}
		//dd($AllVideos);
		 $response = response()->json(['success' => true, 'AllVideos' => $AllVideos,'all_user'=>$all_user??'', 'videoTags' => $videoTags??'']);
   		 return $response; 
		
	}
	
	public function search(request $request)
    { 

		/* $validator = Validator::make($request->except("_token"), [
					'search_text' => 'required'
					
		],[
			   'search_text.required' => 'This field is required'
		]);
		if ($validator->fails()) {
			return response()->json([
						'status' => false,
						'message' => $validator->errors()
			]);
		} */
		
		$search_text=$request->search_text; 
		$fulltext = $request->search_text; 
		if($search_text!='')
		{
			$AllVideos = array();
			
			if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $search_text))
				{
					$search_str = explode('#' , $search_text);
						//dd($search_str);
						
							$AllVideos2 = PieVideo::leftjoin('sc_pie_tags', 'sc_pie_tags.video_id', '=', 'sc_pie_video.id')
							->where('sc_pie_video.status',1)
							//->whereNotNull('sc_pie_video.video_file_path')
							->whereNotNull('sc_pie_video.small_gif')
							//->where('sc_pie_video.video_thumbnail_file_path','!=',null)
							->where('sc_pie_video.is_deleted',0)
							
							->where(function ($query) use($search_str){
								foreach ($search_str as $v) {
									 if($v != ''){
									 	$v = str_replace(' ', '', $v);
									 	//dd($v);
									 $query->orwhere('sc_pie_video.video_title', 'like', '%'.$v.'%')
             						 ->orwhere('sc_pie_video.video_description', 'like', '%'.$v.'%')
					                   ->orWhere('sc_pie_tags.tag_text', 'like', '%'.$v.'%');
					             	  }
					             	}
					            		})->select('sc_pie_video.*','sc_pie_tags.tag_text')
											->orderBy('sc_pie_video.id','DESC')
											->groupBy('sc_pie_tags.video_id')
											->get();
								
									
					$AllVideos = $AllVideos2;
					//dd($AllVideos);	
				}elseif ($search_text == trim($search_text) && strpos($search_text, ' ') !== false) {
							 $search_str = explode(' ' , $search_text);
							//dd($search_str);

						
						
							$AllVideos2 = PieVideo::leftjoin('sc_pie_tags', 'sc_pie_tags.video_id', '=', 'sc_pie_video.id')
							//->where('sc_pie_video.video_thumbnail_file_path','!=',null)
							//->whereNotNull('sc_pie_video.video_file_path')
							->whereNotNull('sc_pie_video.small_gif')
							->where('sc_pie_video.status',1)
							->where('sc_pie_video.is_deleted',0)
							
							->where(function ($query) use($search_str){
								foreach ($search_str as $v) {
									 if($v != ''){
									 $query->orwhere('sc_pie_video.video_title', 'like', '%'.$v.'%')
             						 ->orwhere('sc_pie_video.video_description', 'like', '%'.$v.'%')
					                   ->orWhere('sc_pie_tags.tag_text', 'like', '%'.$v.'%');
					             	  }
					             	}
					            		})->select('sc_pie_video.*','sc_pie_tags.tag_text')
											->orderBy('sc_pie_video.id','DESC')
											->groupBy('sc_pie_tags.video_id')
											->get();
								
				                
							
						 
					/*foreach ($search_str as $key => $v) {
						
						 
					
					}*/
				$AllVideos = $AllVideos2;	
				//dd($AllVideos);
								
				}else{
							
							/*if( strlen($search_text) > 5){
								$search_text = substr($search_text,0,5);
							}*/
						 /*	if ($search_text.length() > 3) 
									{
									    $search_text = $search_text.substring(0, 3);
									} 
									else
									{
									    $search_text = $search_text;
									}*/
								//	dd($search_text);
				$AllVideos3 = PieVideo::leftjoin('sc_pie_tags', 'sc_pie_tags.video_id', '=', 'sc_pie_video.id')
								->where('sc_pie_video.status',1)
								//->whereNotNull('sc_pie_video.video_file_path')
								->whereNotNull('sc_pie_video.small_gif')
								->where('sc_pie_video.video_thumbnail_file_path','!=',null)
								->where('sc_pie_video.is_deleted',0)
								->where(function ($query) use($search_text){
					                  $query->where('sc_pie_video.video_title', 'like', '%'.$search_text.'%')
	             						 ->orwhere('sc_pie_video.video_description', 'like', '%'.$search_text.'%')
					                   ->orWhere('sc_pie_tags.tag_text', 'like', '%'.$search_text.'%');
					            		})->select('sc_pie_video.*','sc_pie_tags.tag_text')
										->orderBy('sc_pie_video.id','DESC')
										->groupBy('sc_pie_tags.video_id')
										->get();
			//dd($AllVideos3);
									
			$AllVideos1 = PieVideo::leftjoin('users','users.id','=','sc_pie_video.created_by')
						->where('sc_pie_video.status','=',1)
						//->whereNotNull('sc_pie_video.video_file_path')
						->whereNotNull('sc_pie_video.small_gif')
						->where('sc_pie_video.video_thumbnail_file_path','!=',null)
						->where('sc_pie_video.is_deleted',0)
					   ->where(function ($query) use($search_text){
	                  $query->where('sc_pie_video.video_title', 'like', '%'.$search_text.'%')
	                  ->orwhere('sc_pie_video.video_description', 'like', '%'.$search_text.'%')
	                  ->orwhere((DB::raw("CONCAT(users.first_name,' ',users.last_name)")), 'like',"%". $search_text. "%");
	            })->select('sc_pie_video.*')->orderBy('sc_pie_video.id','DESC')->get();
			
	          	 // $AllVideos = $AllVideos1;  
					   if((count($AllVideos1) > 0) && (count($AllVideos3) > 0)){

						$AllVideos = $AllVideos3;
							}elseif ((count($AllVideos1) > 0) && (count($AllVideos3) == 0)) {
							$AllVideos = $AllVideos1;
							}elseif ((count($AllVideos3) > 0) && (count($AllVideos1) == 0)){
							$AllVideos = $AllVideos3;
						}	
		  	 }
				
			
		
			

		}
		else
		{
			$AllVideos = ''; 
		}

		$user_data=array();

		$user_verify=new UserVerification;
		 
		$all_user=array();
		if(!empty($AllVideos)){
			$videocount = $AllVideos->count();
		}else{
			$videocount = 0;
		}
		
		if($videocount > 0){
		foreach($AllVideos as $row)
		{
			$video_id=$row->id;	
			$user_id=$row->created_by;	
			$updated_at=$row->updated_at;	
			$video_file_path=$row->video_file_path;	     
			
			$updated_at=$user_verify->timeago($updated_at);  
			
			$user = User::where('id',$user_id)->first();
				
			$firstname=$user['first_name']; 
			//dd($firstname);
			$lastname=$user['last_name'];
			$TotalvideoViewsCount = PieWatchedLog::where('video_id',$video_id)->where('is_delete',0)->count(); 
			$videoTags = PieTags::where('is_deleted',0)->where('video_id',$video_id)->orderBy('id','ASC')->get(); 
			//dd($videoTags); 
			//$user_name=$firstname.' '.$lastname;
			
			$totalsharecount = PieVideoShareLog::where('video_id',$video_id)->count();
            $total_count_like =   PieVideoLikeDislike::where('video_id',$video_id)->where('like_status',1)->count();
            $total_count_dislike = PieVideoLikeDislike::where('video_id',$video_id)->where('dislike_status',1)->count();
			
			$videoComment = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->orderBy('id','DESC')->get();
                
			$videoComments = PieVideoComment::where('video_id',$video_id)->get(); //total  Comment
			$total_comment = $videoComments->count();
			
			
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
			
			
			//dd($firstname);
			$all_user[]=array(
				'user_firstname'=>$firstname,	
				'user_lastname'=>$lastname,
				'view'=>$TotalvideoViewsCount,
				'tags'=>$tagArray, 
				'totalsharecount'=>$totalsharecount, 
				'total_count_like'=>$total_count_like, 
				'total_count_dislike'=>$total_count_dislike,
				'total_comment'=>$total_comment,
				'updated_at'=>$updated_at,
				//'duration'=>$duration, 
			);
			//dd($all_user);
			
		}
	}
		$search_text = $fulltext;
		//dd($search_text);
		//dd($all_user);
		//print_r($all_user);
		return view('Site.index.search',compact('AllVideos','all_user','videoTags', 'search_text', 'videocount'));   
		//return view('Site.index.search')->with(['AllVideos' => $AllVideos, 'all_user' => $all_user, 'videoTags' => $videoTags]);   
		
		
    }  
	

    public function aboutUs()
    { 
		
		$pages = DB::table('pages')->where('id', 1)->where('status', 1)->get(); 
		 
        return view('Site.about-us.about-us',compact('pages'));
    }

    public function termsOfUse()
    { 
        $pages = DB::table('pages')->where('id', 4)->where('status', 1)->get();  
		return view('Site.terms-of-use.terms-of-use',compact('pages'));
    }

    public function privacyPolicy()
    { 
        $pages = DB::table('pages')->where('id', 3)->where('status', 1)->get();  
		return view('Site.privacy-policy.privacy-policy',compact('pages'));
    }

    public function getHelp()
    { 
        $pages = DB::table('pages')->where('id', 5)->where('status', 1)->get();  
		return view('Site.get-help.get-help',compact('pages')); 
    }

    public function pieHistory()
    { 
        $pages = DB::table('pages')->where('id', 2)->get(); 
		return view('Site.pie-history.pie-history',compact('pages')); 
    }
    public function landingPage(){
    	 $pages = DB::table('pages')->where('id', 8)->where('status', 1)->get(); 
		return view('Site.landing_page.landing_page',compact('pages')); 
    }

    /**
     * Create User under the pericular user role id
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function signUp(Request $request) {
        try {
            if ($request->ajax()) {
            	//dd($request->all());
                $validator = Validator::make($request->except("_token"), [
                            'first_name' => 'required',
                            'last_name' => 'required',
                            'email' => 'required|email',
                            'password' => 'required|min:8',
                            'agree' => 'required',
                            //'newsletters' => 'required',
                ],[
                       'first_name.required' => 'The user role field is required.', 
                       'last_name.required' => 'The name field is required.', 
                       'email.required' => 'The email field is required.', 
                       //'password.regex' => 'The password should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.', 
                       'password.min' => 'The password must be at least 8 characters long. It cannot consist of only lowercase characters', 

                ]);
               
                if (ctype_lower($request->password)) { 
               	//dd('test');
				 return response()->json([
                                'status' => false,
                                'message' => [
                                    'passmessage' => 'The password cannot consist of only lowercase characters.'
                                ]  
                                
                    ]);
				}else if ($validator->fails()) {
                    return response()->json([
                                'status' => false,
                                
                                'message' => $validator->errors()
                    ]);
                }
                $getsameuser = User::where(['email' => $request->email])->first();
             	  if(isset($getsameuser)){
                	if($getsameuser['is_confirm'] == 0){
                		$url =  url('/')."/resend-emailVerification/".encrypt($getsameuser->id.':'.$getsameuser->auth_token);
                		return response()->json([
                                'status' => false,
                                'message' => [
                                    'emailExist' => 'You have not completed the sign-up process. Click <a href="'.$url.'" style="color:#ffffff; text-decoration: underline; font-size: 1rem;">here</a> to receive another e-mail confirmation message. '
                                ]  
                       ]);
                	}else{
                    return response()->json([
                                'status' => false,
                                'message' => [
                                    'emailExist' => 'This e-mail address is already registered. Click <a href="javascript:;" class="frg" data-dismiss="modal" data-toggle="modal" data-target="#myModal3" style="color:#ffffff; text-decoration:underline; font-size: 1rem;">here</a> to reset your password.'
                                ]  
                       ]);
                	}
                }

                $data = $request->except('_token');
                //$date_of_birth = date("Y-m-d", strtotime($request->date_of_birth));
                //$date_of_birth=date('Y-m-d');  
				$data['date_of_birth'] = $request->date_of_birth; 
                $data['password'] = bcrypt($request->password); 
                $data['status'] = 1;
                $data['signupstep'] = 1;
                $data['auth_token'] = mt_rand();
                $data['last_time_used'] = now();
                $data['is_confirm'] = 0;
                $data['device_type'] = 3;
                $data['user_role'] = 2;
                if(isset($request->newsletters)){
                	$data['newsletter'] = 1;
                }else{
                	$data['newsletter'] = 0;
                }
               
                $user = User::create($data);
                if($user){
                	$Unsubscribe_users = new Unsubscribe_users();
                	$Unsubscribe_users->name = $data['first_name'].' '.$data['last_name'];
                	$Unsubscribe_users->email = $data['email'];
                	if(isset($request->newsletters)){
                	   $Unsubscribe_users->newsletter = 1;
	                }else{
	                	$Unsubscribe_users->newsletter = 0;
	                }
	                $Unsubscribe_users->status = 1;
	                $Unsubscribe_users->is_delete = 0;
	                $Unsubscribe_users->save();
                }

                Auth::logout();
               // Auth::login($user, true);	
                $url =  url('/')."/activate-account/".encrypt($user->id.':'.$user->auth_token);
               /* $message='
				<p>Hello User</p>
				<p>Welcome to Pieorama</p>
				<p>Please click <a href='.$url.'>here</a> to verify your account</p>
				'; */ 
				
				/*$user_verify=new UserVerification;    
				 
				$user_verify->sendmail($user->email,$message,'Verify Email'); */
				
				 
				Mail::to($user->email)->send(new SignupMail($user,$url));
				

                return response()->json([
                            'status' => true,
                            'message' => 'Within the next 5 minutes a verfication link will be sent to your e-mail address. Please click on the link in this message in order to complete the registration process. Please also check your spam folder for this message.'
                ]); 
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
     * User will login with valid email id and password
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function signIn(Request $request) {

        try {
            if ($request->ajax()) {
                if ($request->isMethod('post')) {
                    $validator = Validator::make($request->except("_token"), [
                                'email' => 'required|email',
                                'password' => 'required'
                    ],[
                       'email.required' => 'The email field is required.', 
                       'password.required' => 'The password field is required.', 
                    ]);
                    if ($validator->fails()) {
                        return response()->json([
                                    'status' => false,
                                    'message' => $validator->errors()
                        ]);
                    }
                    Auth::logout();
                    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                        $userdata = Auth::User();      //fetch all data
                        $user_role = $userdata->user_role;                       
                        if($user_role == 2){ // for user login only
                           if($userdata->is_confirm == 1){
                             $sessionName = 'user_role'; 
                             Session::put($sessionName, $user_role);
                             return response()->json([
                                      'status' => true,
                                      'user_role' => $user_role,
                                      'message' => 'You are now logged on.'
                             ]);
                           } else {
                            Auth::logout();

                            $url =  url('/')."/resend-emailVerification/".encrypt($userdata->id.':'.$userdata->auth_token);
                		

                             return response()->json([
                                      'status' => false,
                                      'emailverification'=>true,
                                      'message' => 'You have not completed the sign-up process. Click <a  href="'.$url.'" style="color:#ffffff; text-decoration:underline; font-size: 1rem;">here</a> to receive another e-mail confirmation message.'
                             ]);
                           }
                        } else {
                          return response()->json([
                                    'status' => false,
                                    'message' => [
                                        'invalid_detail' => 'Email id or Password is incorrect.',
                                    ]
                          ]);
                        }                        
                    } else {
                        return response()->json([
                                    'status' => false,
                                    'message' => [
                                        'invalid_detail' => 'Email id or Password is incorrect.',
                                    ]
                        ]);
                    }
                }
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
     * User will login with valid email id and password
     * 
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function forgotPassword(Request $request) {
        try {
            if ($request->ajax()) {
                   
                $validator=Validator::make($request->all(),[
                    'email'=>'required|email'
                    ],[
                    'email.required' => 'Email is required',
                    'email.email' => 'Please enter valid email id',
                    ]);
                if($validator->fails())
                {
                     return response()->json([
                        'status'=>false,
                        'errors'=>$validator->errors()
                    ]);
                }

                $user = User::where('email', $request->email)->Where('user_role', 2)->first();
                if(!empty($user)){
                    if($user->status == '0'){
                        return response()->json(["status" => false, "errors_res"=>'Your account is not activated.  Please contact support@pieorama.com we are happy to help you.']);     
                    }

               
                      if($user->is_confirm == 0){

                      	$url =  url('/')."/resend-emailVerification/".encrypt($user->id.':'.$user->auth_token);
                		

                             return response()->json([
                                      'status' => false,
		                               
		                                   'errors_res' => 'You have not completed the sign-up process. Click <a href="'.$url.'" style="color:#ffffff; text-decoration: underline; font-size: 1rem;">here</a> to receive another e-mail confirmation message. '
		                                
                             ]);

                      }else{
					 
					 
					/*$first_name=$user->first_name;
					$last_name=$user->last_name;
					
					$name=$first_name.' '.$last_name;

					$message='
					<p>Hello '.$name.'</p>
					<p>Please click <a href='.$url.'>here</a> to reset your password</p>
					';	
*/
					 
					 $url =  url('/')."/reset-password/".encrypt($user->id.':'.$user->auth_token);
					
					 Mail::to($request->email)->send(new forgotpassworduser($user,$url));
					 
                      //Mail::to($user['email'])->send(new Forgotpassword($user,$url));
                       
					 /* $user_verify=new UserVerification; 
					  $user_verify->sendmail($user['email'],$message,'Pieorama- Reset Password');  */
					   
					  return response()->json(["status" => true, "message" =>'You will receive a password recovery link at your email address in a few minutes. Please check your spam folder if you did not receive this email.']);
                  }
              }else{
                    return response()->json(["status" => false, "errors_res" =>'This e-mail address does not exist. Please verify that you have typed it correctly and try again.']);
                } 

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


    public function reset_password(Request $email)
    {
         if(isset($email->email)){
           $data = decrypt($email->email);
          // echo $data ; die;
         } else {
            $message = "Link is not valid.";
            return redirect('/home')->with('error', $message);
         }
         $array=explode(':', $data); 
      // echo "<pre/>"; print_r($array); die;   
         if($array[0] == "" || $array[1] == ""){
            $message = "Link is not valid.";
            return redirect('/home')->with('error', $message); 
         }

        $user_check = User::where('id',$array[0])->first();
        if($user_check){
            if($user_check->auth_token != $array[1]){
              $message='Expired URL Please reset your password again.'; 
              return redirect('/home')->with('error', $message); 
             }else {
               $urlcode = $email->email; 
               return redirect('/home')->with('setnewpasswordwebsite', $urlcode);
              // return view('Site.index.resetpassword', compact('message','urlcode'));
           }
        } else {
              $message = "Link is not valid.";
              return redirect('/home')->with('error', $message);
        }
        return view('Site.website.activate-account.mail_status', compact('message',
            'user_check'));
        // return view('Site.index.resetpassword', compact('message', 'user_check'));
    }



    public function setnewpassword(Request $request)
    {
    	
       if($request->isMethod('post')){               
                $validator = Validator::make($request->all(), [
                     
                    'password' => 'required|min:8',  
                    'cpassword' => 'required',
                    'urlcode' => 'required',            
                ],[
                       
                        'password.regex' => 'It cannot consist of only lowercase characters..', 
                       'password.min' => 'The password must be at least 8 characters long.',

                ]);
                 if ($validator->fails()) {
                    return response()->json([
                                'status' => false,
                                'message' => $validator->errors()
                    ]);
                }
               if (ctype_lower($request->password)) { 
               	//dd('test');
				 return response()->json([
                                'status' => false,
                                'message' => [
                                    'passmessage' => 'The password cannot consist of only lowercase characters.'
                                ]  
                                
                    ]);
				}
                $data = decrypt($request->urlcode);
                $array=explode(':', $data); 
               //echo "<pre/>"; print_r($array); die;   
                 if($array[0] == "" || $array[1] == ""){
                    $message = "Link is not valid.";
                    return redirect('/home')->with('error', $message); 
                 }
                $user_check = User::where('id',$array[0])->first();
                if($user_check){
                   // echo "check"; die;
                    if($user_check->auth_token != $array[1]){
                      $message='Your link has been expired';   
                      return redirect('/welcome')->with('error', $message);    
                     }else {
                      $password = Hash::make($request->password);
                      $rand = rand();
                      $update_password = User::where('id',$array[0])->Update(['password'=>$password,'auth_token'=>$rand]);
                      $message = "Password set successfully. Please login now.";
                       return response()->json([
                                'status' => true,
                                'message' => [
                                    'message' => 'Password reset successfully. Please login now..'
                                ]  
                                
                    ]);
                     // return redirect('/welcome')->with('messageresetPassword', $message);
                   
                   }
                } else {
                      $message = "Link is not valid.";
                     return redirect('/welcome')->with('error', $message);
                }
        }
         return back()->with('message', $message);
    }

    

 
     public function contactUs(Request $request)
    {
        if($request->isMethod('post'))  
        {

            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'name' => 'required', 
                //'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
               // 'subject' => 'required', 
               // 'related' => 'required',
                'message' => 'required',               
            ]);
           if ($validator->fails()) {
             return redirect()->back()
              ->withInput($request->all())
              ->withErrors($validator->errors());
            }
              $ContactUs = new ContactUs();
              $ContactUs->first_name =  $request->name;
              $ContactUs->email =  $request->email;
             // $ContactUs->phone_number =  $request->phone;
             // $ContactUs->subject =  $request->subject;
             // $ContactUs->related_to =  $request->related;support@pieorama.com
              $ContactUs->message =  $request->message;
               $ContactUs->save();
                //$unsubscribeurl =  url('')."/unsubscribe-confirmation/".encrypt($ContactUs->email);
                
                Mail::to('info@pieorama.fun')->send(new ContactUsSendToAdmin($ContactUs));
                Mail::to($ContactUs->email)->send(new ContactUsSendToUser($ContactUs));
                return response()->json([
                            'status' => true,
                            'message' => 'Your message has been received. We will get back to you as soon as we can!.'
                ]);
            
	        } 
                //return redirect()->back()->with('message', 'Your message has been received. We will get back to you as soon as we can!.');
             

       
        return view('Site.contact-us.contact-us');
    }


    public function mail_status(Request $email)
      {
         $data = decrypt($email->email);
         $array=explode(':', $data); 
       //  echo "<pre/>"; print_r($array); die;   
         $user_check = User::where('id',$array[0])->first();
        if($user_check){
            if($user_check->is_confirm =='1'){
              $message='You have already confirmed your account.';
               return redirect('/home')->with('error', $message);
            }else {
              $email_verify = User::where('id',$array[0])
              ->Update(['is_confirm'=>1,'status'=>1]);
              $message='Your e-mail address has been verified';
              Mail::to($user_check->email)->send(new WelcomeEmail($user_check,$message));
              return redirect('/home')->with('messageEmailVerification', $message);
           }
        } else {
              $message='Your e-mail address has been verified';
              return redirect('/home')->with('messageEmailVerification', $message);

        }

         return view('Site.website.activate-account.mail_status', compact('message',
            'user_check'));
    }



    public function resend_emailVerification(Request $email)
      {

         $data = decrypt($email->email);
         $array=explode(':', $data); 
       //  echo "<pre/>"; print_r($array); die;   
         $user_check = User::where('id',$array[0])->first();
        if($user_check){
            if($user_check->is_confirm =='1'){
              $message='Your link has been expired';
               return redirect('/home')->with('error', $message);
            }else {
             
              $message='<p>A new e-mail verification link has been sent to <b>'.$user_check->email.'</b></p><br />\n\n<p>You should receive it within the next 5 minutes.  You need to click on the link in this e-mail in order to complete the sign-up process.</p><br />\n\n<p>(Please check your spam folder if you cannot find this e-mail in your inbox).</p>';
              $url =  url('/')."/activate-account/".encrypt($user_check->id.':'.$user_check->auth_token);
              Mail::to($user_check->email)->send(new SignupMail($user_check,$url));
              return redirect('/')->with('resendverificationMail', $message);
           }
        } else {
              $message='Your e-mail address has been verified';
              return redirect('/')->with('messageEmailVerification', $message);

        }

         /*return view('Site.website.activate-account.mail_status', compact('message',
            'user_check'));*/
    }




    public function forgetpassword()
    {         
     // dd($latestcampains->toArray());
        return view('Site.forgot-password',[]);
    }




 //forgot password
    public function forgetpasswordEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'email' => 'required'
            ]);
        if ($validator->fails()) {
             $message = $validator->errors($request[0])->first();
             return redirect('/forgot-password')->with('status', $message);
        }
        $user = User::where('email', $request->email)
                    ->where('user_role',2) 
                    ->orWhere('phone_number', $request->email)
                    ->first();
        if(!empty($user)){
            if($user->status == '0'){
               $message = "Your account is not activated. Please activate your account";
               return redirect('/forgot-password')->with('status', $message);               
            }
            if($user->signup_source != "App"){
                $message = "Invalid Email id";
                return redirect('/forgot-password')->with('status', $message);
            }
            $token = str_shuffle(md5(time()));
            $user->password_reset_token = $token;
            $user->otp = rand(1000,9999);
            $user->save();
            $user = $user->toArray();
            $message = "Pieorama: You have requested OTP is ".$user['otp'];
            $to = $user['phone_code'].$user['phone_number'];
            //$response = Helper::sendSms($to, $message);
            Mail::to($user['email'])->send(new Forgotpassword($user));
            $userData = array('id'=>$user['id'],'otp'=>$user['otp']);
            if($request->session()->exists('donarforgotpassword')){
                $request->session()->forget('donarforgotpassword');
             }
             $request->session()->put('donarforgotpassword', $user);
                $message = "One-Time Password (OTP) has been sent sucessfully on your registered email and mobile.";
                return redirect('/forgot-password')->with('status', $message);

        }else{
              $message = "Email id does not exist";
              return redirect('/forgot-password')->with('status', $message);
        }
        
    }



     public function resendotpforgotpassword(Request $request)
    {
        if ($request->session()->exists('donarforgotpassword')) {
            try {
                $user = $request->session()->get('donarforgotpassword');
                $otp = mt_rand(1000, 9999);
                User::where('id',$user['id'])->update(['otp'=>$otp]);
                $message = "Your OTP is ".$otp;
                $to = $user['phone_code'].$user['phone_number'];
                $response = Helper::sendSms($to, $message);
                if($request->session()->exists('donarforgotpassword')){
                    $request->session()->forget('donarforgotpassword');
                 }
                 $user1 = User::where('id', $user['id'])->first();
                 $request->session()->put('donarforgotpassword', $user1);
                 Mail::to($user1['email'])->send(new Forgotpassword($user1));
                 $userData = array('id'=>$user['id'],'otp'=>$otp);
                 return response()->json(["status" => 1, "message" =>'One-Time Password (OTP) has been resend sucessfully on your registered email id and phone number.']);
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }
        } 
    }

    

    public function mobileVerification(Request $request)
    {
        if ($request->session()->exists('donarsignup')) {
            try {
                
                $signupSession = $request->session()->get('donarsignup');
                $validator=Validator::make($request->all(),[
                    'otp1'=>'required',
                    
                ]);       
                if ($validator->fails()) {  
                     
                    return ['status'=>0,'message'=>'Please enter OTP here.'];
                }
                $finalotp = $request->otp1.$request->otp2.$request->otp3.$request->otp4;
               
                $user = User::where(function ($query) use ($finalotp) {
                    $query->where('otp', '=', $finalotp)
                          ->orWhere('master_otp', '=', $finalotp);
                })->where('id',$signupSession->id)->first();
                if(!empty($user))
                {
                    $user->mobile_verified='1';
                    $user->otp='';
                    $user->auth_token=mt_rand();
                    if($user->save()){
                        $url =  url('/activate-account')."/".encrypt($user->id.':'.$user->auth_token);
                        Mail::to($user->email)->send(new SignupMail($user,$url));
                        return ['success'=> 1, 'message' =>'your phone number has been successfully verified and email verification link has been sent to you registered email.','user'=>$user];
                    }
                }else{
                    return ['status'=>0,'message'=>'Please enter valid OTP.'];
                    
                }
                
            } catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }
        }else{
            return redirect('/home');
        }
    }


    public function resendOtp(Request $request)
    {
        if ($request->session()->exists('donarsignup')) {
            try {
                $user = $request->session()->get('donarsignup');
                $otp = mt_rand(1000, 9999);
                User::where('id',$user->id)->update(['otp'=>$otp]);
                $message = "Your OTP is ".$otp;
                $to = $user->phone_code.''.$user->phone_number;
                $response = Helper::sendSms($to, $message);
                $userData = ['id'=>$user->id,'otp'=>$otp];
                $message = "One-Time Password (OTP) has been resend to your registered Mobile Number - ".$to; 
                 return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }
        }

    }

  
    
    public function logout(Request $request) {
        Auth::logout();
        return redirect('/home');
      }
   

    public function activateAccount(Request $request, $token)
    {
        try {
            $token = decrypt($token);
            $user_id_token = explode(':', $token);
            $user = User::where('id',$user_id_token[0])
                        ->where('auth_token',$user_id_token[1])
                        ->first();
            if(!empty($user))
            {
                $user->status='1';
                $user->auth_token='';
                if($user->save()){
                   // return ['success'=> 1, 'message' => 'Your account activated successfully.'];
                    $message = "Account has been activated successfully.";
                    return view("Site.activate-account",compact('message'));
                }
                //return ['success'=> 0, 'message' => 'Not a valid link.'];
                $message = "Not a valid link";
                return view("Site.activate-account",compact('message'));
            }
            //return ['success'=> 0, 'message' => 'Not a valid link.'];
                $message = "Not a valid link";
                return view("Site.activate-account",compact('message'));
        } catch (\Exception $e) { 
            //return ['success'=> 0, 'message' => [$e->getMessage()]];
            $message = $e->getMessage();
                return view("Site.activate-account",compact('message'));

        }
    }

/**
 * Create a new controller instance.
 *
 * @return void
 */
public function redirectToFacebook()
{
    return Socialite::driver('facebook')->redirect();
}
/**
 * Create a new controller instance.
 *
 * @return void
 */
public function handleFacebookCallback()
{
  try {
            $user = Socialite::driver('facebook')->user();
            $name = $user->getName();
            $email = $user->email;
            $profile_image = $user->avatar_original;
            $facebook_id = $user->getId();
        // social id exist check
    if($facebook_id){
        $existingUser = User::where('facebook_id', $facebook_id)->first();
        if($existingUser){
            if($existingUser->status == 1){
                  Auth::logout();
                  Auth::login($existingUser, true);
                  $user_role = $existingUser->user_role;
                  $sessionName = 'user_role';        //assume a session name
                  Session::put($sessionName, $existingUser);                 
                  $message = "Login successfully.";
                  return redirect('/home')->with('message', $message);
             } else {
                 $message = "Your account has been deactivated by the admin. Please contact to support@pieorama.fun";
                 return redirect('/home')->with('error', $message);
             }
        } else { 
                 $existingUser = User::select('*')->where('email',$email)->first(); 
                  if($existingUser && (isset($email) && !empty($email)) ){  
                        $existingUser = User::where('email', $email)->first();
                        // Update Facebook Id
                         User::where('email',$email)->update(['facebook_id'=>$facebook_id]);

                        // It will login code here
                          if (!empty($existingUser)) {  
                              if($existingUser->status == 1){ 
                                Auth::logout(); 
                                Auth::login($existingUser, true);
                                $user_role = $existingUser->user_role;
                                $sessionName = 'user_role';        //assume a session name
                                Session::put($sessionName, $existingUser);
                                $message = "Login successfully.";
                                return redirect('/home')->with('message', $message);
                              } else {
                                 $message = "Your account has been deactivated by the admin. Please contact to support@pieorama.fun";
                                 return redirect('/home')->with('error', $message);
                              }                               
                            } else {
                               $message = "Somthing went wrong please try again later or contact to developer.";
                                return redirect('/home')->with('error', $message);
                            }   

                       } else {
                              $data['password'] = bcrypt(mt_rand());
                              $data['status'] = 1;
                              $data['signupstep'] = 1;
                              $data['auth_token'] = mt_rand();
                              $data['last_time_used'] = now();
                              $data['is_confirm'] = 1;
                              $data['device_type'] = 3;
                              $data['user_role'] = 2;
                              $data['facebook_id'] = $facebook_id;
                              $data['profile_image'] = $profile_image;
                              $data['email'] = $email;
                              if($name){
                                 $array=explode(' ', $name);  
                                  if($array[0] != "" || $array[1] != ""){
                                   $data['first_name'] = $array[0];
                                   $data['last_name'] = $array[1];
                                 }
                              }
                              $user = User::create($data);
                              Auth::logout();
                              Auth::login($user, true); 
                              $user_role = $user->user_role;
                              $sessionName = 'user_role';        
                              Session::put($sessionName, $user);
                              $message = "Login successfully.";
                              return redirect('/home')->with('message', $message);
                             // return redirect()->to('/home');  
                      }
                }


        } // social id check end
    } catch (Exception $e) {
        return redirect()->route('home');
    }
  }



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    public function handleGoogleCallback()
    {

      try {
            $user = Socialite::driver('google')->user();
            $name = $user->getName();
            $email = $user->email;
            $profile_image = $user->avatar_original;
            $google_id = $user->getId();
        // social id exist check
      if($google_id){
          $existingUser = User::where('google_id', $google_id)->first();
          if($existingUser){
              if($existingUser->status == 1){
                    Auth::logout();
                    Auth::login($existingUser, true);
                    $user_role = $existingUser->user_role;
                    $sessionName = 'user_role';        //assume a session name
                    Session::put($sessionName, $existingUser);                 
                    $message = "Login successfully.";
                    return redirect('/home')->with('message', $message);
               } else {
                   $message = "Your account has been deactivated by the admin. Please contact to support@pieorama.fun";
                   return redirect('/home')->with('error', $message);
               }
          } else { 
                   $existingUser = User::select('*')->where('email',$email)->first(); 
                    if($existingUser && (isset($email) && !empty($email)) ){  
                          $existingUser = User::where('email', $email)->first();
                          // Update google Id
                           User::where('email',$email)->update(['google_id'=>$google_id]);

                          // It will login code here
                            if (!empty($existingUser)) {  
                                if($existingUser->status == 1){ 
                                  Auth::logout(); 
                                  Auth::login($existingUser, true);
                                  $user_role = $existingUser->user_role;
                                  $sessionName = 'user_role';        //assume a session name
                                  Session::put($sessionName, $existingUser);
                                  $message = "Login successfully.";
                                  return redirect('/home')->with('message', $message);
                                } else {
                                   $message = "Your account has been deactivated by the admin. Please contact to support@pieorama.fun";
                                   return redirect('/home')->with('error', $message);
                                }                               
                              } else {
                                 $message = "Somthing went wrong please try again later or contact to developer.";
                                  return redirect('/home')->with('error', $message);
                              }   

                         } else {
                                $data['password'] = bcrypt(mt_rand());
                                $data['status'] = 1;
                                $data['signupstep'] = 1;
                                $data['auth_token'] = mt_rand();
                                $data['last_time_used'] = now();
                                $data['is_confirm'] = 1;
                                $data['device_type'] = 3;
                                $data['user_role'] = 2;
                                $data['google_id'] = $google_id;
                                $data['profile_image'] = $profile_image;
                                $data['email'] = $email;
                                if($name){
                                   $array=explode(' ', $name);  
                                    if($array[0] != "" || $array[1] != ""){
                                     $data['first_name'] = $array[0];
                                     $data['last_name'] = $array[1];
                                   }
                                }
                                $user = User::create($data);
                                Auth::logout();
                                Auth::login($user, true); 
                                $user_role = $user->user_role;
                                $sessionName = 'user_role';        
                                Session::put($sessionName, $user);
                                $message = "Login successfully.";
                                return redirect('/home')->with('message', $message);
                               // return redirect()->to('/home');  
                        }
                  }


          } // social id check end
    } catch (Exception $e) {
        return redirect()->route('home');
    }
  }


   /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirectToLinkedin()
    {
        return Socialite::driver('linkedin')->redirect();
    }
    


    public function handleLinkedinCallback()
    {
      try {
            $user = Socialite::driver('linkedin')->user();
            $name = $user->getName();
            $email = $user->email;
            $profile_image = $user->avatar_original;
            $linkedin_id = $user->getId();
        // social id exist check
      if($linkedin_id){
          $existingUser = User::where('linkedin_id', $linkedin_id)->first();
          if($existingUser){
              if($existingUser->status == 1){
                    Auth::logout();
                    Auth::login($existingUser, true);
                    $user_role = $existingUser->user_role;
                    $sessionName = 'user_role';        //assume a session name
                    Session::put($sessionName, $existingUser);                 
                    $message = "Login successfully.";
                    return redirect('/home')->with('message', $message);
               } else {
                   $message = "Your account has been deactivated by the admin. Please contact to support@pieorama.fun";
                   return redirect('/home')->with('error', $message);
               }
          } else { 
                   $existingUser = User::select('*')->where('email',$email)->first(); 
                    if($existingUser && (isset($email) && !empty($email)) ){  
                          $existingUser = User::where('email', $email)->first();
                          // Update linkedIn Id
                           User::where('email',$email)->update(['linkedin_id'=>$linkedin_id]);

                          // It will login code here
                            if (!empty($existingUser)) {  
                                if($existingUser->status == 1){ 
                                  Auth::logout(); 
                                  Auth::login($existingUser, true);
                                  $user_role = $existingUser->user_role;
                                  $sessionName = 'user_role';        //assume a session name
                                  Session::put($sessionName, $existingUser);
                                  $message = "Login successfully.";
                                  return redirect('/home')->with('message', $message);
                                } else {
                                   $message = "Your account has been deactivated by the admin. Please contact to support@pieorama.fun";
                                   return redirect('/home')->with('error', $message);
                                }                               
                              } else {
                                 $message = "Somthing went wrong please try again later or contact to developer.";
                                  return redirect('/home')->with('error', $message);
                              }   

                         } else {
                                $data['password'] = bcrypt(mt_rand());
                                $data['status'] = 1;
                                $data['signupstep'] = 1;
                                $data['auth_token'] = mt_rand();
                                $data['last_time_used'] = now();
                                $data['is_confirm'] = 1;
                                $data['device_type'] = 3;
                                $data['user_role'] = 2;
                                $data['linkedin_id'] = $linkedin_id;
                                $data['profile_image'] = $profile_image;
                                $data['email'] = $email;
                                if($name){
                                   $array=explode(' ', $name);  
                                    if($array[0] != "" || $array[1] != ""){
                                     $data['first_name'] = $array[0];
                                     $data['last_name'] = $array[1];
                                   }
                                }
                                $user = User::create($data);
                                Auth::logout();
                                Auth::login($user, true); 
                                $user_role = $user->user_role;
                                $sessionName = 'user_role';        
                                Session::put($sessionName, $user);
                                $message = "Login successfully.";
                                return redirect('/home')->with('message', $message);
                               // return redirect()->to('/home');  
                        }
                  }


          } // social id check end
    } catch (Exception $e) {
        return redirect()->route('home');
    }

 }




 /**
 * Create a new controller instance.
 *
 * @return void
 */
public function redirectToTwitter()
{
    return Socialite::driver('twitter')->redirect();
}
/**
 * Create a new controller instance.
 *
 * @return void
 */
public function handleTwitterCallback()
{
  try {
            $user = Socialite::driver('twitter')->user();
           // echo "<pre/>"; print_r($user); die;
            $name = $user->getName();
            $email = $user->email;
            $profile_image = $user->avatar_original;
            $twitter_id = $user->getId();
        // social id exist check
    if($twitter_id){
        $existingUser = User::where('twitter_id', $twitter_id)->first();
        if($existingUser){
            if($existingUser->status == 1){
                  Auth::logout();
                  Auth::login($existingUser, true);
                  $user_role = $existingUser->user_role;
                  $sessionName = 'user_role';   //assume a session name
                  Session::put($sessionName, $existingUser);                 
                  $message = "Login successfully.";
                  return redirect('/home')->with('message', $message);
             } else {
                 $message = "Your account has been deactivated by the admin. Please contact to support@pieorama.fun";
                 return redirect('/home')->with('error', $message);
             }
        } else { 
                 $existingUser = User::select('*')->where('email',$email)->first(); 
                  if($existingUser && (isset($email) && !empty($email)) ){  
                        $existingUser = User::where('email', $email)->first();
                        // Update twitter Id
                         User::where('email',$email)->update(['twitter_id'=>$twitter_id]);
                        // It will login code here
                          if (!empty($existingUser)) {  
                              if($existingUser->status == 1){ 
                                Auth::logout(); 
                                Auth::login($existingUser, true);
                                $user_role = $existingUser->user_role;
                                $sessionName = 'user_role';        //assume a session name
                                Session::put($sessionName, $existingUser);
                                $message = "Login successfully.";
                                return redirect('/home')->with('message', $message);
                              } else {
                                 $message = "Your account has been deactivated by the admin. Please contact to support@pieorama.fun";
                                 return redirect('/home')->with('error', $message);
                              }                               
                            } else {
                               $message = "Somthing went wrong please try again later or contact to developer.";
                                return redirect('/home')->with('error', $message);
                            }   

                       } else {
                              $data['password'] = bcrypt(mt_rand());
                              $data['status'] = 1;
                              $data['signupstep'] = 1;
                              $data['auth_token'] = mt_rand();
                              $data['last_time_used'] = now();
                              $data['is_confirm'] = 1;
                              $data['device_type'] = 3;
                              $data['user_role'] = 2;
                              $data['twitter_id'] = $twitter_id;
                              $data['profile_image'] = $profile_image;
                              $data['email'] = $email;
                              if($name){
                                 $array=explode(' ', $name);  
                                  if($array[0] != "" || $array[1] != ""){
                                   $data['first_name'] = $array[0];
                                   $data['last_name'] = $array[1];
                                 }
                              }
                              $user = User::create($data);
                              Auth::logout();
                              Auth::login($user, true); 
                              $user_role = $user->user_role;
                              $sessionName = 'user_role';        
                              Session::put($sessionName, $user);
                              $message = "Login successfully.";
                              return redirect('/home')->with('message', $message);
                             // return redirect()->to('/home');  
                      }
                }


        } // social id check end
    } catch (Exception $e) {
        return redirect()->route('home');
    }
  }






/**
 * Create a new controller instance.
 *
 * @return void
 */
public function redirectToInstagram()
{
    return Socialite::driver('instagram')->redirect();
}
/**
 * Create a new controller instance.
 *
 * @return void
 */
public function handleInstagramCallback()
{
  try {
            $user = Socialite::driver('instagram')->user();
            $name = $user->name;
            $email = $user->email;
            $profile_image = $user->avatar;
            $instagram_id = $user->id;

        // social id exist check
    if($instagram_id){
        $existingUser = User::where('instagram_id', $instagram_id)->first();
        if($existingUser){
            if($existingUser->status == 1){
                  Auth::logout();
                  Auth::login($existingUser, true);
                  $user_role = $existingUser->user_role;
                  $sessionName = 'user_role';        //assume a session name
                  Session::put($sessionName, $existingUser);                 
                  $message = "Login successfully.";
                  return redirect('/home')->with('message', $message);
             } else {
                 $message = "Your account has been deactivated by the admin. Please contact to support@pieorama.fun";
                 return redirect('/home')->with('error', $message);
             }
        } else { 
                 $existingUser = User::select('*')->where('email',$email)->first(); 
                  if($existingUser && (isset($email) && !empty($email)) ){  
                        $existingUser = User::where('email', $email)->first();
                        // Update instagram Id
                         User::where('email',$email)->update(['instagram_id'=>$instagram_id]);

                        // It will login code here
                          if (!empty($existingUser)) {  
                              if($existingUser->status == 1){ 
                                Auth::logout(); 
                                Auth::login($existingUser, true);
                                $user_role = $existingUser->user_role;
                                $sessionName = 'user_role';        //assume a session name
                                Session::put($sessionName, $existingUser);
                                $message = "Login successfully.";
                                return redirect('/home')->with('message', $message);
                              } else {
                                 $message = "Your account has been deactivated by the admin. Please contact to support@pieorama.fun";
                                 return redirect('/home')->with('error', $message);
                              }                               
                            } else {
                               $message = "Somthing went wrong please try again later or contact to developer.";
                                return redirect('/home')->with('error', $message);
                            }   

                       } else {
                              $data['instagram_id'] = $instagram_id;
                              $data['password'] = bcrypt(mt_rand());
                              $data['status'] = 1;
                              $data['signupstep'] = 1;
                              $data['auth_token'] = mt_rand();
                              $data['last_time_used'] = now();
                              $data['is_confirm'] = 1;
                              $data['device_type'] = 3;
                              $data['user_role'] = 2;
                              $data['profile_image'] = $profile_image;
                              $data['email'] = $email;
                              if($name){
                                 $array=explode(' ', $name);  
                                  if($array[0] != "" || $array[1] != ""){
                                   $data['first_name'] = $array[0];
                                   $data['last_name'] = $array[1];
                                 }
                              }
                              $user = User::create($data);
                              Auth::logout();
                              Auth::login($user, true); 
                              $user_role = $user->user_role;
                              $sessionName = 'user_role';        
                              Session::put($sessionName, $user);
                              $message = "Login successfully.";
                              return redirect('/home')->with('message', $message);
                            
                      }
                }


        } // social id check end
    } catch (Exception $e) {
        return redirect()->route('home');
    }
  }




   
    //verify otp for forgot password
    public function verfiyResetToken(Request $request)
    {
        if($request->session()->exists('donarforgotpassword')){
            $user = $request->session()->get('donarforgotpassword');
            
            $request->id = $user['id'];
            $validator=Validator::make($request->all(),[
                'reset1'=>'required',
                'reset2' =>'required',
                'reset3'=>'required',
                'reset4'=>'required',
            ]); 
            if ($validator->fails()) {
                return ['status'=>0,'message'=>'Please enter OTP here.'];
            }  
            $otp = $request->reset1.$request->reset2.$request->reset3.$request->reset4;
            $request->otp = $otp;
            $user = User::where(function ($query) use ($otp) {
                $query->where('otp', '=', $otp)
                    ->orWhere('master_otp', '=', $otp);
            })->where('id',$request->id)->first();
            if (!$user) {
                return response()->json(["status" => 0, "message" => 'Please enter valid OTP']);
            }
            $userData = array('id'=>$user->id,'otp'=>$user->otp);
            return response()->json(["status" => 1, 'message'=>'Success','user' => $userData]);
         }
    }


    //reset password 
    public function reset(Request $request)
    {
        if($request->isMethod('post'))  
        {
            $user = $request->session()->get('donarforgotpassword');
            $request->id = $user['id'];
            $validator = Validator::make($request->all(), [
                'password'  => 'bail|required|min:8|confirmed',
            ]);
            if ($validator->fails()) { 
                return response()->json(["status" => 0, "message" => $validator->errors($request[0])->first()]);
            }
            $user = User::where('id', $request->id)->first();
            if (!$user) {
                return response()->json(["status" => 0, "message" => 'User id does not exist.']);
            }
            $user->password_reset_token = '';
            $user->otp = '';
            $user->password = Hash::make($request->password);
            $user->save();
            $blankdata =[];
            return response()->json(["status" => 1, "message" =>'Password has been reset successfully.','user' =>$blankdata]);
        }
    }


    
function videoplayontimer(Request $request){
	
	$request->session()->push('video_id', $request->video_idd);
	$value = $request->session()->get('video_id');
	//echo '<pre>'; print_r($value);
	$getvideodata = PieVideo::leftjoin('sc_pie_tags','sc_pie_tags.video_id','=','sc_pie_video.id')->where('sc_pie_video.id',$request->video_idd)
					->where('sc_pie_video.is_deleted',0)
					->where('sc_pie_video.status',1)
					->select('sc_pie_video.id','sc_pie_tags.tag_text')
					->get();
		//dd($getvideodata);
		$next = 1;			
	 	foreach ($getvideodata as $key => $v) {
	 		$tag = $v->tag_text;
	 		
		     	$getanotherVideo1 = PieVideo::leftjoin('sc_pie_tags','sc_pie_tags.video_id','=','sc_pie_video.id')
							//->where('sc_pie_video.id','!=',$v->id)
							->whereNotIn('sc_pie_video.id',$value)
							->where( 'sc_pie_tags.tag_text', 'LIKE', '%'. $tag .'%')
							->where('sc_pie_video.is_deleted',0)
							->where('sc_pie_tags.is_deleted',0)
						    ->where('sc_pie_video.status',1)
						    ->select('sc_pie_video.*','sc_pie_tags.tag_text')
						    //->orderBy('sc_pie_video.id','desc')
						   // ->groupBy('sc_pie_tags.video_id')
						    ->first();
						
						  //echo '<pre>'; print_r($getanotherVideo1);
					if(isset($getanotherVideo1) && !in_array($getanotherVideo1->id, $value)){
						 		$next = 1;
									$video_idddd=base64_encode($getanotherVideo1->id);
										$video_idddd1=urlencode(base64_encode($video_idddd));
										$getanotherVideo1->video_idddd=str_replace('%3D%3D', '', $video_idddd1);
		 	 						return ['videoDetails' => $getanotherVideo1];
		 	 						break;
					}else{
						$next = 0;
						continue;
					}
			
	    }
	    if($next == 0){
	    $random = PieVideo::whereNotIn('id',$value)
							->where('is_deleted',0)
						    ->where('status',1)
						    ->first();
	    $video_idddd=base64_encode($random->id);
					$video_idddd1=urlencode(base64_encode($video_idddd));
					$random->video_idddd=str_replace('%3D%3D', '', $video_idddd1);
						return ['videoDetails' => $random];
						
	 }
	}


	function gifcorner(){
		return view("Site.gif-corner.gif-corner");
	}

	function gifdata(Request $request){

		if(!empty(auth()->user()->id)){
			
		 $Allgif = PieVideo::where('status',1)
    			->where('is_deleted',0)
    			->whereNotNull('small_gif')
    			->orderBy('profiled_pieogram','DESC')
    			->orderBy('id','DESC')
    			->skip($request->start)
    			->take($request->end - $request->start)
    			
    			->get();
		}else{
			
			 $Allgif = PieVideo::where('status',1)
    			->where('is_deleted',0)
    			->whereNotNull('small_gif')
    			->where('gif_corner',1)
    			->orderBy('id','DESC')
    			->skip($request->start)
    			->take($request->end - $request->start)
    			->get();

		}
		
    	foreach($Allgif as $key=>$row)
		{
			$title = $row['video_title'];
		  //  $dd = strlen( $title);
		    //echo '<pre>'; print_r($dd);
		    if( strlen( $title) > 44) {
			    $title= explode( "\n", wordwrap( $title, 44));
			    $title= $title[0] . '...';
			}else{
				$title = $row['video_title'];
			}
			$row['title'] = $title;
			$video_idddd=base64_encode($row['id']);

			$row['video_idddd']=urlencode(base64_encode($video_idddd));
			$row['video_idddd']=str_replace('%3D%3D', '', $row['video_idddd']);
		}		

		 return ['Allgif' => $Allgif];
	}

	


	 public function getDownload($id){
   
		$getgif = PieVideo::where('id',$id)
    			 ->where('is_deleted',0)
    			 ->where('status',1)
    			 ->first();
    	$document = $getgif->small_gif;
    	$gif_id = $getgif->id;

    	 header('Content-type: application/pdf');

			// It will be called downloaded.pdf
			header('Content-Disposition: attachment; filename="pieOrama-'.$gif_id.'.gif"');

			// The PDF source is in original.pdf
			readfile($document);
    	

    }

    public function unsubscribeconfirmation(Request $request,$email=null,$name=null){
    	
    	$page = Pages::where('id',9)->where('status',1)->get();
    	if($email){
    		$email = $email;
    	}else{
    		$email = '';
    	}
    	if($name){
    		$name = $name;
    	}else{
    		$name = '';
    	}

    	if($request->isMethod('post'))  
        {
        	
        	if($request->email){
        		$data = decrypt($request->email);
        	}elseif($request->emailnotexist){
        		$data = $request->emailnotexist;
        	}else{
        		$data = '';
        	}
			
			if($name != ''){
				$name = decrypt($request->name);
			}
			
			 
			         $array=explode(':', $data);
			        if($name != ''){
			         $array_name=explode(':', $name);
			       	}

			       //  echo "<pre/>"; print_r($array); die;   
			         $user_check = Unsubscribe_users::where('email',$array[0])->first();
			         
				         if(isset($user_check)){
				         	if($user_check->newsletter == 1){
					    		$update = Unsubscribe_users::where('email',$array[0])->update(['newsletter' => 0]);
					    		 return response()->json([
				                            'status' => true,
				                            'message' => 'You have been unsubscribed from Pieorama successfully!.'
				                ]);
				    		 }else{
				    		 	return response()->json([
				                            'status' => false,
				                            'message' => 'You have already been unsubscribed from Pieorama successfully!.'
				                ]);
				    			
				    		 }

				    	}else{
				    		$Unsubscribe_users = new Unsubscribe_users();
				    		$Unsubscribe_users->name = $array_name[0]??null;
				    		$Unsubscribe_users->email = $array[0]??null;
				    		$Unsubscribe_users->status = 1;
				    		$Unsubscribe_users->newsletter = 0;
				    		$Unsubscribe_users->is_delete = 0;
				    		$Unsubscribe_users->save();
				    		if($Unsubscribe_users){
				    			return response()->json([
				                            'status' => true,
				                            'message' => 'You have been unsubscribed from Pieorama successfully!.'
				                ]);
				    		}else{
				    			return response()->json([
				                            'status' => false,
				                            'message' => 'You have already been unsubscribed from Pieorama successfully!.'
				                ]);
				    			
				    		}
				    		

				    	}
				    
            
	        } 
                
    	return view('Site.unsubscribeconfirmation.unsubscribeconfirmation',compact('page','email','name')); 
    }

    


}
