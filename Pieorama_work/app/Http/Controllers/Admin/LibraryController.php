<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Exception;
use Validator;
use App\Models\User;
use App\Models\Library;
use App\Models\PieFlavor;
use App\Models\AudienceReactions;
use App\Models\ChromaKeys;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class LibraryController extends Controller
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

    public function audioLibraryList(){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }

        return view('Admin.library.libraryList');
    }

    public function audioAdd(Request $request){

        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }        
        $user_id = Auth::guard('admin')->user()->id;
      
        if($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'title' =>   'required|max:255',
                'library_file' => 'required',
                 'type'          => 'required'
            ]);            
            if($validator->fails()) {
              return back()->withInput()->withErrors($validator->errors());
            } 
                
            $library = new Library();
            $library->user_id= $user_id ;  
            $library->title= $request->title; 
            $library->type= $request->type; 
            $library->comment_note= $request->comment_note;  
            $library->library_tags= $request->library_tags; 

             if($request->hasFile('library_file') ){

                $audiofile = $request->file('library_file');
                $file_mime_type=$audiofile->getClientOriginalExtension();
                $file_size=$audiofile->getSize();
                 $extension =  $request->file('library_file')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('library_file'), time().rand().'.'.$extension, 'public');
                $audio_name = config('constants.DO_STORAGE_URL').$path;
            
            }else{
                $audio_name = '';
                $file_size = '';
                $file_mime_type = '';
            }
            $library->file_type= 2 ;
            $library->file_name= $audio_name ;
            $library->file_size= $file_size ;
            $library->file_mime_type= $file_mime_type ;
            if($library->save()){
                return redirect('admin/audio-library')->with('message', "Audio has added successfully");
            }else{
                return redirect()->back()->with('error', 'Internal error occurred!');
            }
        }
        return view('Admin.library.audioAdd');
    }

    
     public function editmedia(Request $request,$id)
    {   
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $profile = Library::where('id',$id)->first();
        if(!$profile){
            return back()->with('message', 'Sorry! I think you are in worng path.');
        }
        $session = Auth::guard('admin')->User();
        $user_id = $session->id;
        if( $request->isMethod('post') ) {           
            $validator = Validator::make($request->all(), [
                'title' =>   'required|max:255',
                'library_file' => 'required',
            ]);  
            if($validator->fails()) {
              return back()->withErrors($validator->errors($request[0])->first());
            }       
            if($request->hasfile('library_file')){
                $audiofile = $request->file('library_file');
                $file_mime_type=$audiofile->getClientOriginalExtension();
                $file_size=$audiofile->getSize();
                 $extension =  $request->file('library_file')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('library_file'), time().rand().'.'.$extension, 'public');
                $audio_name = config('constants.DO_STORAGE_URL').$path;

            }else{
                $audio_name = $profile->file_name;
                $file_size = $profile->file_size;
                $file_mime_type = $profile->file_mime_type;
            }
            $updateData = ['title'=>$request->title,'comment_note'=>$request->comment_note, 'library_tags'=>$request->library_tags, 'file_name'=>$audio_name,'file_size'=>$file_size, 'file_mime_type'=>$file_mime_type,'updated_by'=>$user_id,'type' => $request->type];
            Library::where('id',$id)->update($updateData);
            //return back()->with('message', 'Media has been updated successfully!');
             return redirect('admin/audio-library')->with('message', "Media has been updated successfully!");
        }        
        return view('Admin.library.editmedia',compact('profile'));
    }



     public function editmediavideo(Request $request,$id)
    {   
       // echo "test"; die;
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $profile = Library::where('id',$id)->first();
        if(!$profile){
            return back()->with('message', 'Sorry! I think you have worng path.');
        }
        $session = Auth::guard('admin')->User();
        $user_id = $session->id;
        if( $request->isMethod('post') ) {           
            $validator = Validator::make($request->all(), [
                'title' =>   'required|max:255',
            ]);  
            if($validator->fails()) {
              return back()->withErrors($validator->errors($request[0])->first());
            }       
            if($request->hasfile('library_file')){
                $audiofile = $request->file('library_file');
                $file_mime_type=$audiofile->getClientOriginalExtension();
                $file_size=$audiofile->getSize();
                 $extension =  $request->file('library_file')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('library_file'), time().rand().'.'.$extension, 'public');
                $file_name = config('constants.DO_STORAGE_URL').$path;
                
            }else{
                $file_name = $profile->file_name;
                $file_size = $profile->file_size;
                $file_mime_type = $profile->file_mime_type;
            }
            $updateData = ['title'=>$request->title, 'comment_note'=>$request->comment_note, 'library_tags'=>$request->library_tags, 'file_name'=>$file_name,'file_size'=>$file_size,'file_mime_type'=>$file_mime_type,'updated_by'=>$user_id];
            Library::where('id',$id)->update($updateData);
           // return back()->with('message', 'Media has been updated successfully!');
             return redirect('admin/video-library')->with('message', "Media has been updated successfully!");
        }        
        return view('Admin.library.editmediavideo',compact('profile'));
    }


    public function libraryajaxlist(Request $request){  
         try {         
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $order=isset($request->jtSorting)?$request->jtSorting:'id DESC';
                $orderBy = explode(" ", $order);           
               // $userQuery = library::query();  
                $userQuery = Library::with('usedlibrary');              
                $userQuery->where(function ($query){
                          $query->where('file_type',2)
                                ->where('is_delete',0);
                }); 

                if(isset($request->keyword) && $request->keyword!=''){
                  $userQuery->where(function ($query) use($request){
                        $query->orWhere( 'title', 'LIKE', '%'. $request->keyword .'%')
                              ->orWhere( 'library_tags', 'LIKE', '%'. $request->keyword .'%')
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
                    $user['view_count'] = count($user['usedlibrary']); 
                    $user['created_at'] = date('Y-m-d', strtotime($user['created_at'])); 
                    $user['file_size'] = Helper::formatSizeUnits($user['file_size']); 
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



    public function videoLibraryList(){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }       
        return view('Admin.library.videolibraryList');
    }


    public function libraryajaxvideolist(Request $request){  
         try {         
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $order=isset($request->jtSorting)?$request->jtSorting:'id DESC';
                $orderBy = explode(" ", $order);           
                $userQuery = Library::with('usedlibrary');                
                $userQuery->where(function ($query){
                          $query->where('file_type',3)
                                ->where('is_delete',0);
                }); 

                if(isset($request->keyword) && $request->keyword!=''){
                  $userQuery->where(function ($query) use($request){
                        $query->orWhere( 'title', 'LIKE', '%'. $request->keyword .'%')
                             ->orWhere( 'library_tags', 'LIKE', '%'. $request->keyword .'%')
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
                    $user['view_count'] = count($user['usedlibrary']); 
                    $user['created_at'] = date('Y-m-d', strtotime($user['created_at'])); 
                    $user['file_size'] = Helper::formatSizeUnits($user['file_size']); 
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



    public function videoAdd(Request $request){  
	 
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
            $library = new Library();
            $library->user_id= $user_id ;  
            $library->title= $request->title;  
            $library->comment_note= $request->comment_note;  
            $library->library_tags= $request->library_tags; 
            if($request->hasfile('library_file')){
                $audiofile = $request->file('library_file');
                $file_mime_type=$audiofile->getClientOriginalExtension();
                $file_size=$audiofile->getSize();
                 $extension =  $request->file('library_file')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('library_file'), time().rand().'.'.$extension, 'public');
                $file_name = config('constants.DO_STORAGE_URL').$path;
            }else{
                $file_name = '';
                $file_size = '';
                $file_mime_type = '';
            }
            $library->file_type= 3 ;  
            $library->file_name= $file_name ; 
            $library->file_size= $file_size ; 
            $library->file_mime_type= $file_mime_type ;
            if($library->save()){
                return redirect('admin/video-library')->with('message', "Video has added successfully");
            }else{
                return redirect()->back()->with('error', 'Internal error occurred!');
            }
        }
        return view('Admin.library.videoAdd');
    }




    public function imageLibraryList(){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }       
        return view('Admin.library.imagelibraryList');
    }


    public function libraryajaximagelist(Request $request){  
        try {         
            $limit=$request->jtPageSize;
            $offset=$request->jtStartIndex; 
            $order=isset($request->jtSorting)?$request->jtSorting:'id DESC';
            $orderBy = explode(" ", $order);           
            $userQuery = Library::with('usedlibrary');               
            $userQuery->where(function ($query){
                      $query->where('file_type',1)
                            ->where('is_delete',0);
            }); 

            if(isset($request->keyword) && $request->keyword!=''){
              $userQuery->where(function ($query) use($request){
                    $query->orWhere( 'title', 'LIKE', '%'. $request->keyword .'%')
                         ->orWhere( 'library_tags', 'LIKE', '%'. $request->keyword .'%')
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
                $user['view_count'] = count($user['usedlibrary']); 
                $user['created_at'] = date('Y-m-d', strtotime($user['created_at'])); 
                $user['file_size'] = Helper::formatSizeUnits($user['file_size']); 
                array_push($user_data,$user);
            }
            // end code of serial number
            $data["Result"] = "OK";
            $data["Records"] = Helper::html_filterd_data($user_data);
            $data["TotalRecordCount"] = $UserCount;
            echo json_encode($data);
            die;   
        }catch (\Exception $e) { 
        
            return ['success'=> 0, 'message' => [$e->getMessage()]];
        }
    }



    public function imageAdd(Request $request){  
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
            $library = new Library();
            $library->user_id= $user_id ;  
            $library->title= $request->title;  
            $library->comment_note= $request->comment_note; 
            $library->library_tags= $request->library_tags;  
            if($request->hasfile('library_file')){
                $audiofile = $request->file('library_file');
                $file_mime_type=$audiofile->getClientOriginalExtension();
                $file_size=$audiofile->getSize();
                 $extension =  $request->file('library_file')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('library_file'), time().rand().'.'.$extension, 'public');
                $file_name = config('constants.DO_STORAGE_URL').$path;
            }else{
                $file_name = '';
                $file_size = '';
                $file_mime_type = '';
            }
            $library->file_type= 1 ;  
            $library->file_name= $file_name ; 
            $library->file_size= $file_size ; 
            $library->file_mime_type= $file_mime_type ;
            if($library->save()){
                return redirect('admin/image-library')->with('message', "Image has added successfully");
            }else{
                return redirect()->back()->with('error', 'Internal error occurred!');
            }
        }
        return view('Admin.library.imageAdd');
    }



     public function editmediaimage(Request $request,$id)
    {   
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        $profile = Library::where('id',$id)->first();
        if(!$profile){
            return back()->with('message', 'Sorry! I think you have worng path.');
        }
        $session = Auth::guard('admin')->User();
        $user_id = $session->id;
        if( $request->isMethod('post') ) {           
            $validator = Validator::make($request->all(), [
                'title' =>   'required|max:255',
            ]);  
            if($validator->fails()) {
              return back()->withErrors($validator->errors($request[0])->first());
            }       
            if($request->hasfile('library_file')){
                $audiofile = $request->file('library_file');
                $file_mime_type=$audiofile->getClientOriginalExtension();
                $file_size=$audiofile->getSize();
                 $extension =  $request->file('library_file')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('library_file'), time().rand().'.'.$extension, 'public');
                $file_name = config('constants.DO_STORAGE_URL').$path; 
            }else{
                $file_name = $profile->file_name;
                $file_size = $profile->file_size;
                $file_mime_type = $profile->file_mime_type;
            }
            $updateData = ['title'=>$request->title, 'comment_note'=>$request->comment_note, 'library_tags'=>$request->library_tags, 'file_name'=>$file_name,'file_size'=>$file_size,'file_mime_type'=>$file_mime_type,'updated_by'=>$user_id];
            Library::where('id',$id)->update($updateData);
            return redirect('admin/image-library')->with('message', "Media has been updated successfully!");
           // return back()->with('message', 'Media has been updated successfully!');
        }        
        return view('Admin.library.editmediaimage',compact('profile'));
    }


    public function libraryActivateDeavtivateStatus(Request $request){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               // echo $request->accountactiveStatus ; die;
               $userexist = Library::where('id',$request->userid)->first();   
                    if($request->accountactiveStatus == 0){
                        $updateData = ['status'=>1];
                        $message ='Media file has been inactive successfully.';
                    }else if($request->accountactiveStatus == 1){
                        $updateData = ['status'=>0];
                        $message ='Media file has been active successfully.';
                    }
                Library::where('id',$userexist->id)->update($updateData);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
          
        }
    }


   


    public function deleteMedia(Request $request){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = Library::where('id',$request->userid)->first();          
               $updateData = ['is_delete'=>1];
               $message ='File has deleted successfully.';               
               Library::where('id',$userexist->id)->update($updateData);
               return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
    }

    public function pie_flavor(){
        if(!Auth::guard('admin')->check()){
            return redirect()->route('admin.login');
        }
        return view('Admin.library.pie_flavor');

    }
    public function pie_flavor_list(Request $request){
        try {         
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $order=isset($request->jtSorting)?$request->jtSorting:'id DESC';
                $orderBy = explode(" ", $order);           
               // $userQuery = library::query();  
                $userQuery = PieFlavor::with('pieFlavorCreatedBy');              
                $userQuery->where(function ($query){
                          $query->where('is_deleted',0);
                }); 

                if(isset($request->keyword) && $request->keyword!=''){
                  $userQuery->where(function ($query) use($request){
                        $query->orWhere( 'p_name', 'LIKE', '%'. $request->keyword .'%')
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
                   // $user['view_count'] = count($user['usedlibrary']); 
                    $user['created_at'] = date('Y-m-d', strtotime($user['created_at'])); 
                    //$user['file_size'] = Helper::formatSizeUnits($user['file_size']); 
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

    public function addpieflavor(Request $request){
        if(!Auth::guard('admin')){
            return redirect()->route('admin.login');
        }
        try{
            $user_id = Auth::guard('admin')->user()->id;
            if($request->isMethod('post')){
                 $data = $request->all();
                $validator=Validator::make($request->all(),[
                  'p_name'=> 'required',
                  'p_img' => 'required',
                 // 'landscape_img' => 'required',
                 // 'chroma_key_id' => 'required'
               ]);
                if($validator->fails()) {
                    return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
                }

                 if($request->hasFile('p_img')){

                    $extension =  $request->file('p_img')->extension();
                    $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('p_img'), time().rand().'.'.$extension, 'public');
                    $p_image_name = config('constants.DO_STORAGE_URL').$path;
                  }else{
                    $p_image_name = '';
                  }
                   if($request->hasFile('portrait_img')){

                    $extension =  $request->file('portrait_img')->extension();
                    $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('portrait_img'), time().rand().'.'.$extension, 'public');
                    $portrait_image_name = config('constants.DO_STORAGE_URL').$path;
                  }else{
                    $portrait_image_name = '';
                  }
                  if($request->hasFile('landscape_img')){

                    $extension =  $request->file('landscape_img')->extension();
                    $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('landscape_img'), time().rand().'.'.$extension, 'public');
                    $l_image_name = config('constants.DO_STORAGE_URL').$path;
                  }else{
                    $l_image_name = '';
                  }


                $PieFlavor = new PieFlavor();
                $PieFlavor->created_by = $user_id;
                $PieFlavor->p_name = $data['p_name'];
                $PieFlavor->chroma_key_id = $data['chroma_key_id']??1;
                $PieFlavor->p_img = $p_image_name;
                $PieFlavor->portrait_img = $portrait_image_name;
                $PieFlavor->landscape_img = $l_image_name;
                $PieFlavor->type = 1;
                $PieFlavor->status =  1;
                //$PieFlavor->save();
                  if($PieFlavor->save()){
                    return redirect('admin/pie_flavor')->with(['message' => 'Pie flavor added successfully!!']);
                      }
                   else {

                       return redirect()->back()->with('error', 'oops! something went wrong');
                    }

            }
        }catch(\Exception $e){
             dd($e);
                return ['success'=> 0, 'message' => [$e->getMessage()]];
        }
        return view('Admin.library.add_pieflavor');
    }

    public function deletepieflavor(Request $request){
         if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = PieFlavor::where('id',$request->userid)->first();          
               $updateData = ['is_deleted'=>1];
               $message ='Pie Flavor has deleted successfully.';               
               PieFlavor::where('id',$userexist->id)->update($updateData);
               return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
    }

     public function edit_pie_flavor(Request $request, $id){
            if(!Auth::guard('admin')->check()){
                return redirect()->route('admin.login');
            }
            try{
                $data = PieFlavor::where('id',$id)->first();
                        if(!$data){
                            return back()->with('message', 'Sorry! I think you have worng path.');
                        }
                        $session = Auth::guard('admin')->User();
                        $user_id = $session->id;
                        if( $request->isMethod('post') ) {           
                            $validator = Validator::make($request->all(), [
                                'p_name' =>   'required|max:255',
                            ]);  
                            if($validator->fails()) {
                              return back()->withErrors($validator->errors($request[0])->first());
                            }       
                            if($request->hasFile('p_img')){

                                $extension =  $request->file('p_img')->extension();
                                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('p_img'), time().rand().'.'.$extension, 'public');
                                $p_image_name = config('constants.DO_STORAGE_URL').$path;
                              }else{
                                $p_image_name = $data->p_img;
                              }
                               if($request->hasFile('portrait_img')){

                                $extension =  $request->file('portrait_img')->extension();
                                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('portrait_img'), time().rand().'.'.$extension, 'public');
                                $portrait_image_name = config('constants.DO_STORAGE_URL').$path;
                              }else{
                                $portrait_image_name = $data->portrait_img;
                              }
                              if($request->hasFile('landscape_img')){

                                $extension =  $request->file('landscape_img')->extension();
                                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('landscape_img'), time().rand().'.'.$extension, 'public');
                                $l_image_name = config('constants.DO_STORAGE_URL').$path;
                              }else{
                                $l_image_name = $data->landscape_img;
                              }
                            $updateData = ['p_name'=>$request->p_name, 'p_img'=>$p_image_name,'portrait_img' => $portrait_image_name, 'landscape_img' => $l_image_name];
                            PieFlavor::where('id',$id)->update($updateData);
            $chromakey = array();
                if($request->hasFile('ChromaKeyImage')){
                   
                    if($request->is_landscape == null){
                        
                        return redirect()->back()->with('error', 'please select is landscape');
                    }
                    $p_image = $request->file('ChromaKeyImage');
                    $imgcount = count($p_image);
                     
                        foreach ($p_image as $key => $v) {
                                 $extension =  $v->extension();
                                $filename =  $v->getClientOriginalName();
                                $without_extension = pathinfo($filename, PATHINFO_FILENAME);
                                //dd($without_extension);
                                $path = Storage::disk('do_spaces')->putFileAs("uploads", $v, time().rand().'.'.$extension, 'public');

                                $p_image_name = config('constants.DO_STORAGE_URL').$path;
                                //$portrait_image_name = $dataarray;
                               // dd($portrait_image_name);
                             $chromakey[] = [
                              'created_by' => $user_id,
                              'name' => $without_extension,
                              'pieflavor_id' => $id??1,
                              'chroma_key_id' => $$request->is_landscape??1,
                              'chromak_keys_img' => $p_image_name,
                              //'sort_landscape_img' => $without_extension,
                              'sort_by' => $without_extension,
                              'status' => 1,
                              'is_deleted' => 0,
                          ];
                    }
                     
                      $insertarray = count($chromakey);
                      if($insertarray == $imgcount){

                         $ChromaKeys=  ChromaKeys::insert($chromakey);
                         return redirect('admin/edit-pie_flavor/'. $id.'')->with('message', "Chroma keys has been updated successfully.");
                      }else{
                          return redirect()->back()->with('error', 'some files are missing');
                       }
                        
                    }
                            return redirect('admin/pie_flavor')->with('message', "Pie flavor has been updated successfully!");

            }
        }catch(\Exception $e){

                    return ['success' => 0, 'message' => [$e->getMessage()]];

            }
            return view('Admin.library.edit_pieflavor',compact('data'));
    }


    public function audience_reaction(){
        if(!Auth::guard('admin')->check()){
            return redirect()->route('admin.login');
        }
        return view('Admin.library.audience_reaction');
    }

    public function getAudienceReaction(Request $request){
            try{
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $type = $request->type;
                $order=isset($request->jtSorting)?$request->jtSorting:'id DESC';
                $orderBy = explode(" ", $order);           
               // $userQuery = library::query();
                 
                $userQuery = AudienceReactions::with('AudeineceReactionsCreatedBy'); 
               
                if($type == 1){
                    $userQuery->where(function ($query){
                      $query->where('type',1)
                            ->where('is_deleted',0);
                }); 
                }else{
                    $userQuery->where(function ($query){
                      $query->where('type',2)
                            ->where('is_deleted',0);
                }); 
                }
                
                             
                

                if(isset($request->keyword) && $request->keyword!=''){
                  $userQuery->where(function ($query) use($request){
                        $query->orWhere( 'name', 'LIKE', '%'. $request->keyword .'%')
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
                   // $user['view_count'] = count($user['usedlibrary']); 
                    $user['created_at'] = date('Y-m-d', strtotime($user['created_at'])); 
                    //$user['file_size'] = Helper::formatSizeUnits($user['file_size']); 
                    array_push($user_data,$user);
                }
               
                // end code of serial number
                $data["Result"] = "OK";
                $data["Records"] = Helper::html_filterd_data($user_data);
                $data["TotalRecordCount"] = $UserCount;
                echo json_encode($data);
                die;  
            }catch(\Exception $e){
                return ['success' => 0, 'message' => [$e->getMessage()]];
            }
    }

    public function add_audiencereactions(Request $request){

        if(!Auth::guard('admin')->check()){
             return redirect()->route('admin.login');
        }
        try{
            $user_id = Auth::guard('admin')->user()->id;
            if($request->isMethod('post')){
                 $data = $request->all();
                 if($data['type'] == 1){
                     $validator=Validator::make($request->all(),[
                      'name'=> 'required',
                      'url' => 'required',
                      'shape' => 'required',
                  ]);
                 }else{
                    $validator=Validator::make($request->all(),[
                      'name'=> 'required',
                  ]);
                 }

                // print_r($request->all()); die;
                
                if($validator->fails()) {
                    return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
                }

                 if($request->hasFile('url')){
                $extension =  $request->file('url')->extension();
                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('url'), time().rand().'.'.$extension, 'public');
                $p_image_name = config('constants.DO_STORAGE_URL').$path;
                  }else{
                    $p_image_name = '';
                  }
                   // print_r($data['name']); die;
                if($data['type'] == 2){
                    $name = str_replace("#","",$data['name']);  
                } else {
                   $name = $data['name'] ; 
                }

                $PieFlavor = new AudienceReactions();
                $PieFlavor->created_by = $user_id;
                $PieFlavor->name = $name;
                $PieFlavor->type = $data['type'];
                $PieFlavor->shape_id = $data['shape']??'';
                $PieFlavor->url = $p_image_name;
                $PieFlavor->status =  1;
                //$PieFlavor->save();
                  if($PieFlavor->save()){
                    if($data['type'] == 1){
                        return redirect('admin/audience_reaction')->with(['message' => 'Audience reaction added successfully!!']);
                    }else{
                        return redirect('admin/trending_tags')->with(['message' => 'trending tag added successfully!!']);
                    }
                    
                }else {

                  return redirect()->back()->with('error', 'oops! something went wrong');
                }

            }

        }catch(\Exception $e){
            return ['success' => 0, 'message' => [$e->getMessage()]];
        }
       return view('Admin.library.add_audiencereactions');
    }

    public function edit_audience_reaction(Request $request, $id){

        if(!Auth::guard('admin')->check()){
            return redirect()->route('admin.login');
        }
        try{

             $data = AudienceReactions::where('id',$id)->first();
               
                if(!$data){
                    return back()->with('message', 'Sorry! I think you have worng path.');
                }
                $session = Auth::guard('admin')->User();
                $user_id = $session->id;
                if( $request->isMethod('post') ) {           
                    $validator = Validator::make($request->all(), [
                        'name' =>   'required|max:255',
                    ]);  
                    if($validator->fails()) {
                      return back()->withErrors($validator->errors($request[0])->first());
                    }       
                    if($request->hasFile('url')){

                        $extension =  $request->file('url')->extension();
                        $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('url'), time().rand().'.'.$extension, 'public');
                        $p_image_name = config('constants.DO_STORAGE_URL').$path;
                      }else{
                        $p_image_name = $data->url;
                      }
                    $updateData = ['name'=>$request->name, 'url'=>$p_image_name, 'shape_id' => $request->shape??''];
                    AudienceReactions::where('id',$id)->where('type',$data->type)->update($updateData);
                    if($data->type == 1){
                         return redirect('admin/audience_reaction')->with('message', "Audience Reaction has been updated successfully!");
                     }else{
                         return redirect('admin/trending_tags')->with('message', "Trending tags has been updated successfully!");
                     }
                   

            }

        }catch(\Exception $e){
            return ['success' => 0, 'message' => [$e->getMessage()]];
        }
        return view('Admin.library.edit_audience_reaction',compact('data'));
    }

    public function deleteAudienceReactions(Request $request){
            if(!Auth::guard('admin')->check()){
                return redirect()->route('admin.login');
            }
          
        if($request->isMethod('post')){
            try{
                $existdata = AudienceReactions::where('id',$request->userid)->first();
                $updateData = ['is_deleted' => 1];
                if($existdata->type == 1){
                    $message = 'Audience Reaction deleted successfully!!';
                }else{
                    $message = 'Trending tag deleted successfully!!'; 
                }
               
                AudienceReactions::where('id',$existdata->id)->update($updateData);
                if($existdata->type == 1){
                    return ['status' => 1, 'message' => 'Audience Reaction has been deleted successfully!!'];
                }else{
                    return ['status' => 1, 'message' => 'Trending tag has been deleted successfully!!'];
                }
                
            }catch(\Exception $e){
                return['success' => 0, 'message' => [$e->getMessage()]];
            }
        }
    }

    public function trending_tags(){
        if(!Auth::guard('admin')->check()){
            return redirect()->route('admin.login');
        }
        return view('Admin.library.trending_tags');
    }
    public function activateDeactivate_pie_flvaor(Request $request){
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = PieFlavor::where('id',$request->userid)->first();   
                    if($request->accountactiveStatus == 0){
                        $updateData = ['status'=>0];
                        $message ='Pie flavor has been inactived successfully.';
                    }else if($request->accountactiveStatus == 1){
                        $updateData = ['status'=>1];
                        $message ='Pie flavor has been actived successfully.';
                    }
                PieFlavor::where('id',$userexist->id)->update($updateData);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
          
        }
    }

     public function activateDeactivate_audience_reaction(Request $request){
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = AudienceReactions::where('id',$request->userid)->first(); 

                    if($request->accountactiveStatus == 0){
                        $updateData = ['status'=>0];
                        if($userexist->type == 1){
                            $message ='Audience reaction has been inactived successfully.';
                        }else{
                            $message ='Trending tag has been inactived successfully.';
                        }
                        
                    }else if($request->accountactiveStatus == 1){
                        $updateData = ['status'=>1];
                        if($userexist->type == 1){
                            $message ='Audience reaction has been actived successfully.';
                        }else{
                            $message ='Trending tag has been actived successfully.';
                        }
                        
                    }
                AudienceReactions::where('id',$userexist->id)->update($updateData);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
          
        }
    }

     public function chroma_keys(){
        if(!Auth::guard('admin')->check()){
            return redirect()->route('admin.login');
        }
        return view('Admin.library.chroma_keys');

    }
    public function chroma_keys_list(Request $request, $id = ""){

        try {         
                $limit=$request->jtPageSize;
                $offset=$request->jtStartIndex; 
                $order=isset($request->jtSorting)?$request->jtSorting:'id DESC';
                $orderBy = explode(" ", $order);           
               // $userQuery = library::query();  
                $userQuery = ChromaKeys::with('chromaKeysCreatedBy');
                if($id) {
                    $userQuery->where(function ($query) use($id){
                          $query->where('is_deleted',0)
                                ->where('pieflavor_id','=',$id);
                }); 
                } else{
                    $userQuery->where(function ($query){
                          $query->where('is_deleted',0);
                          
                }); 
                }            
                

                if(isset($request->keyword) && $request->keyword!=''){
                  $userQuery->where(function ($query) use($request){
                        $query->orWhere( 'name', 'LIKE', '%'. $request->keyword .'%')
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
                   // $user['view_count'] = count($user['usedlibrary']); 
                    $user['created_at'] = date('Y-m-d', strtotime($user['created_at'])); 
                    //$user['file_size'] = Helper::formatSizeUnits($user['file_size']); 
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

    public function deleteallchromakeys(Request $request){
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               //$userexist = ChromaKeys::where('id',$request->userid)->first();          
               //$deleted_at = date('Y-m-d h:i:s');
               //$updateData = ['is_deleted'=>1,'deleted_at'=>$deleted_at];
               $message ='Chroma Key has deleted successfully.';               
               ChromaKeys::where('pieflavor_id',$request->chromakeyid)->delete();
               return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
        
    }


    public function add_chroma_keys(Request $request){
        if(!Auth::guard('admin')){
            return redirect()->route('admin.login');
        } 
        try{
            $pieflavors = PieFlavor::where('status',1)->where('is_deleted',0)->get();
            $user_id = Auth::guard('admin')->user()->id;
            if($request->isMethod('post')){
                 $data = $request->all();
                $validator=Validator::make($request->all(),[
                  //'name'=> 'required',
                  'ChromaKeyImage' => 'required',
                  'is_landscape' => 'required',
               ]);
                if($validator->fails()) {
                    return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
                }
               
                /* if($request->hasFile('ChromaKeyImage')){

                      $p_image = $request->file('ChromaKeyImage');
                    //  $dataarray = [];
                    //  foreach ($p_image as $key => $v) {
                        $extension =  $p_image->extension();
                        $path = Storage::disk('do_spaces')->putFileAs("uploads", $p_image, time().rand().'.'.$extension, 'public');
                        $p_image_name = config('constants.DO_STORAGE_URL').$path;
                      //   array_push($dataarray,"$p_image_name ");
                     // }
                  //  $p_image_name = $dataarray;
                      
                  }else{
                    $p_image_name = '';
                  }*/
                $chromakey = array();
                if($request->hasFile('ChromaKeyImage')){
                    $p_image = $request->file('ChromaKeyImage');
                    $imgcount = count($p_image);
                     if($data['is_landscape'] == 1){
                        foreach ($p_image as $key => $v) {
                                 $extension =  $v->extension();
                                $filename =  $v->getClientOriginalName();
                                $without_extension = pathinfo($filename, PATHINFO_FILENAME);
                                //dd($without_extension);
                                $path = Storage::disk('do_spaces')->putFileAs("uploads", $v, time().rand().'.'.$extension, 'public');

                                $p_image_name = config('constants.DO_STORAGE_URL').$path;
                                //$portrait_image_name = $dataarray;
                               // dd($portrait_image_name);
                             $chromakey[] = [
                              'created_by' => $user_id,
                              'name' => $without_extension,
                              'pieflavor_id' => $data['pieflavor_id']??1,
                              'chroma_key_id' => $data['is_landscape']??1,
                              'chromak_keys_img' => $p_image_name,
                              //'sort_landscape_img' => $without_extension,
                              'sort_by' => $without_extension,
                              'status' => 1,
                              'is_deleted' => 0,
                          ];
                    }
                  }elseif($data['is_landscape'] == 2){
                     foreach ($p_image as $key => $v) {
                                 $extension =  $v->extension();
                                $filename =  $v->getClientOriginalName();
                                $without_extension = pathinfo($filename, PATHINFO_FILENAME);
                                //dd($without_extension);
                                $path = Storage::disk('do_spaces')->putFileAs("uploads", $v, time().rand().'.'.$extension, 'public');

                                $p_image_name = config('constants.DO_STORAGE_URL').$path;
                                //$portrait_image_name = $dataarray;
                               // dd($portrait_image_name);
                             $chromakey[] = [
                              'created_by' => $user_id,
                              'name' => $without_extension,
                              'pieflavor_id' => $data['pieflavor_id']??1,
                              'chroma_key_id' => $data['is_landscape']??2,
                              'chromak_keys_img' => $p_image_name,
                              //'sort_portrait_img' => $without_extension,
                              'sort_by' => $without_extension,
                              'status' => 1,
                              'is_deleted' => 0,
                          ];
                    }


                  }
                  $insertarray = count($chromakey);
                  if($insertarray == $imgcount){

                     $ChromaKeys=  ChromaKeys::insert($chromakey);
                  }else{
                      return redirect()->back()->with('error', 'some files are missing');
                   }
                    
                }
                 
                
                     /*$ChromaKeys = new ChromaKeys();
                     $ChromaKeys->created_by = $user_id;
                     $ChromaKeys->name = $data['name'];
                     $ChromaKeys->pieflavor_id = $data['pieflavor_id']??1;
                     $ChromaKeys->chroma_key_id = $data['is_landscape']??1;
                     $ChromaKeys->chromak_keys_img = $p_image_name ;
                     $ChromaKeys->status =  1;
                     $ChromaKeys->is_deleted =  0;
                     $ChromaKeys->save();*/
              
                  if($ChromaKeys){
                    return redirect('admin/chroma_keys')->with(['message' => 'Chroma Key added successfully!!']);
                      }
                   else {

                       return redirect()->back()->with('error', 'oops! something went wrong');
                    }

            }
        }catch(\Exception $e){
             dd($e);
                return ['success'=> 0, 'message' => [$e->getMessage()]];
        }
        return view('Admin.library.add_chroma_keys', compact('pieflavors'));
    }

    public function deletechromakeys(Request $request){
         if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = ChromaKeys::where('id',$request->userid)->first();          
               $deleted_at = date('Y-m-d h:i:s');
               $updateData = ['is_deleted'=>1,'deleted_at'=>$deleted_at];
               $message ='Chroma Key has deleted successfully.';               
               ChromaKeys::where('id',$userexist->id)->update($updateData);
               return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
        }
    }

    public function edit_chroma_keys(Request $request, $id){
            if(!Auth::guard('admin')->check()){
                return redirect()->route('admin.login');
            }
            try{
                $pieflavors = PieFlavor::where('status',1)->where('is_deleted',0)->get();
                $data = ChromaKeys::where('id',$id)->first();
                //dd($data);
                        if(!$data){
                            return back()->with('message', 'Sorry! I think you have worng path.');
                        }
                        $session = Auth::guard('admin')->User();
                        $user_id = $session->id;
                        if( $request->isMethod('post') ) {  
                       // dd($request->all());         
                            $validator = Validator::make($request->all(), [
                                //'name' =>   'required|max:255',
                            ]);  
                            if($validator->fails()) {
                              return back()->withErrors($validator->errors($request[0])->first());
                            }   

                            if($request->hasFile('ChromaKeyImage')){

                                $extension =  $request->file('ChromaKeyImage')->extension();
                                 $filename =  $request->file('ChromaKeyImage')->getClientOriginalName();
                                $without_extension = pathinfo($filename, PATHINFO_FILENAME);
                                $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('ChromaKeyImage'), time().rand().'.'.$extension, 'public');
                                $p_image_name = config('constants.DO_STORAGE_URL').$path;
                              }else{
                                $p_image_name = $data->chromak_keys_img;
                                $without_extension = $data->sort_by;
                                /*if($request->is_landscape == 1){
                                     $without_extension = $data->sort_landscape_img;
                                 }elseif($request->is_landscape == 2){
                                    $without_extension = $data->sort_portrait_img;
                                 }*/
                                
                              }

                              //dd($without_extension);
                          //  if($request->is_landscape == 1){
                                //$sort_landscape_img = $without_extension;

                                $updateData = [
                                    'name'=>$without_extension, 
                                    'chromak_keys_img'=>$p_image_name,
                                   // 'sort_portrait_img' => null,
                                    //'sort_landscape_img' => $without_extension, 
                                    'sort_by' => $without_extension, 
                                    'pieflavor_id' => $request->pieflavor_id,
                                    'chroma_key_id' => $request->is_landscape,
                                    'updated_by' => $user_id];




                           // }
                            /*elseif($request->is_landscape == 2){
                                 //$sort_portrait_img = $without_extension;
                                 
                                 $updateData = [
                                    'name'=>$without_extension, 
                                    'chromak_keys_img'=>$p_image_name,
                                    'sort_portrait_img' => $without_extension,
                                    'sort_landscape_img' => null, 
                                    'pieflavor_id' => $request->pieflavor_id,
                                    'chroma_key_id' => $request->is_landscape,
                                    'updated_by' => $user_id];


                            }*/
                            
                            ChromaKeys::where('id',$id)->update($updateData);
                            return redirect('admin/chroma_keys')->with('message', "Chroma Key has been updated successfully!");

            }
        }catch(\Exception $e){

                    return ['success' => 0, 'message' => [$e->getMessage()]];

            }
            return view('Admin.library.edit_chroma_keys',compact('data','pieflavors'));
    }


    
    public function activatedchromakey(Request $request){
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }
        if( $request->isMethod('post') ) {
            try {
               $userexist = ChromaKeys::where('id',$request->userid)->first(); 

                    if($request->accountactiveStatus == 0){
                        $updateData = ['status'=>0];
                      
                             $message ='Chroma Key has been inactived successfully.';
                       
                    }else if($request->accountactiveStatus == 1){
                        $updateData = ['status'=>1];
                    
                            $message ='Chroma Key has been actived successfully.';
                       
                        
                    }
                ChromaKeys::where('id',$userexist->id)->update($updateData);
                return ['status'=>1,'message'=>$message];
            }catch (\Exception $e) { 
                return ['success'=> 0, 'message' => [$e->getMessage()]];
            }   
          
        }
    }
    
}
