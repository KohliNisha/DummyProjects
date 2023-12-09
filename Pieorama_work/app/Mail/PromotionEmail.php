<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EmailTemplate as EmailTemplate;

class PromotionEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($refrername,$url)
    {
      
        $this->refrer_name=$refrername;
        $this->base_url=$url;
    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
         $template_obj=EmailTemplate::where('slug','promotions')->first();
        if($template_obj) { 

                $search=explode(",", $template_obj->replace_vars);
                $replace = [$this->refrer_name,$this->base_url];
                $template_html=str_replace($search, $replace, $template_obj->body);
                $search_subject=explode(",", $template_obj->subject);
                $subject = $this->refrer_name .",". $search_subject[1];
                return $this->subject($subject)->view('emails.common',['html_body'=>$template_html]);
                
        }
    }
}
