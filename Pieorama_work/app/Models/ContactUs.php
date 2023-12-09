<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
	protected $table="contact_us";

    public $timestamps =true;

     protected $fillable = [
        'first_name', 'last_name', 'email','phone_code','phone_number','subject','related_to','message','created_at','updated_at'
    ];


     protected $hidden = [
        'created_at','updated_at'
    ];


    
}
