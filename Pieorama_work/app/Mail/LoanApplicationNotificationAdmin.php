<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EmailTemplate as EmailTemplate;

class LoanApplicationNotificationAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($FullName,$email, $user_id, $applied_for, $ammount, $loan_id)
    {
        $this->name=$FullName;
        $this->email=$email;
        $this->user_id=$user_id;
        $this->applied_for=$applied_for;
        $this->ammount=$ammount;
        $this->loan_id=$loan_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
              
        $template_obj=EmailTemplate::where('slug','loan-application-notification-to-admin')->first();
        if($template_obj) {           
                $search=explode(",", $template_obj->replace_vars);
                $replace = [$this->name,$this->email,$this->user_id,$this->applied_for,$this->ammount,$this->loan_id];
                $template_html=str_replace($search, $replace, $template_obj->body);
                return $this->subject($template_obj->subject)->view('emails.common',['html_body'=>$template_html]);
                
        }
    }
}
