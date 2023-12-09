<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PieFlavor extends Model
{
     protected $table="pie_flavor";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'p_name', 'p_img', 'portrait_img', 'landscape_img', 'type', 'status', 'created_by', 'chroma_key_id','landscape_img'
    ];

   

    public function pieFlavorCreatedBy(){
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    } 

     public function chroma_key_pieflavor(){
        return $this->hasMany('App\Models\ChromaKeys', 'pieflavor_id', 'id');
    }  
   
}
