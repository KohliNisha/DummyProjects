<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeviceTokenLog extends Model
{
     protected $table="user_device_token_log";

    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'device_token', 'device_os', 'is_deleted','deleted_at','created_by','updated_by'
    ];
}
