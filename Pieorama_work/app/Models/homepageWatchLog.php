<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class homepageWatchLog extends Model
{
   protected $table="homepage_watch_log";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','user_Ip','video_id', 'is_delete'
    ];

}
