<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieVideo extends Model
{
    protected $table="sc_pie_video";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'video_title', 'comment_note', 'video_file_path', 'pie_audio_id', 'meta_description','meta_title','original_video_path','video_thumbnail_file_path', 'video_animated_file_path','small_gif', 'pie_channel_id', 'is_publish', 'access_scope', 'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'status', 'publish_date', 'video_description', 'profiled_pieogram', 'public_available', 'searchable'
    ];

    public function channelName(){
         return $this->hasOne('App\Models\PieChannel', 'id', 'pie_channel_id');
    }

    public function pieCreatedBy(){
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    } 

    public function pieTags(){
        return $this->hasMany('App\Models\PieVideoTags', 'video_id', 'id');
    }    

    public function pieComment(){
        return $this->hasMany('App\Models\PieVideoComment', 'video_id', 'id');
    }
    public function pieLikeDislikeLog(){
        return $this->hasMany('App\Models\PieVideoLikeDislike', 'video_id', 'id');
    }
    public function pieDislikeLog(){
        return $this->hasMany('App\Models\PieVideoDislikeLog', 'video_id', 'id');
    }
    public function pieLikeLog(){
        return $this->hasMany('App\Models\PieVideoLikeLog', 'video_id', 'id');
    }
    public function pieSearchLog(){
        return $this->hasMany('App\Models\PieVideoSearchLog', 'video_id', 'id');
    }
    public function pieShareLog(){
        return $this->hasMany('App\Models\PieVideoShareLog', 'video_id', 'id');
    }
    public function pieStatusLog(){
        return $this->hasMany('App\Models\PieVideoStatusLog', 'video_id', 'id');
    } 
 
   
}
