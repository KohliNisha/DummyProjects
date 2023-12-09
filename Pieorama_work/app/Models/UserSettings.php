<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSettings extends Model
{
    protected $table="user_settings";

    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                 'user_id', 'due_date_notification', 'loan_notification','personal_notification','email_notification','support_notification'
    ];

}
