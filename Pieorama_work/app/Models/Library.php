<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    protected $table="library";
    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'file_type', 'title', 'comment_note', 'library_tags', 'file_name', 'file_mime_type', 'file_size', 'updated_by', 'is_delete'
    ];

    public function usedlibrary()
    {
       return $this->hasMany('App\Models\LibraryUsed', 'library_id', 'id');
    }
}
