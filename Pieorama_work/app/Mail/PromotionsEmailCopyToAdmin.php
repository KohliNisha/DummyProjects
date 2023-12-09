<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EmailTemplate as EmailTemplate;

class PromotionsEmailCopyToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$email_html)
    {

        $this->user=$user;
        $this->email_html=$email_html;
    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //{refrer_name},{refrer_phone},{refrer_user_id},{refrer_email},{email_list}

        $template_obj=EmailTemplate::where('slug','promotions-invited-emails')->first();
        if($template_obj) { 
                $fname =$this->user->first_name;
                $lnam = $this->user->last_name;
                $full_name = $fname.' '.$lnam; 
                $user_phone = $this->user->phone_code . '-'. $this->user->phone_number;
                $search=explode(",", $template_obj->replace_vars);                
                $replace = [$full_name,$user_phone,$this->user->id,$this->user->email,$this->email_html];

                $template_html=str_replace($search, $replace, $template_obj->body);
                $search_subject=explode(",", $template_obj->subject);
                $subject = $full_name .",". $search_subject[1];
              
               // print_r($template_html); die;
                return $this->subject($subject)->view('emails.common',['html_body'=>$template_html]);
                
        }
    }
}
