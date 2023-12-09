<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unsubscribe_users extends Model
{
    protected $table="unsubscribe_users";

    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'name','email','newsletter', 'status', 'is_delete'
    ];
}
