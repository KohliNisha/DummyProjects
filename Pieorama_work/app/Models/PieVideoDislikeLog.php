<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieVideoDislikeLog extends Model
{
    protected $table="sc_pie_video_dislike_log";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video_id', 'disliked_by'
    ];
}
