<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pieableMomentUses extends Model
{
    protected $table="pieable_moment_uses";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'pieable_id', 'created_by', 'updated_by', 'status', 'is_delete'
    ];
}
