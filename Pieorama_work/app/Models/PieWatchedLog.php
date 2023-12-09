<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieWatchedLog extends Model
{
    protected $table="sc_pie_video_watch_log";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video_id', 'user_id', 'is_delete','ip_address'
    ];
}
