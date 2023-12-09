<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

    class PieVideoComment extends Model
    {
    protected $table="sc_pie_video_comment";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video_id', 'video_file_path','comment_text','commentd_by_username','comment_by', 'created_by', 'parent_id', 'is_deleted', 'deleted_at'
    ];

    public function getprofile_image()
    {
         return $this->hasOne('App\Models\User', 'id', 'comment_by');
    }
}
