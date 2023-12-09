<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tvscreening extends Model
{
    protected $table="tv_screening";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'title',  'file_name', 'thumbnail', 'notes', 'updated_by', 'is_delete','status'
    ];

    public function tvscreeningvideoCreatedBy(){
        return $this->hasOne('App\Models\User', 'id', 'updated_by');
    } 

}
