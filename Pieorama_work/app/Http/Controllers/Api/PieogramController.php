<?php
namespace App\Http\Controllers\Api;
use App\Models\Library;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PieChannel;
use App\Models\PieVideoComment;
use App\Models\PieTags;
use App\Models\PieWatchedLog;
use App\Models\PieFlavor;
use App\Models\PieVideoShareLog;
use App\Models\UserVerification;
use VideoThumbnail;
use App\Models\AudienceReactions;
use App\Models\PieVideoLikeDislike;
use App\Models\SoundAlert;
use App\Models\PieVideo;
use App\Models\ChromaKeys;
use App\Models\HomepageVideo;
use App\Models\Tvscreening;
//use App\Models\PieTags;
use App\Mail\SignupMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Validator;
use Session;
use Auth;
use App\Helpers\Helper as Helper;

class PieogramController extends Controller
{
    

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
     public function pieogramUpload(Request $request)
      {
        //dd($request->all());
        try {
          if($request->isMethod('post'))
             {
               $validator=Validator::make($request->all(),[
                'user_id'=> 'required',
                'video_title'=>'required',
                'video_description'=>'required',
                'video_file_path' => 'required',
                //'video_thumbnail_file_path' => 'required',
                //'video_animated_file_path' => 'required',
                //'pie_channel_id'=>'required',
                //'sourceUrl' => 'required',
                //'public_available' => 'required',   //0 or 1
                'tags' => 'required',
              ]);
              if($validator->fails()) {
                  return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
               }


     

                 /* if($request->hasFile('video_file_path')){
                      // dd('request');
                      $videofile = $request->file('video_file_path');
                      
                      $videofile_name = $videofile->getClientOriginalName();
                     


                      $video_path = public_path().'/uploads/';
                     
                      $uploadvideo = $videofile->move($video_path, $videofile_name);
                     

   

                    }


                    if($request->hasFile('video_thumbnail_file_path')){

                      $thumbnailFile = $request->file('video_thumbnail_file_path');
                     
                      $thumbnailFile_name = $thumbnailFile->getClientOriginalName();
                     
                      $thumbnail_path = public_path().'/uploads';
                     
                      $thumbnail = $thumbnailFile->move($thumbnail_path, $thumbnailFile_name);
                    }else{
                      $thumbnailFile_name = '';
                    }
                     if($request->hasFile('sourceUrl')){
                      // dd('request');
                      $original_video = $request->file('sourceUrl');
                      $original_video_name = $original_video->getClientOriginalName();
                      $original_video_path = public_path().'/originalVideo/';
                      
                      $originalvideo = $original_video->move($original_video_path, $original_video_name);
                      

                    }else{
                      $original_video_name = '';
                    }*/

                    if($request->hasfile('video_file_path')){ 
                          $extension =  $request->file('video_file_path')->extension();
                          $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('video_file_path'), time().rand().'.'.$extension, 'public');
                          $filename = config('constants.DO_STORAGE_URL').$path; 
                      } 
                     if($request->hasfile('sourceUrl')){
                          $extension =  $request->file('sourceUrl')->extension();
                          $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('sourceUrl'), time().rand().'.'.$extension, 'public');
                          $original_video_name = config('constants.DO_STORAGE_URL').$path;  
                     }
                     if($request->hasfile('video_thumbnail_file_path')){
                           $extension =  $request->file('video_thumbnail_file_path')->extension();
                           $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('video_thumbnail_file_path'), time().rand().'.'.$extension, 'public');
                           $thumb_filename = config('constants.DO_STORAGE_URL').$path;    
                      }
                       if($request->hasfile('video_animated_file_path')){
                           $extension =  $request->file('video_animated_file_path')->extension();
                           $path = Storage::disk('do_spaces')->putFileAs("uploads", $request->file('video_animated_file_path'), time().rand().'.'.$extension, 'public');
                           $animatedfile_name = config('constants.DO_STORAGE_URL').$path;    
                      }
                    
                   /* if($request->hasFile('video_animated_file_path')){

                        $animatedfile = $request->file('video_animated_file_path');
                        $animatedfile_name = $animatedfile->getClientOriginalName();
                        $animated_path = public_path().'/animatedfile/';
                        $animated  = $animatedfile->move($animated_path, $animatedfile_name);
                    }else{
                        $animatedfile_name = '';
                    }*/

