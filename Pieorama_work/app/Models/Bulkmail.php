<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bulkmail extends Model
{
    protected $table="bulkmail";

    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','slug', 'subject', 'body', 'replace_vars','from'
    ];
}
