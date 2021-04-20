<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_id', 'username', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
