<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AudienceReactions extends Model
{
    protected $table="audience_reactions";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'url', 'type', 'status'
    ];

   

    public function AudeineceReactionsCreatedBy(){
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    } 
}
