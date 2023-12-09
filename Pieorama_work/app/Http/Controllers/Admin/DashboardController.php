<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Auth;
use Validator;
use App\Helpers\Helper;
use App\Models\User;
use App\Models\ContactUs;
use App\Models\Welcome;
use App\Models\Unsubscribe_users;
use App\Models\TermsofuseTemplate;
use App\Models\PieChannel;
use App\Models\Bulkmail;
use App\Mail\SubscribeMail;
use App\Mail\UnsubscribeMail;
use App\Mail\BroadcastMail;
use App\Models\PieVideo;
use App\Models\Pages;
use App\Models\PieTags;
use App\Models\Tvscreening;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailTemplate as EmailTemplate;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // if (!Auth::guard('admin')->check()) {
        //     return redirect()->route("admin.login");
        // }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() { 
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
      


        return view('Admin.dashboard.dashboard');
    }

    public function dashboard(){   
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $total_user= User::where('is_deleted',0)->where('user_role',2)->count(); 
        $total_channel= PieChannel::where('is_deleted',0)->count(); 
        $total_video= PieVideo::where('is_deleted',0)->count(); 
        $total_tag= PieTags::where('is_deleted',0)->count(); 
        $query_total = ContactUs::where('status',0)->count(); 
        return view('Admin.dashboard.dashboard',compact('total_user','total_channel','total_video','total_tag','query_total'));
    }
	
	
	public function pages(){   
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
		
		$pages = Pages::all(); 
		 foreach ($pages as $key => $value) {
            $value->date = date('d-M-Y',strtotime($value->updated_at));
         }
        return view('Admin.dashboard.pages',compact('pages'));  
    }

     public function pageslist(Request $request){  
         try {   
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $order=isset($request->jtSorting)?$request->jtSorting:'id DESC';
                $orderBy = explode(" ", $order);           
              //  $userQuery = Pages(); 

                 $userQuery = Pages::query(); 
                   /*if(isset($request->status) && $request->status!=''){
                                   $userQuery->where(function ($query) use($request){
                                    $query->where('status',$request->status);
                                        //  ->where('is_deleted',0);
                                });                              
                    } else {
                           $userQuery->where(function ($query){
                           $query->where('status',1);
                       });
                    }*/ 
                   if(isset($request->keyword) && $request->keyword!=''){
                     $userQuery->where(function ($query) use($request){
                          $query->orWhere( 'name', 'LIKE', '%'. $request->keyword .'%');
                    });  
                   }

                $usersCountArray = $userQuery->get();
                $users = $userQuery->offset($offset)->limit($limit)->orderBy($orderBy[0], $orderBy[1])->get()->toArray();
              //  print_r( $users); die;
                $UserCount = $usersCountArray->count(); 
                $sno=$offset;
                $user_data=array();
                foreach($users as $user){
                    $sno++;
                    $user['sno']=$sno; 
                   // $user['view_count'] = count($user['usedlibrary']); 
                    $user['updated_at'] = date('Y-m-d', strtotime($user['updated_at'])); 
                   // $user['file_size'] = Helper::formatSizeUnits($user['file_size']); 
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


    public function createPage(Request $request){
        if(!Auth::guard('admin')->check()){
            redirect()->route("admin.login");
        }
        if($request->isMethod('post')){
            $id = Auth::guard()->user()->id??0;
            $validator = Validator::make($request->all(), [
                         'name' => 'required',
                          'description' => 'required',
                          ]);
            if($validator->fails()){
                return back()->withInput()->withErrors($validator->errors());
            }
            $page = new Pages();
            $page->name = $request->name;
            $page->description = $request->description;
            if($page->save()){
                return redirect('admin/pages')->with(['status' => 1, 'message' => 'Page added successfully!']);
            }

        }

        return view('Admin.dashboard.createPage');
    }
	
	public function pagesEdit(Request $request){   
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
		
		if($request->isMethod('post') ) {
			$id=$request->id;
			$post=$request->all();
			
			$title=$post['page_title'];
			$description=$post['description'];
			
			$today=date('Y-m-d H:i:s');
			
			$array=array(
				'name'=>$title,	
				'description'=>$description,	
				'created_at'=>$today,	
				'updated_at'=>$today  	
			
			);
			
			DB::table('pages')
            ->where('id',$id)
            ->update($array); 
			$pages = DB::table('pages')->where('id', $id)->get();   
			//return view('Admin.dashboard.pagesEdit',compact('pages')); 
			return back()->with('message', 'Page has been updated successfully!');
		} 	   
		
		
		$id=$request->id;
		
		$pages = DB::table('pages')->where('id', $id)->get(); 
		  
        return view('Admin.dashboard.pagesEdit',compact('pages')); 
    } 
	
	
	

    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->flush();
        return redirect()->route('admin.login');
    }

    public function changepassword(Request $request)
    {

        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }        
        $session = Auth::guard('admin')->User();
        $id = $session->id;
       if( $request->isMethod('post') ) {
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'password' => 'required|min:5|max:20|confirmed',                
                'password_confirmation' => 'required',                
            ]);
            if($validator->fails()) {
              return back()->withErrors($validator->errors($request[0])->first());
            }
            $userxist=User::where('id',$id)->first();
            if(Hash::check($request->current_password,$userxist->password)) {  
                $password = Hash::make($request->password);
                User::where('id',$userxist->id)->update(['password'=>$password]);
                return back()->with('message', 'Password has been changed successfully!');
            }else{
                return back()->withErrors('Current password does not match.');
            }
        }
        return view('Admin.dashboard.changepassword');
    }


    public function userprofile(Request $request)
    {   
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $session = Auth::guard('admin')->User();
        $id = $session->id;
        if( $request->isMethod('post') ) {
           
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                //'last_name' => 'required',                
                'email' => 'required',            

            ]);
            if($validator->fails()) {
            return back()->withErrors($validator->errors($request[0])->first());
            }
            if(empty($request->exits_image)){
                $validator = Validator::make($request->all(), [
                    'profile_image'=>'required',
                    'profile_image.*'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'           
    
                ]);
                if($validator->fails()) {
                return back()->withErrors($validator->errors($request[0])->first());
                }
            }
            if($request->hasfile('profile_image')){

                $extension =  $request->file('profile_image')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('profile_image'), time().rand().'.'.$extension, 'public');
                $imageUrl = config('constants.DO_STORAGE_URL').$path;

                /*$image = $request->file('profile_image');
                $name = $request->file('profile_image')->getClientOriginalName();
                $image_name = $request->file('profile_image')->getRealPath();
                $path = public_path().'/uploads/';
                $image->move($path, $name);
                $image_url = $name;*/
            }else{
                $imageUrl = $request->exits_image;
            }
            $updateData = ['first_name'=>$request->first_name,'last_name'=>$request->last_name,'email'=>$request->email,'profile_image'=>$imageUrl];
            User::where('id',$id)->update($updateData);
            return back()->with('message', 'Your profile has been updated successfully!');
            
        }
        $profile = User::where('id',$id)->first();
        return view('Admin.dashboard.profile',compact('profile'));
    }

 public function welcome_message(Request $request){
   
     if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
         $session = Auth::guard('admin')->User();
         $id = $session->id;

        if($request->isMethod('post') ) {
           
            $post=$request->all();
           
            $welcome_message=$post['welcome_message'];
            $background_color=$post['background_color'];
            $foreground_color=$post['foreground_color'];

            if(isset($request->status)) {
              $status=1;
             
            } else {

                $status=0;
            } 

            $today=date('Y-m-d H:i:s');
            
            $array=array(
                'welcome_message'=>$welcome_message, 
                'background_color' => $background_color,
                'foreground_color' => $foreground_color, 
                'status' => $status, 
                'created_at'=>$today,   
                'updated_at'=>$today    
            
            );
            
            Welcome::where('user_id',$id)->update(['welcome_message' => $welcome_message,'background_color' => $background_color, 'foreground_color' => $foreground_color,'status' => $status]); 
            
            return back()->with('message', 'Welcome Message has been updated successfully!');
        }      
        
        
       
        $msg = Welcome::where('user_id', $id)->first(); 
       
         return view('Admin.dashboard.welcome_message',compact('msg')); 

 }

 public function activatePageStatus(Request $request){ 

        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
                //dd($request->all());
               $userexist = Pages::where('id',$request->userid)->first();   
                if($request->statuskey == 4){
                   // dd($request->accountactiveStatus);
                    if($request->accountactiveStatus == 1){
                        $status = 1;
                        $message ='Page has been Deactivated successfully.';
                    }else{
                        $status = 0;
                       // dd($updateData);
                        $message ='Page has been activated successfully.';
                    }
                }
               
                $dd = Pages::where('id',$userexist->id)->update(['status' => $status]);
               // dd($userexist->id);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
    }

    function tvscreeenvideo(Request $request){

        if (!Auth::guard('admin')->check()) {
                return redirect()->route("admin.login");
            }
             
            $session = Auth::guard('admin')->User();
            $id = $session->id;

            $profile = Tvscreening::where('id',$id)->first();
            if(!$profile){
                return back()->with('message', 'Sorry! I think you are in worng path.');
            }

            if($request->isMethod('post')) {
               
                $post=$request->all();
               
                $title=$post['title']??'';
               
                if($request->hasfile('library_file')){
                   
                    $extension =  $request->file('library_file')->extension();
                    $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('library_file'), time().rand().'.'.$extension, 'public');
                    $file_name = config('constants.DO_STORAGE_URL').$path;
                    
              
                }else{
                    $file_name = $profile->file_name;
                   
                }

                 if($request->hasfile('thumbnail')){
                   
                    $extension =  $request->file('thumbnail')->extension();
                    $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('thumbnail'), time().rand().'.'.$extension, 'public');
                    $thumbnail = config('constants.DO_STORAGE_URL').$path;
                    
              
                }else{
                    $thumbnail = $profile->thumbnail;
                   
                }
               
               
                $today=date('Y-m-d H:i:s');
                
               /* $array=array(
                    'user_id' => $id,
                    'title' => $title,
                    'file_name' => $file_name,
                    'updated_by' => $id,
                    'status' => 0, 
                    'is_delete' => 0, 
                    'created_at'=>$today,   
                    'updated_at'=>$today    
                
                );*/
                
                Tvscreening::where('user_id',$id)->update(['user_id' => $id, 'file_name' => $file_name,'updated_by' => $id,'status' => 0, 'is_delete' => 0,'created_at' =>$today, 'updated_at' => now()]); 
                
                return back()->with('message', 'Video has been updated successfully!');
            }      
          
         return view('Admin.dashboard.tv_screen_video',compact('profile'));
        }



      function subscribeuserlist(){  
            if (!Auth::guard('admin')->check()) {
                return redirect()->route("admin.login");
            }       
            return view('Admin.subscribeduser.subscribeuser',compact('users'));
        }




     function subscribedusers(Request $request){  
         try {         
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $order=isset($request->jtSorting)?$request->jtSorting:'id DESC';
                $orderBy = explode(" ", $order);           
                  $userQuery = Unsubscribe_users::query(); 
                   if(isset($request->status) && $request->status!=''){
                                   $userQuery->where(function ($query) use($request){
                                    $query->where('status',$request->status)
                                          // ->where('newsletter',1)                      
                                          ->where('is_delete',0);
                                });
                              
                    } else {
                           $userQuery->where(function ($query){
                           $query->where('is_delete',0);
                       });
                    }  
                if(isset($request->keyword) && $request->keyword!=''){
                  $userQuery->where(function ($query) use($request){
                        $query->orWhere( 'email', 'LIKE', '%'. $request->keyword .'%')
                            ->orWhere('created_at', 'LIKE', '%' . $request->keyword . '%');
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


     public function managesubscription(Request $request){ 

        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
                //dd($request->all());
              $userexist = Unsubscribe_users::where('id',$request->userid)->first();      
                if($request->statuskey == 2){

                    if($request->newsletter == 1){

                        $newsletter = 0;
                        $message ='User has been unsubscribed successfully.';
                    }else{
                        $newsletter = 1;
                       // dd($updateData);
                        $message ='User has been subscribed successfully.';
                    }
                }
               
                $dd = Unsubscribe_users::where('id',$request->userid)->update(['newsletter' => $newsletter]);
               // dd($userexist->id);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
    }

    function bulkmail(Request $request){
       
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
         $session = Auth::guard('admin')->User();
         $id = $session->id;
         $users = Unsubscribe_users::where('status',1)->where('is_delete',0)->where('newsletter',1)->get();
        
        if($request->isMethod('post') ) {
            $subject = $request->subject;
            $message = $request->message;
             if(!empty($users)) {

             $arr = array();
            foreach ($users as $key => $v) {
              
                $arr[]=$v->email;
                    
            }
           
             
            Mail::to($arr)->send(new BroadcastMail($subject,$message));
            return redirect('admin/subscribeuserlist')->with('message', "Mail has been sent successfully");
                 
              
            }else{
                return redirect('admin/subscribeuserlist')->with('message', "Oops! something went wrong");
             }
          
         
        }   
       
            return view('Admin.subscribeduser.bulkmail');
     
 }
function sendmailtouser(Request $request,$userid,$newsletter){
   
    if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
         $session = Auth::guard('admin')->User();
         $id = $session->id;
         $users = Unsubscribe_users::where('id',$userid)->where('status',1)->where('is_delete',0)->first();
         if($newsletter == 1){
            $mailtemplate = EmailTemplate::where('slug','subscribe')->first();
         }else{
            $mailtemplate = EmailTemplate::where('slug','unsubscribe')->first();
         }
         
        if($request->isMethod('post') ) {
          
            $post=$request->all();

            $subject = $post['subject'];
            $message = $post['message'];
            if($newsletter == 1){
                 Mail::to($users->email)->send(new SubscribeMail($users,$subject,$message));
                return redirect('admin/subscribeuserlist')->with('message', "Mail has been sent successfully");
         
            }else{
                 Mail::to($users->email)->send(new UnsubscribeMail($users,$subject,$message));
                return redirect('admin/subscribeuserlist')->with('message', "Mail has been sent successfully");
            }
                   
              
            
          
         
        }  
       
          return view('Admin.subscribeduser.bulkmail',compact('users')); 
}
     
    function tvscreeninglist(){

        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $tvsrreningdata = Tvscreening::where('is_delete',0)    
                                ->where('status',0)
                                ->get();
        

        return view('Admin.Tvscreening.tvscreenlist');
    
    }
    function showtvscreenlist(Request $request){

         try {         
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $order=isset($request->jtSorting)?$request->jtSorting:'id DESC';
                $orderBy = explode(" ", $order);           
                $userQuery = Tvscreening::with('tvscreeningvideoCreatedBy');                
                $userQuery->where(function ($query){
                          $query->where('is_delete',0);
                }); 

                if(isset($request->keyword) && $request->keyword!=''){
                  $userQuery->where(function ($query) use($request){
                        $query->orWhere( 'title', 'LIKE', '%'. $request->keyword .'%')
                             ->orWhere( 'notes', 'LIKE', '%'. $request->keyword .'%')
                            ->orWhere('created_at', 'LIKE', '%' . $request->keyword . '%');
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
                    //$user['view_count'] = count($user['usedlibrary']); 
                    $user['created_at'] = date('Y-m-d', strtotime($user['created_at'])); 
                   // $user['file_size'] = Helper::formatSizeUnits($user['file_size']); 
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
    function addtvscreeningfile(Request $request){

        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }        
        $user_id = Auth::guard('admin')->user()->id;
      //  echo $user_id ; die;
        if($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'title' =>   'required|max:255',
                'library_file' => 'required',
            ]);            
            if($validator->fails()) {
              return back()->withInput()->withErrors($validator->errors());
            }         
            $Tvscreening = new Tvscreening();
            $Tvscreening->user_id= $user_id ;  
            $Tvscreening->title= $request->title;  
            $Tvscreening->notes= $request->notes;  
            $Tvscreening->updated_by= $user_id; 
            if($request->hasfile('library_file')){
               $extension =  $request->file('library_file')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('library_file'), time().rand().'.'.$extension, 'public');
                $file_name = config('constants.DO_STORAGE_URL').$path;
                $Tvscreening->file_name= $file_name ;
            }
            if($request->hasfile('thumbnail')){
                   
                    $extension =  $request->file('thumbnail')->extension();
                    $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('thumbnail'), time().rand().'.'.$extension, 'public');
                    $thumbnail = config('constants.DO_STORAGE_URL').$path;
                   $Tvscreening->thumbnail= $thumbnail ;  
              
            }
            
            
            
            
            if($Tvscreening->save()){
                return redirect('admin/tvscreeninglist')->with('message', "Tv screening video has added successfully");
            }else{
                return redirect()->back()->with('error', 'Internal error occurred!');
            }
        }
        return view('Admin.Tvscreening.tvscreenvideoadd');
    }
    function tvsreeningedit(Request $request,$id){
       
        if (!Auth::guard('admin')->check()) {
                return redirect()->route("admin.login");
            }
            $profile = Tvscreening::where('id',$id)->first();
            if(!$profile){
                return back()->with('message', 'Sorry! I think you are in worng path.');
            }
            $session = Auth::guard('admin')->User();
            $user_id = $session->id;

            if($request->isMethod('post')) {
               
                $post=$request->all();
               
                $title=$post['title']??'';
                $notes=$post['notes']??$profile->notes;
               
                if($request->hasfile('library_file')){
                   
                    $extension =  $request->file('library_file')->extension();
                    $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('library_file'), time().rand().'.'.$extension, 'public');
                    $file_name = config('constants.DO_STORAGE_URL').$path;
                    
              
                }else{
                    $file_name = $profile->file_name;
                   
                }

                 if($request->hasfile('thumbnail')){
                   
                    $extension =  $request->file('thumbnail')->extension();
                    $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('thumbnail'), time().rand().'.'.$extension, 'public');
                    $thumbnail = config('constants.DO_STORAGE_URL').$path;
                    
              
                }else{
                    $thumbnail = $profile->thumbnail;
                   
                }
               
               
                $today=date('Y-m-d H:i:s');
                
             
                
                Tvscreening::where('id',$id)->update(['user_id' => $user_id,'title'=> $title, 'file_name' => $file_name,'notes' => $notes,'updated_by' => $user_id,'status' => 0, 'is_delete' => 0,'created_at' =>$today, 'updated_at' => now()]); 
                
                return back()->with('message', 'Tvscreening video has been updated successfully!');
            }      
          
         return view('Admin.Tvscreening.edittvscreenvideo',compact('profile'));
    }

    function deletetvscreenvideo(Request $request){
         if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = Tvscreening::where('id',$request->userid)->first();          
               $updateData = ['is_delete'=>1];
               $message ='File has deleted successfully.';               
               Tvscreening::where('id',$userexist->id)->update($updateData);
               return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
    }
    
    function statusTvscreening(Request $request){
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = Tvscreening::where('id',$request->userid)->first();

                    if($request->accountactiveStatus == 0){
                        $updateData = ['status'=>1];
                        $message ='Tv screening video has been inactived successfully.';
                    }else if($request->accountactiveStatus == 1){
                        $updateData = ['status'=>0];
                        $message ='Tv screening video has been actived successfully.';
                    }
                Tvscreening::where('id',$userexist->id)->update($updateData);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
          
        }
    }
}