                        $PieVideo = new PieVideo();
                        $PieVideo->created_by =  $request->user_id;
                        $PieVideo->updated_by =  $request->user_id;
                        $PieVideo->video_title =  $request->video_title;
                        $PieVideo->video_description =  $request->video_description;
                        $PieVideo->video_file_path =  $filename??'';
                        $PieVideo->original_video_path =  $original_video_name??'';
                        $PieVideo->video_thumbnail_file_path =  $thumb_filename??'';
                        $PieVideo->video_animated_file_path =  $animatedfile_name??'';
                        //$PieVideo->pie_channel_id =  $request->pie_channel_id;
                        $PieVideo->public_available = 0;
                        $PieVideo->is_publish = 0;
                        if($request->public_available == 1){
                         $PieVideo->publish_date = now();
                        }
                        $PieVideo->access_scope =  1;
                        $PieVideo->searchable =  1;
                        $PieVideo->status =  1;
                        $PieVideo->save();
                        if($PieVideo){
                              $pieogramId= $PieVideo->id;
                              if($request->tags){
                                $tagsArray = explode(' ', $request->tags);
                                foreach ($tagsArray as $key => $tagValue) {
                                    $hashVal =   str_replace("#","",$tagValue);
                                $PieTags = new PieTags();
                                $PieTags->video_id =  $pieogramId;
                                $PieTags->tag_text =  $hashVal;
                                $PieTags->is_deleted =  0;
                                $PieTags->created_by = $request->user_id;
                                $PieTags->save();
                              }
                          }

                   
                         $array = ['pieogramUrl' => $PieVideo->video_file_path, 'pieogram_id' => $PieVideo->id, 'picogram_title' => $PieVideo->video_title];

                        return ['status'=> 1, 'message' => "Pieogram uploaded successfully.", 'ResponseData' => $array];
                        }
                      else {
                            return ['status'=> 0, 'message' => "Somthing went wrong."];
                      }

             } else {
                      return ['status'=> 0, 'message' => "Method is not post type"];
           }

          } catch (\Exception $e) {
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }

    /*public function pie_flavor(Request $request){

          $data = $request->all();

          try{

            if($request->isMethod('post')){
                $validator=Validator::make($request->all(),[
                  'p_name'=> 'required',
                  'p_img' => 'required',
                  'user_id' => 'required',
               ]);
                if($validator->fails()) {
                    return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
                }

                 if($request->hasFile('p_img')){

                      $p_image = $request->file('p_img');
                      $p_image_name = $p_image->getClientOriginalName();
                      $p_image_path = public_path().'/pieflavor/';
                      $imageupload  = $p_image->move($p_image_path, $p_image_name);
                  }else{
                    $p_image_name = '';
                  }


                $PieFlavor = new PieFlavor();
                $PieFlavor->created_by = $data['user_id'];
                $PieFlavor->p_name = $data['p_name'];
                $PieFlavor->chroma_key_id = $data['chroma_key_id']??1;
                $PieFlavor->p_img = $p_image_name;
                $PieFlavor->type = 1;
                $PieFlavor->status =  1;
                $PieFlavor->save();
                  if($PieFlavor){
                    return ['status'=> 1, 'message' => "Pie Flavor Added successfully."];
                      }
                   else {

                        return ['status'=> 0, 'message' => "Somthing went wrong."];
                    }

            }
        }
        catch (\Exception $e) {
          return ['status'=> 0, 'message' => [$e->getMessage()]];
      }
    }

*/

 /* get pie flavor and chromakeys Images data by Input user Id*/


  public function getpieflavor(Request $request){

      $data = $request->all();

        if(!$request->user_id)
          {
            return ["Error" => ['Status' => 0, 'ErrorCode'=> 403, 'message' => "User Id field is required."]];
          }

          try{

            if($request->isMethod('post')){
             
                $flavorArr = PieFlavor::where('created_by','=',$data['user_id'])
                            ->where('status','=',1)
                            ->where('is_deleted','=',0)
                            ->select('id','p_name as name','p_img as img','portrait_img as portrait_gif','landscape_img as landscape_gif')
                            ->get();
                
                           
                  $count = $flavorArr->count();

                  if($count > 0){
                    return response()->json(["status" => 1,"message" =>"Success","ResponseData" => ["flavorArr" => $flavorArr]]);
                      }
                   else {

                       return ["Status" => 0, 'message' => "No record found."];
                    }

            }
        }
        catch (\Exception $e) {
          return ['status'=> 0, 'message' => [$e->getMessage()]];
      }
    }


  public function chromakeys(Request $request){

      $data = $request->all();

         if(!$request->pieflavor_id)
          {

            return ["Error" => ['Status' => 0, 'ErrorCode'=> 403, 'message' => "pieflavor Id field is required."]];
          }
          try{

            if($request->isMethod('post')){
              $is_landscape = $request->is_landscape;
              $flavorArr1 = ChromaKeys::where('pieflavor_id','=',$data['pieflavor_id'])
                              ->where('status','=',1)
                              ->where('is_deleted','=',0)
                              ->orderBy('sort_by','ASC')
                              ->select('chromak_keys_img as img','name');
                              

               if(!empty($is_landscape)){
               
                  $flavorArr = $flavorArr1->where('chroma_key_id',$is_landscape)
                                  //  ->orderBy('sort_landscape_img','ASC')
                                    ->get();
                  

                 
                // dd($flavorArr);
               }else{
                
                 $flavorArr = $flavorArr1->orderBy('id','ASC')
                              ->get();
                }

               foreach ($flavorArr as $key => $f) {
                     // $title = explode('.', $f->img);
                      $f->img = $f->img;
                      
                     // $f->title = $title[0];
                      //$f->title = 
                          }             
                 $count = $flavorArr->count();
                  if($count > 0){

                    return response()->json(["status" => 1,"message" =>"Success", "ResponseData" => ["Chromakeys" => $flavorArr]]);
                      }
                   else {

                        return ["Status" => 0, 'message' => "No record found."];
                    }

            }
        }  

        catch (\Exception $e) {
          return ['status'=> 0, 'message' => [$e->getMessage()]];
      }
    }


    /* Get Audience Reactions and trending tags list by taking input User Id from User*/
    /* type = 1 for audience reactions and type= 2 for trending tags */


    public function AudienceReactions(Request $request){

      $data = $request->all();
        //dd($data);
        if(!$request->user_id)
            {
              return ["Error" => ['Status' => 0, "ErrorCode" => 403, "message" => "User Id field is required."]];

            }elseif(!$request->type){

                return ["Error" => ['Status' => 0, "ErrorCode" => 403, "message" => "type field is required."]];
            }

            try{

              if($request->isMethod('post')){
                if($data['type'] == 1){



                if(!empty($data['is_landscape'])){
                  $audienceReactionArr = AudienceReactions::where('created_by','=',$data['user_id'])
                                        ->where('status','=',1)
                                        ->where('type','=',1)
                                        ->where('shape_id',$data['is_landscape'])
                                        ->where('is_deleted','=',0)
                                        ->select('name','id','url','shape_id')
                                        ->get();
                  }else{
                   $audienceReactionArr = AudienceReactions::where('created_by','=',$data['user_id'])
                                        ->where('status','=',1)
                                        ->where('type','=',1)
                                        ->where('is_deleted','=',0)
                                        ->select('name','id','url','shape_id')
                                        ->get();
                    }
                                      
                  $count = $audienceReactionArr->count();
                   if($count > 0){

                      return response()->json(["status" => 1,"message" =>"Success", "ResponseData" => ["audienceReactionArr" => $audienceReactionArr]]);
                    }

                   else {

                        return ["Status" => 0, 'message' => "No record found."];                  }

                  }else{

                     //$searchtxt = $data['search'];
                      $trendingArr = AudienceReactions::where('created_by','=',$data['user_id'])
                                          ->where('status','=',1)
                                          ->where('type','=',2)
                                          ->where('is_deleted','=',0)
                                          ->select('name','id')->get();
                       
                       if(!empty($data['search'])){
                        $trendingArr = AudienceReactions::where('status','=',1)
                                    
                                                        ->where( 'name', 'LIKE', '%'. $request->search .'%')
                                                        ->where('type',2)
                                                        ->where('is_deleted',0)
                                                        ->select('name','id')->get();

                     $count = $trendingArr->count();
                    if($count > 0){

                      return response()->json(["status" => 1,"message" =>"Success", "ResponseData" => ["trendingArr" => $trendingArr]]);
                    }
                    else {
                          $trending = new AudienceReactions();
                          $trending->name = $data['search'];
                          $trending->type = 2;
                          $trending->status = 1;
                          $trending->created_by = $data['user_id'];
                          $trending->is_deleted = 0;
                           if($trending->save()) {
                              $trendingArr = ['id' => $trending->id, 'name' => $trending->name];
                           } 
                          return response()->json(["status" => 1,"message" =>"Trending tag added successfully!! ", "ResponseData" => ["trendingArr" => $trendingArr]]);                  
                        
                       }
                        //return ["Error" => ['ErrorCode'=> 404, 'message' => "No record found."]];
                    }
                     return response()->json(["status" => 1,"message" =>"success ", "ResponseData" => ["trendingArr" => $trendingArr]]);

                  }
              }
          }
        catch (\Exception $e) {
          return ['status'=> 0, 'message' => [$e->getMessage()]];
      }
    }



 /* getting sound alert by getting user Id */
