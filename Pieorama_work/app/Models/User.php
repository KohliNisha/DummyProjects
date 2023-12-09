<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Emails\SupplierResetPassword;
use App\Models\Emails\UserResetPassword;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
    //protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password','password_reset_token','auth_token','user_role','signup_source','date_of_birth','source_id','facebook_id','google_id','twitter_id','linkedin_id','instagram_id','first_name','last_name','phone_code','phone_number','device_token','device_type','last_login','attempt','profile_image','signupstep','status','otp','is_phone_verify','is_deleted' ,'last_time_used','newsletter','welcome_message'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password','auth_token', 'remember_token','password_reset_token',
    ];


    public function getdob(){
        return $this->hasOne('App\Models\LoanDocuments', 'user_id', 'id');
    }
   
}
