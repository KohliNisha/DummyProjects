<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieVideoSearchLog extends Model
{
    protected $table="sc_pie_video_search_log";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'search_keyword', 'search_by', 'search_at'
    ];
}
