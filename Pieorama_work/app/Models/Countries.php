<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    protected $table="countries";

    public $timestamps =true;

     protected $fillable = [
        'name', 'iso_code', 'latitude','longitude','status','trash','created_at','updated_at'
    ];


    
}
