<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EmailTemplate as EmailTemplate;

class SignupMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    //public $site_url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$url)
    {
        
        $this->user=$user;
        $this->url = $url;
    }

    /**
     *Build the message.url('/')
     *user_role = 1 for admin 2 for donar and 3 for students
     * @return $this
     */
    public function build()
    {        
        $template_obj=EmailTemplate::where('slug','user-registration')->first();
        if($template_obj) {           
                $search=explode(",", $template_obj->replace_vars);
                $url = $this->url;            
                $fname =$this->user->first_name;
                $lnam = $this->user->last_name;
                $email = $this->user->email;
                $full_name = $fname.' '.$lnam; 
                $replace = [$full_name,$url];
                $template_html=str_replace($search, $replace, $template_obj->body);
                return $this->subject($template_obj->subject)->view('emails.common',['html_body'=>$template_html,'email' => $email,'name' => $full_name]);
                
        }
    }
}
