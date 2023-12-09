<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlTransaction extends Model
{
    protected $table="pl_transaction";

    public $timestamps =true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loan_id', 'user_id', 'repayment_schedule_id', 'gateway_transaction_id', 'transaction_type', 'transaction_amount', 'payment_status', 'status_text', 'reference_number', 'currency', 'token', 'account_no', 'receipt_number', 'created_by', 'updated_by', 'is_deleted', 'deleted_at'
    ];
}
