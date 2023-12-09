<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PiableMoments extends Model
{
    protected $table="pieable_moments";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_type', 'title', 'piable_description', 'comment_note', 'library_tags', 'file_name', 'video_thumbnail_file_path', 'original_video_path', 'file_mime_type', 'file_size', 'created_by', 'updated_by', 'status', 'is_delete'
    ];

    
}
