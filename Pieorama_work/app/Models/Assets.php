<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    protected $table="assets";

    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'org_name', 'file_name', 'path', 'mime','ext','module','user_id','document_id','is_temp','is_imported','import_url','import_unique_key','cloudinary_details','bytes',
    ];
}
