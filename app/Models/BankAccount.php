<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    const TRANSACTION_TYPES = [
        'general' => '一般会計',
        'special' => '特別会計',
    ];

    const ACCOUNT_TYPES = [
        'savings' => '普通',
        'checking' => '当座',
        'other' => 'その他',
    ];

    protected $guarded = [];

    public function organisation()
    {
        return $this->belongsTo(Organisation::class);
    }

    public function transactionRecords()
    {
        return $this->hasMany(TransactionRecord::class);
    }

    public function getTransactionTypeLabelAttribute()
    {
        return self::TRANSACTION_TYPES[$this->transaction_type];
    }

    public function getAccountTypeLabelAttribute()
    {
        return self::ACCOUNT_TYPES[$this->account_type] ?? null;
    }
}
