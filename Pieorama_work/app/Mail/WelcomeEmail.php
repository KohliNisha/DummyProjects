<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EmailTemplate as EmailTemplate;


class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;
    //public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_check,$message)
    {
         $this->user=$user_check;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data=EmailTemplate::where('slug','welcome-email')->first();
        if ($data) {
            $replace_array=explode(',', $data->replace_vars);
            
            $message = $this->message;            
                $fname =$this->user->first_name;
                $lnam = $this->user->last_name;
                $email = $this->user->email;
                $full_name = $fname.' '.$lnam; 
                $replace = [$full_name,$message];
                $email_html=str_replace($replace_array, $replace, $data->body);
                //print_r($email_html); die;
                return $this->subject($data->subject)->view('emails.common',['html_body'=>$email_html, 'email' => $email,'name' => $full_name]);
        }

        
    }
}