public function soundalert(Request $request){

      $data = $request->all();

         if(!$request->user_id)
            {
              return ["Error" => ['Status' => 0, "ErrorCode" => 403, "message" => "User Id field is required."]];

            }

          try{

            if($request->isMethod('post')){
                  $Sounds = Library::with('usedlibrary')->where('file_type',2)
                                ->where('status','=',0)
                                ->where('type','=',1)
                                ->where('is_delete',0); 
                  $othersound = Library::with('usedlibrary')->where('file_type',2)
                                ->where('status','=',0)
                                ->where('type','=',2)
                                ->where('is_delete',0);             

                 
                $usersCountArray = $Sounds->get();
                $usersCountArray1 = $othersound->get();
                //dd($usersCountArray);
                $users = $Sounds->get()->toArray();
                $users1 = $othersound->get()->toArray();
                $user_data=array();
                $user_data1=array();
                if($users){
                    foreach ($users as $s){
                        $sd['id'] = $s['id'];
                        $sd['url'] = $s['file_name'];
                        $sd['name'] = $s['title'];
                        $sd['views'] = count($s['usedlibrary']);
                        array_push($user_data,$sd);
                    }
                }
                 if($users1){
                    foreach ($users1 as $s){
                        $sd['id'] = $s['id'];
                        $sd['url'] = $s['file_name'];
                        $sd['name'] = $s['title'];
                        $sd['views'] = count($s['usedlibrary']);
                        array_push($user_data1,$sd);
                    }
                }
              $data = Helper::html_filterd_data($user_data);
              $data1 = Helper::html_filterd_data($user_data1);
               
                $count = $Sounds->count();

                  if($count > 0){

                    return response()->json(["status" => 1,"message" =>"Success", "ResponseData" => ["Sounds" => $data, "Other_sound" => $data1]]);
                      }
                   else {

                        return ["Status" => 0, 'message' => "No record found."];
                    }

            }
          }

        catch (\Exception $e) {
          return ['status'=> 0, 'message' => [$e->getMessage()]];

    }
  }


    public function pieogramsDetails(Request $request) 
    {   
      try 
    {     
    if($request->isMethod('post'))   
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
      //dd($videoDetails);
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

   /* public function pieogramsDetails(Request $request){
        try{
           if($request->isMethod('post')){
               $data = $request->all();
               $validator = Validator::make($data, [
                    'video_id' => 'required',
               ]);
               if($validator->fails()) {
                return ['status'=>0,'message'=>$validator->errors($request[0])->first()];
            }
          $pieogramdetails = PieVideo::where('id', $data['video_id'])
                              ->where('is_deleted',0)
                              ->where('status',1)
                              ->get();
          $videoComment = PieVideoComment::with('getprofile_image')->where('parent_id',0)->where('video_id',$video_id)->get();
           $videoComments = PieVideoComment::where('video_id',$video_id)->get(); 
           $total_comment = $videoComments->count();

          if($pieogramdetails){
              return['status' => 1, 'message' => 'success', 'ResponseArr' => ['PieogramDetails' => $pieogramdetails]]; 
            }else{
               return['status' => 0, 'message' => 'No record found']; 
            }
          
           }else{
            return['status' =>   0, 'message' => 'Invalid method'];
           }
           

        }catch(\Exception $e){
            return ['status' => 0, 'message' => [$e->getMessage()]];
        }
    }*/

    function tvscreening(Request $request){
       $data = $request->all();
        
          try{

            if($request->isMethod('get')){
             
              $tvscreening = Tvscreening::where('id',1)
                              ->where('status',0)
                              ->where('is_delete',0)
                              ->select('file_name','updated_at as updated_date')
                              ->first();
                
                  if(isset($tvscreening)){
                    $tvscreening['updated_date'] = date('d-M-Y', strtotime($tvscreening['updated_date']));
                    return response()->json(["status" => 1,"message" =>"Success", "ResponseData" => ["tvscreening" => $tvscreening]]);
                      }
                   else {

                        return ["Status" => 0, 'message' => "No record found."];
                    }

            }
        }  

        catch (\Exception $e) {
          return ['status'=> 0, 'message' => [$e->getMessage()]];
      }
    }
    
}
