<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieVideoLikeLog extends Model
{
    protected $table="sc_pie_video_like_log";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video_id', 'liked_by'
    ];
}
