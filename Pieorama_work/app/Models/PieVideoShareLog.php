<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieVideoShareLog extends Model
{
    protected $table="sc_pie_video_share_log";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video_id', 'shared_by', 'shared_platform', 'shared_at'
    ];
}
