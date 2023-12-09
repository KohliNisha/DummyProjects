<?php

namespace App\Http\Controllers\Site;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactUsController extends Controller
{

 /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */



    public function ContactUs(Request $request){   
     
         if($request->isMethod('post'))  
            {

            	print_r($request->isMethod('post'));
            	die;

            }

        }



 
}
