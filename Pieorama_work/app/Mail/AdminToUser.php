<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EmailTemplate as EmailTemplate;
use App\Models\ContactUs;

class AdminToUser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ContactUs $contact,$message)
    {
        $this->contact= $contact;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template_obj=EmailTemplate::where('slug','feedback')->first();
        
        if($template_obj) {           
                $search=explode(",", $template_obj->replace_vars);
                $fname =$this->contact->first_name;
                //$lnam = $this->contact->last_name;
                $full_name = $fname; 
                $replace = [$full_name,$this->message];
                $template_html=str_replace($search, $replace, $template_obj->body);
                return $this->subject($template_obj->subject)->view('emails.common',['html_body'=>$template_html]);
                
        }
    }
}
