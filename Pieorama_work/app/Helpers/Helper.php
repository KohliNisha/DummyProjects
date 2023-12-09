<?php

namespace App\Helpers;
use App\Models\User;
use App\Models\Notification;
use App\Models\UserSettings;
use App\Models\PieVideoComment;
use App\Models\PieChannel;  
use App\Models\pieableMomentUses;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use Twilio\Exceptions\RestException;

use Illuminate\Support\Facades\DB;

trait Helper

{
    
    public static function sendSms($to, $message)
    {      

        $accountSid = config('constants.ACCOUNT_SID'); 
        $authToken = config('constants.AUTH_TOKEN');   
        $twilioNumber = config('constants.TWILLO_NUMBER');
        $client = new Client($accountSid, $authToken);
        try {
            $client->messages->create(
                $to,
                [
                    "body" => $message,
                    "from" => $twilioNumber
                    //   On US phone numbers, you could send an image as well!
                    //  'mediaUrl' => $imageUrl
                ]
            );
            return true;
        } catch (RestException $e) {
             $error_code =  $e->getCode();
             $str =  $e->getMessage();
             $messageeee= str_replace("[HTTP 400] Unable to create record: ","",$str); 
             return ['status'=>0, 'message' => 'Invalid mobile number.','message'=>$messageeee];
           
        }
    }


  


