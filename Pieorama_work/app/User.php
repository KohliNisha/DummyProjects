<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'username','email','password','profile_image','dob','hide_dob','gender','remember_token','password_reset_token','device_token','device_type','access_token','auth_token','user_role','facebook_id','google_id','twitter_id','linkedin_id','instagram_id','phone_code','phone_number','otp','attempt','is_phone_verify','is_confirm','signupstep','status','last_login','last_time_used','is_deleted',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];






}
