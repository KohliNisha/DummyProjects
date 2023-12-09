<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EmailTemplate as EmailTemplate;

class SubscribeMail extends Mailable
{
    use Queueable, SerializesModels;
    //public $user;
    //public $site_url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($users,$subject,$message)
    {
        
        $this->users=$users;
        $this->subject=$subject;
        $this->message=$message;
       // $this->url = $url;
    }

    /**
     *Build the message.url('/')
     *user_role = 1 for admin 2 for donar and 3 for students
     * @return $this
     */
    public function build()
    {        
        $template_obj=EmailTemplate::where('slug','user-subscribe-email')->first();
        
        if($template_obj) {           
                $search=explode(",", $template_obj->replace_vars);
               // $url = $this->url;            
                $name =$this->users->name;
                $email =$this->users->email;
               
                $full_name = $name;
                $sub = $this->subject;
                $msg = $this->message;
                $replace = [$full_name,$msg];
                $template_html=str_replace($search, $replace, $template_obj->body);
                return $this->subject($sub)->view('emails.common',['html_body'=>$template_html,'email' => $email, 'name' => $name]);
                
        }
    }
}
