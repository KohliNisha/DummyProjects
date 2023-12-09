<?php

namespace App\Mail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EmailTemplate as EmailTemplate;
class Forgotpassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template_obj=EmailTemplate::where('slug','reset-password-api')->first();
        if($template_obj) {
            $search=explode(",", $template_obj->replace_vars);
            $fname =$this->user['first_name'];
            $lnam = $this->user['last_name'];
            $email = $this->user['email'];
            $full_name = $fname.' '.$lnam;
            $otp = $this->user['otp'];
            $replace = [$full_name,$otp];
            $template_html=str_replace($search, $replace, $template_obj->body);
           return $this->subject($template_obj->subject)->view('emails.common',['html_body'=>$template_html,'email' => $email,'name' => $full_name]);
        }
    }
}
