<?php

namespace App\Mail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EmailTemplate as EmailTemplate;
class ForgetPasswordOfAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $url)
    {
        $this->user = $user;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template_obj=EmailTemplate::where('slug','forgot-password-for-admin')->first();
        if($template_obj) {
            $search=explode(",", $template_obj->replace_vars);
            $fname =$this->user['first_name'];
            $lnam = $this->user['last_name'];
            $full_name = $fname.' '.$lnam; 
            $replace = [$full_name,$this->url];
            $template_html=str_replace($search, $replace, $template_obj->body);
           return $this->subject($template_obj->subject)->view('emails.common',['html_body'=>$template_html]);
        }
    }
}
