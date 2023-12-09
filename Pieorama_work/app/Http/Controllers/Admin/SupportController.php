<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Exception;
use Validator;
use App\Models\User;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SupportController extends Controller
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

    public function SupportList(){  
        if (!Auth::guard('admin')->check()) {
            return redirect()->route("admin.login");
        }       
        return view('Admin.support.SupportList');
    }





}
