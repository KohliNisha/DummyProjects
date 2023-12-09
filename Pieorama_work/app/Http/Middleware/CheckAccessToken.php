<?php

namespace App\Http\Middleware;
use Validator;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\Encryption\Encrypter;
use App\Models\User;
use App\Models\Notification;
use Closure;

class CheckAccessToken
{


   /* protected $except = [
       'media-upload',
      ];*/

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if($request->path() == "api/media-upload"){ return $next($request);  } else {

        $xapikey = env('X_API_KEY','JGIp4AWFmI'); 
        $XapiKeyHeader = $request->header('X-API-KEY'); 
         if($xapikey != $XapiKeyHeader){
            return response()->json(["status" => 500, "message"=>'Please provide a valid x api key']); 
        }

             if($request->header('OAUTH-TOKEN') != '' && $request->header('USER-ID') != ''){    

                $oauthToken = $request->header('OAUTH-TOKEN');
                $user_id = $request->header('USER-ID');
                $user =User::where('id',$user_id)
                       ->first();       
                if($user->status == 0){
                    return response()->json(["status" => 501, "message"=>'Your account is not activated. Please contact support@pieorama.com we are happy to help you.']); 
                }
                if($user->is_deleted == 1){
                    return response()->json(["status" => 502, "message"=>'Your account has been deleted by admin.  Please contact support@pieorama.com we are happy to help you.']); 
                }
                if($user->access_token != $oauthToken){
                    return response()->json(["status" => 503, "message"=>'Account can use only in one application and Your account has login in another device. If you have not loged in then change your password immediately']); 
                }
                
              /*  if($user->last_time_used == ""){
                     return response()->json(["status" => 503, "message"=>'For your protection, your session expired due to a lack of activity.']); 
                } */ 
                $last_time = strtotime($user->last_time_used);
                $current_time = now();
                $current_time  = strtotime($current_time);
                $difference_minutes = abs($current_time - $last_time) / 60;
                /*if($difference_minutes > 5){
                    return response()->json(["status" => 503, "message"=>'For your protection, your session expired due to a lack of activity.']); 
                }*/

                User::where('id',$user_id)->update(['last_time_used'=>now()]);
                Notification::where('recipient_id',$user_id)->update(['is_read'=>1]);

             }

        return $next($request);

    }
    }


    
}
