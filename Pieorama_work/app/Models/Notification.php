<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table="notifications";

    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sender_id', 'recipient_id', 'entity_id','url','type','is_read','is_read_on_click','is_read_admin','status','message','updated_at'
    ];

    public function userdetals()
    {
      return $this->hasMany('App\Models\User', 'id', 'recipient_id');
    }
}
