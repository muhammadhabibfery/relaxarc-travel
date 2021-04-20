<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'travel_package_id', 'user_id', 'invoice_number', 'total', 'status', 'created_by', 'updated_by', 'deleted_by'
    ];

    public function travelPackage()
    {
        return $this->belongsTo(TravelPackage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
