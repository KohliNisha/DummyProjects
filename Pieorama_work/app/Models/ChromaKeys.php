<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChromaKeys extends Model
{
    protected $table="chroma_keys";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'chromak_keys_img', 'sort_by', 'sort_portrait_img', 'sort_landscape_img', 'pieflavor_id' ,'created_by', 'updated_by', 'is_deleted', 'deleted_at', 'status',
    ];

    

    public function chromaKeysCreatedBy(){
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }   
}
