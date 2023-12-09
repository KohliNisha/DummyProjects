<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryUsed extends Model
{
    protected $table="library_used";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'media_id', 'library_id', 'status'
    ];

  
}
