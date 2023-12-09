<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieChannel extends Model
{
    protected $table="sc_pie_channel";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'channel_title', 'tags_id', 'channel_description', 'comment_note', 'channel_logo_img', 'created_by', 'updated_by'
        , 'is_deleted', 'status', 'deleted_at'
    ];
}
