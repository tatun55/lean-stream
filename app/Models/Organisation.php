<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Organisation extends Model
{
    use HasFactory;
    use SoftDeletes;

    const TYPES_LABEL = [
        'company' => '企業',
        'manshion_union' => 'マンション組合',
        'other' => 'その他',
    ];

    protected $appends = ['type_label'];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'type',
        'name',
        'url',
        'postal_code',
        'address',
        'tel',
        'note',
    ];

    /**
     * The "booting" method of the model.
     * 
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    public function staffList()
    {
        return $this->hasMany(User::class)->where('role', 'staff');
    }

    public function clients()
    {
        return $this->hasMany(User::class)->where('role', 'client');
    }

    public function getTypeLabelAttribute()
    {
        return self::TYPES_LABEL[$this->type];
    }

    public function line_bot()
    {
        return $this->hasOne(LineBot::class);
    }

    public function getAvatarAttribute($value)
    {
        return $value ?? 'img/organisation.png';
    }

    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class);
    }
}
