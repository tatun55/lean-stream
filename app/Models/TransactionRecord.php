<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransactionRecord extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';

    // protected $fillable = [
    //     'transaction_date',
    //     'type',
    //     'amount',
    //     'user_id',
    //     'purpose',
    //     'note',
    //     'payment_due_date',
    //     'paid',
    // ];

    protected $guarded = [];


    protected $casts = [
        'transaction_date' => 'datetime',
        'payment_due_date' => 'date',
    ];

    protected $appends = ['type_name'];

    public function getTypeNameAttribute()
    {
        $types = [
            'withdrawal' => '出金',
            'deposit' => '入金',
            'other' => 'その他'
        ];
        return $types[$this->type] ?? '未定義';
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeSearch($query, string $search = '')
    {
        if (!empty($search)) {
            $query->where(function ($query) use ($search) {
                $query->where('purpose', 'like', "%{$search}%")
                    ->orWhere('note', 'like', "%{$search}%");
            });
        }
    }

    public function bank_account()
    {
        return $this->belongsTo(BankAccount::class);
    }
}
