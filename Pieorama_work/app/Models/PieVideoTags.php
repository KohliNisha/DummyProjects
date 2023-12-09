<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieVideoTags extends Model
{
    protected $table="sc_pie_video_tags";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video_id', 'tag_id', 'created_by', 'is_deleted', 'deleted_at'
    ];
}
