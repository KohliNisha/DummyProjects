<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieVideoStatusLog extends Model
{
    protected $table="sc_pie_video_status_log";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video_id', 'status_id', 'created_by'
    ];
}
