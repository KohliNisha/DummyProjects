<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageVideo extends Model
{
    protected $table="homepage_video";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_type', 'title', 'comment_note', 'background_color', 'foreground_color', 'file_name', 'file_image', 'file_mime_type', 'file_size', 'updated_by', 'is_delete'
    ];

  
}
