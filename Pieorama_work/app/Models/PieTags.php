<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieTags extends Model
{
    protected $table="sc_pie_tags";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video_id', 'tag_text', 'is_deleted', 'deleted_at', 'created_by'
    ];
}
