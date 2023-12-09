<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class welcome extends Model
{
	 protected $table="welcome";
     public $timestamps =true;




     protected $fillable = [
        'user_id', 'welcome_message', 'background_color', 'foreground_color', 'updated_by', 'is_delete'
    ];
}
