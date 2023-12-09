<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SoundAlert extends Model
{
    protected $table="sound_alert";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        's_name', 's_url', 'type', 'status'
    ];

   

    public function SoundAlertCreatedBy(){
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    } 
}
