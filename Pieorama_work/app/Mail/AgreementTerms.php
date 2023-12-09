<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\EmailTemplate as EmailTemplate;

class AgreementTerms extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
     public function __construct($loandata,$message)
    {
        
        $this->user=$loandata;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
     public function build()
    {
        $data=EmailTemplate::where('slug','loan-agreement-terms')->first();
        if ($data) {
            $replace_array=explode(',', $data->replace_vars);
            
                 $message = $this->message; 
                $id =$this->user->id;           
                $fname =$this->user->first_name;
                $lnam = $this->user->last_name;
                $full_name = $fname.' '.$lnam; 
                $replace = [$full_name,$message,$id];
                $email_html=str_replace($replace_array, $replace, $data->body);
                //print_r($email_html); die;
         
                $path = public_path('terms-and-condition.pdf');
                return $this->subject($data->subject)->view('emails.common',['html_body'=>$email_html])
                           ->attach($path, [
                                'as' => 'terms-and-condition.pdf',
                                'mime' => 'application/pdf',
                            ]);

        }
    }
}
