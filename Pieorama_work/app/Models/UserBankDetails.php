<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBankDetails extends Model
{
     protected $table="user_bank_details";

    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'bank_name', 'account_no', 'branch_name', 'branch_code', 'beneficiary_name', 'account_type'
    ];

}
