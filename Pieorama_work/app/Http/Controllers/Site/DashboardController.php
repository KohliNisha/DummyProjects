<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;
use App\Models\Usernotification;
use App\Models\Userlocation;
use App\Mail\SignupMail;
use App\Mail\Forgotpassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\UsersignupController;
use Illuminate\Support\Facades\DB;
use Socialite;
use Exception;
use Helper;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
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

    public function dashboard(){    
         if (!Auth::user()) {
            return redirect('login');
        }
       
       return view('Site.dashboard',[]);
    }


}
