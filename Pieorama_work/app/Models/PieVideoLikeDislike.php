<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieVideoLikeDislike extends Model
{
    protected $table="sc_pie_video_like_dislike";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video_id', 'user_id', 'like_status','dislike_status'
    ];
}