    /**
    * Method for uploading the image
    *
    * @param $file
    * @return string
    */
    protected function uploadFile($file, $path)
    {
        try {
            if ($file == null) {
                return '';
            }

            if (!file_exists(public_path(). '/' .$path)) {
                mkdir(public_path(). '/' . $path, 0777, true);
            }

            $originalName = $file->getClientOriginalName();

            $fileName = time() . rand(100, 1000) . $originalName;

            $file->move($path, $fileName);

            return trim($path, '/') . '/' . $fileName;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
    * Method for save thumbnail image
    *
    * @param $base64
    * @return file name
    */
    protected function saveThumbnail($base64, $path)
    {
        try {
            $fileName = $path.'/'.$this->generatePIN(10).'.png';

            if (!file_exists(public_path(). '/' .$path)) {
                mkdir(public_path(). '/' . $path, 0777, true);
            }

            list($type, $data) = explode(';', $base64);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);

            file_put_contents($fileName, $data);

            return $fileName;
        } catch (\Exception $e) {
            dd($e);
        }
    }

    /**
    * Method for generate unique pin
    *
    * @param $digits
    * @return pin
    */
    public function generatePIN($digits = 4)
    {
        $i = 0; //counter
        $pin = ""; //our default pin is blank.
        while ($i < $digits) {
            //generate a random number between 0 and 9.
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }




    /**
    * Method for get user details
    *
    * @param $userId
    * @return User details
    */
    public static function UserDetails($userId)
    {
       try {  
       $details ="";   
        $UserExist = User::where('id', $userId)->first();
            if(!empty($UserExist)){
                return $UserExist;
                        
            }else{
                return $details ;
            }

         } catch (\Exception $e) {
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }



    /**
    * Method for get user details
    *
    * @param $userId
    * @return User details
    */
    public static function usedpieableUser($Id)
    {
       try {  
       $details ="";   
        $UserExist = pieableMomentUses::where('pieable_id', $Id)->get();
            if(!empty($UserExist)){
                return count($UserExist);
                        
            }else{
                return "0" ;
            }

         } catch (\Exception $e) {
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }




    /**
    * Method for send push notification
    *
    * @param $userId
    * @return User details
    */
    public static function createNotification($data)
    {
     try {
        if($data['message_id'] !=""){
        //  print_r($data); die;
           $data['message'] = "";
           if($data['message_id']==1){ // for loan apply
                   $requested_loan_amount = $data['requested_loan_amount']; 
                   $loan_name = $data['loan_name']; 
                   $loan_id = $data['loan_id'];  
                   $data['message'] = 'We have received your loan application of GHC '.$requested_loan_amount.' for '.$loan_name.'. Your loan reference number is '.$loan_id.'.';                  
            } 

           if($data['message_id']==2){ // for loan approved
                   $requested_loan_amount = $data['requested_loan_amount']; 
                   $loan_name = $data['loan_name']; 
                   $loan_id = $data['loan_id'];  
                   $data['message'] = 'Your loan application of GHC '.$requested_loan_amount.' with loan reference number '.$loan_id.' for '.$loan_name.' has been approved. Please log in and accept loan terms & conditions.';                  
            } 

            if($data['message_id']==3){ // for loan disapproved
                   $requested_loan_amount = $data['requested_loan_amount']; 
                   $loan_name = $data['loan_name']; 
                   $loan_id = $data['loan_id'];  
                   $data['message'] = 'Sorry, Your loan application of GHC '.$requested_loan_amount.' for "'.$loan_name.'". Your loan reference number is '.$loan_id.' has been disapproved by the administrator.';                  
            } 

             if($data['message_id']==4){ // for loan approved
                   $requested_loan_amount = $data['requested_loan_amount']; 
                   $loan_name = $data['loan_name']; 
                   $loan_id = $data['loan_id'];  
                   $data['message'] = 'Congratulations! Your loan application of GHC '.$requested_loan_amount.' with loan reference number '.$loan_id.' for '.$loan_name.' has been credited to your account.';                  
            }

            if($data['message_id']==5){ // for loan EMI payment transaction status
                   $requested_loan_amount = $data['requested_loan_amount']; 
                   $loan_name = $data['loan_name']; 
                   $loan_id = $data['loan_id']; 
                   $data['message'] = $data['transaction_message'];                  
            } 

            if($data['message_id']==6){ // Promotional amount redeemd from user notification
                   $data['message'] = $data['message_data'];                  
            }

            if($data['message_id']==7){ // BROADCAST NOTIFICATION SEND BY THE ADMIN to user notification
                   $data['message'] = $data['message_data']; 
            } 

            if($data['message_id']==8){ // Support NOTIFICATION SEND BY THE ADMIN to user notification
                   $data['message'] = $data['message_data']; 
            } 

            if($data['message_id']==9){ // birthday push notification
                   $data['message'] = "Wishing you a day filled with happiness and a year filled with joy. Happy birthday!"; 
            } 
            if($data['message_id']==10){ // payment due push notification
                   $data['message'] = $data['message_data']; 
                  
            } 
            
             $result=Helper::sendPushNotification($data);  

          }
         } catch (\Exception $e) {
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }

   

    /**
    * Method for send push notification
    *
    * @param $data
    * @return 
    */
    public static function sendPushNotification($data)
    {
     try {        
          $UserExist = User::where('id', $data['recipient_id'])->where('is_deleted', 0)->first();
            if(!empty($UserExist)){
             
                   $UserSettings = UserSettings::where('user_id', $data['recipient_id'])->first();
                   $dataNotification = new Notification;
                   $dataNotification->sender_id = $data['sender_id'];
                   $dataNotification->recipient_id = $data['recipient_id'];
                   $dataNotification->message_id = $data['message_id'];
                   $dataNotification->entity_id = $data['message_id'];
                   $dataNotification->message = $data['message'];
                   $dataNotification->type = $data['type'];
                   $dataNotification->save();
                  // For Android Push notification.
                   $totalBadgeCount = Notification::where('is_read',0)->where('recipient_id', $data['recipient_id'])->count();                 


               if($data['message_id'] == 7){  // Broadcast message
                  Helper::sendPushNotificationDevice($UserExist->device_token,$data['message'],$data['type'],$totalBadgeCount); 
               } else if($data['message_id'] == 8){  // support message
                  if(empty($UserSettings) || $UserSettings->support_notification ==1){
                    Helper::sendPushNotificationDevice($UserExist->device_token,$data['message'],$data['type'],$totalBadgeCount);
                  } 
               } else if($data['message_id'] == 9){  // birthday message
                  if(empty($UserSettings) || $UserSettings->personal_notification ==1){
                    Helper::sendPushNotificationDevice($UserExist->device_token,$data['message'],$data['type'],$totalBadgeCount);
                  } 
               } else if($data['message_id'] == 10){  // due date message
                  if(empty($UserSettings) || $UserSettings->due_date_notification ==1){
                    Helper::sendPushNotificationDevice($UserExist->device_token,$data['message'],$data['type'],$totalBadgeCount);
                  } 
               } else {
               if($UserExist->device_token !="" && $data['send_push']==1){ 
                   if(empty($UserSettings) || $UserSettings->loan_notification ==1){ 
                       Helper::sendPushNotificationDevice($UserExist->device_token,$data['message'],$data['type'],$totalBadgeCount);                    
                       }
                   }
                }

          

           }

         } catch (\Exception $e) {
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }



     /**
    * Method for send Android push notification
    *
    * @param $data
    * @return 
    */
    public static function sendPushNotificationDevice($device_token,$message="",$type="notification",$totalBadgeCount=0,$message_type=0,$title="",$subtitle="",$tickerText="",$vibrate=1,$sound=1,$largeIcon="",$smallIcon="")
    {
     try { 
            $registrationIds=array(); 
            $registrationIds[] = $device_token;            
            $url = "https://fcm.googleapis.com/fcm/send";
            $token = $device_token;  //token here 
            $serverKey = config('constants.PUSH_NOTIFICATION_FCM_KEY');
            $title = "Plendify";
            $body = $message;
            $notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' => $totalBadgeCount);
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $headers = array();
            $headers[] = 'Content-Type: application/json';
            $headers[] = 'Authorization: key='. $serverKey;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,
            "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true );   // Response hide by this line
            //Send the request
            $response = curl_exec($ch);
            //print_r($response); die;
        
            //Close request
            if ($response === FALSE) {
             // die('FCM Send Error: ' . curl_error($ch));
            }
            curl_close($ch);     
            return ['status'=> 1, 'data' =>$response];     
       
         } catch (\Exception $e) {
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }





    /**
    * Method for get new access token
    *
    * @param $user_id
    * @return $outh_token
    */
    public static function updateUserToken($user_id=1)
    {
       try {
         $token=base64_encode($user_id).'_'.md5(rand());
         return $token;
        } catch (\Exception $e) {
            return ['status'=> 0, 'message' => [$e->getMessage()]];
        }
    }


    /**
    * Method for add dots into the string
    *
    * @param $string
    * @param $limit
    * @return string with dots
    */
    public static function add3dots($string, $limit)
    {
        try {
            if(strlen($string) > $limit) {
                return substr($string, 0, $limit) . '...'; 
            } else {
                return $string;
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }


    public static function getusers()
    {
        $result = Auth::guard('admin')->User();
        return $result;

    }

    public static function html_filterd_data($string){ 
            if(is_array($string)){
               $ret= Helper::htmlspecialchars_array_modify($string);
            }elseif(is_object($string)){
                    $string=(array)   $string;
                    $ret= Helper::htmlspecialchars_array_modify($string);
                    $ret=(object) $ret;
                    
            }else{
             $ret= Helper::cleanhtml($string);                
            }
          return $ret;
     }

     public static function htmlspecialchars_array_modify (&$arr){
            array_walk_recursive($arr,function(&$value){
            $value=html_entity_decode($value);
            $value=htmlspecialchars_decode($value,ENT_QUOTES);
        });
        return $arr;
    }

    public static function cleanhtml($dirtyhtml) {
        $dirtyhtml=trim($dirtyhtml);
        $dirtyhtml=html_entity_decode($dirtyhtml);
        $dirtyhtml=htmlspecialchars_decode($dirtyhtml,ENT_QUOTES);
       
        //$dirtyhtml=htmlentities($dirtyhtml);
     return $dirtyhtml;      
  }



    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        // trim
        $text = trim($text, '-');
        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }




     public static function formatSizeUnits($bytes)
      {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 byte';
        }

        return $bytes;
     }

    public static function badgedata($userid = ''){
         $usersdata = User::where('status',1)
                      ->where('is_confirm',1)
                      ->where('is_deleted',0)
                      ->take(10000)
                      ->pluck('id')->toArray();
                     
                      
      if(in_array($userid, $usersdata)) {
        $id_exist = 1;
      } else{
        $id_exist = 0;
      } 

    return $id_exist;
    }
	

	

}
