<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the travel package that owns the transaction.
     */
    public function travelPackage()
    {
        return $this->belongsTo(TravelPackage::class);
    }

    /**
     * Get the user that owns the transaction.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transaction details for the transaction.
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
