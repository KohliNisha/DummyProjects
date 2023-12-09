<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EmailTemplate as EmailTemplate;

class ContactUsSendToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
   /* public function __construct($contactDetails)
    {
        $this->first_name=$contactDetails->first_name;
       $this->last_name=$contactDetails->last_name;
        $this->email=$contactDetails->email;
        $this->phone_code=$contactDetails->phone_code;   
        $this->phone_number=$contactDetails->phone_number;
        $this->related_to=$contactDetails->related_to;
        $this->message=$contactDetails->message;         
        
    }*/
    public function __construct($ContactUs){
         $this->ContactUs=$ContactUs;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        $template_obj=EmailTemplate::where('slug','contact-us-admin')->first();
         if($template_obj) {           
                $search=explode(",", $template_obj->replace_vars);
                 //dd($this->ContactUs->first_name);          
                $fname =$this->ContactUs->first_name;
                $email =$this->ContactUs->email;
                $msg =$this->ContactUs->message;
                $replace = [$fname,$email,$msg];
                $template_html=str_replace($search, $replace, $template_obj->body);
               
                return $this->subject($template_obj->subject)->view('emails.common',['html_body'=>$template_html]);
                
        }
    }
}
